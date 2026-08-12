const CACHE_NAME = "pdam-muara-tirta-v1.0.4";
const OFFLINE_URL = "/offline.html";

// Files to cache
const urlsToCache = [
  "/",
  "/cek-tagihan",
  "/offline.html",
  "/assets/css/tagihan.css",
  "/assets/logo/Logo-PDAM-MT-min.ico",
  "/assets/logo/icon-192x192.png",
  "/assets/logo/icon-512x512.png",
//   "https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap",
//   "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js",
];

// Install event - cache files
self.addEventListener("install", (event) => {
  console.log("[Service Worker] Installing version (v.1.0.1)...");
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then((cache) => {
        console.log("[Service Worker] Caching app shell");
        return cache.addAll(urlsToCache);
      })
      .then(() => self.skipWaiting())
      .catch((error) => {
        console.error("[Service Worker] Cache installation failed:", error);
      })
  );
});

// Activate event - clean old caches
self.addEventListener("activate", (event) => {
  console.log("[Service Worker] Activating...");
  event.waitUntil(
    caches
      .keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheName !== CACHE_NAME) {
              console.log("[Service Worker] Deleting old cache:", cacheName);
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => self.clients.claim())
  );
});

// Path yang tidak boleh pernah di-cache: halaman admin, auth, dan API selalu
// harus fresh dari server (data dinamis & auth-gated, tidak aman/valid untuk di-cache).
const NEVER_CACHE_PATTERNS = [
  "/admin",
  "/login",
  "/logout",
  "/api/",
  "/forgot-password",
  "/reset-password",
];

// Fetch event - serve from cache, fallback to network
self.addEventListener("fetch", (event) => {
  // Skip cross-origin requests
  if (!event.request.url.startsWith(self.location.origin)) {
    return;
  }

  const requestPath = new URL(event.request.url).pathname;
  const isNeverCache =
    event.request.method !== "GET" ||
    NEVER_CACHE_PATTERNS.some((p) => requestPath.startsWith(p));

  if (isNeverCache) {
    // Network-only, tanpa sentuh cache sama sekali.
    event.respondWith(fetch(event.request));
    return;
  }

  event.respondWith(
    caches.match(event.request).then((response) => {
      // Cache hit - return response
      if (response) {
        return response;
      }

      // Clone the request
      const fetchRequest = event.request.clone();

      return fetch(fetchRequest)
        .then((response) => {
          // Check if valid response
          if (
            !response ||
            response.status !== 200 ||
            response.type !== "basic"
          ) {
            return response;
          }

          // Clone the response
          const responseToCache = response.clone();

          // Cache the new response for later
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });

          return response;
        })
        .catch(() => {
          // Network failed, return offline page for navigate requests
          if (event.request.mode === "navigate") {
            return caches.match(OFFLINE_URL);
          }
        });
    })
  );
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
