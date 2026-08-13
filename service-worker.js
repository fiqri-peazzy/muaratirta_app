// Service worker ini SENGAJA tidak melakukan caching apa pun (pass-through murni).
// Tetap didaftarkan (bukan dihapus) supaya syarat teknis "Add to Home Screen" /
// beforeinstallprompt tetap terpenuhi di browser, tapi setiap request selalu
// diteruskan langsung ke network - tidak ada satupun response yang disimpan
// atau disajikan dari Cache Storage. Ini memastikan perubahan di server selalu
// langsung terlihat tanpa perlu hard-refresh.
const CACHE_NAME = "pdam-muara-tirta-nocache-v1";

// Install: tidak precache apa pun, langsung aktif.
self.addEventListener("install", (event) => {
  self.skipWaiting();
});

// Activate: hapus SEMUA cache dari versi manapun (termasuk versi cache-first
// lama yang mungkin sudah tersimpan di browser user), lalu ambil alih kontrol.
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches
      .keys()
      .then((cacheNames) => Promise.all(cacheNames.map((name) => caches.delete(name))))
      .then(() => self.clients.claim())
  );
});

// Fetch: selalu ke network, tidak pernah sentuh Cache Storage.
self.addEventListener("fetch", (event) => {
  event.respondWith(fetch(event.request));
});

// Background sync for offline form submissions
self.addEventListener("sync", (event) => {
  if (event.tag === "sync-tagihan") {
    event.waitUntil(syncTagihan());
  }
});

function syncTagihan() {
  return new Promise((resolve) => {
    // Add your sync logic here
    console.log("[Service Worker] Syncing tagihan data...");
    resolve();
  });
}

// Push notification handler
self.addEventListener("push", (event) => {
  const data = event.data ? event.data.json() : {};
  const title = data.title || "PDAM Muara Tirta";
  const options = {
    body: data.body || "Ada tagihan baru yang perlu dibayar",
    icon: "/assets/logo/icon-192x192.png",
    badge: "/assets/logo/icon-72x72.png",
    vibrate: [200, 100, 200],
    tag: "pdam-notification",
    requireInteraction: false,
    data: {
      url: data.url || "/cek-tagihan",
    },
  };

  event.waitUntil(self.registration.showNotification(title, options));
});

// Notification click handler
self.addEventListener("notificationclick", (event) => {
  event.notification.close();
  event.waitUntil(clients.openWindow(event.notification.data.url));
});

// Message handler from client
self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});
