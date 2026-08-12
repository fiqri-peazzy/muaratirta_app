// PWA Installation and Update Manager
let deferredPrompt;
let updateAvailable = false;

// Register Service Worker
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker
      .register("/service-worker.js")
      .then((registration) => {
        console.log(
          "✅ Service Worker registered successfully:",
          registration.scope
        );

        // Check for updates
        registration.addEventListener("updatefound", () => {
          const newWorker = registration.installing;

          newWorker.addEventListener("statechange", () => {
            if (
              newWorker.state === "installed" &&
              navigator.serviceWorker.controller
            ) {
              updateAvailable = true;
              showUpdateNotification();
            }
          });
        });

        // Check for updates every hour
        setInterval(() => {
          registration.update();
        }, 3600000);
      })
      .catch((error) => {
        console.error("❌ Service Worker registration failed:", error);
      });
  });
}

// Listen for PWA install prompt
window.addEventListener("beforeinstallprompt", (e) => {
  e.preventDefault();
  
  deferredPrompt = e;
  showInstallButton();
});

// Show install button
function showInstallButton() {
  const installContainer = document.createElement("div");
  installContainer.id = "pwa-install-prompt";
  installContainer.innerHTML = `
    <div class="pwa-install-banner">
      <div class="pwa-install-content">
        <div class="pwa-install-icon">
          <i class="bi bi-download"></i>
        </div>
        <div class="pwa-install-text">
          <h4>Install Aplikasi PDAM MT</h4>
          <p>Akses lebih cepat dan bisa digunakan offline</p>
        </div>
      </div>
      <div class="pwa-install-actions">
        <button class="pwa-btn-install" onclick="installPWA()">
          <i class="bi bi-plus-circle"></i> Install
        </button>
        <button class="pwa-btn-dismiss" onclick="dismissInstallPrompt()">
          <i class="bi bi-x"></i>
        </button>
      </div>
    </div>
  `;

  // Check if already dismissed
  if (localStorage.getItem("pwa-install-dismissed") !== "true") {
    document.body.appendChild(installContainer);
    setTimeout(() => {
      installContainer.classList.add("show");
    }, 1000);
  }
}

// Install PWA
window.installPWA = async function () {
  if (!deferredPrompt) {
    return;
  }

  deferredPrompt.prompt();
  const { outcome } = await deferredPrompt.userChoice;

  console.log(`User response to install prompt: ${outcome}`);

  if (outcome === "accepted") {
    toastr.success("Aplikasi berhasil diinstall! 🎉");
  }

  deferredPrompt = null;
  document.getElementById("pwa-install-prompt")?.remove();
};

// Dismiss install prompt
window.dismissInstallPrompt = function () {
  localStorage.setItem("pwa-install-dismissed", "true");
  const prompt = document.getElementById("pwa-install-prompt");
  if (prompt) {
    prompt.classList.remove("show");
    setTimeout(() => prompt.remove(), 300);
  }
};

// Show update notification
function showUpdateNotification() {
  const updateNotif = document.createElement("div");
  updateNotif.id = "pwa-update-notif";
  updateNotif.innerHTML = `
    <div class="pwa-update-banner">
      <div class="pwa-update-icon">
        <i class="bi bi-arrow-clockwise"></i>
      </div>
      <div class="pwa-update-text">
        <strong>Update Tersedia</strong>
        <p>Versi baru aplikasi siap digunakan</p>
      </div>
      <button class="pwa-btn-update" onclick="updatePWA()">
        <i class="bi bi-download"></i> Update Sekarang
      </button>
    </div>
  `;

  document.body.appendChild(updateNotif);
  setTimeout(() => {
    updateNotif.classList.add("show");
  }, 300);
}

// Update PWA
window.updatePWA = function () {
  if (!updateAvailable) return;

  navigator.serviceWorker.getRegistration().then((registration) => {
    if (registration && registration.waiting) {
      registration.waiting.postMessage({ type: "SKIP_WAITING" });
    }
  });

  setTimeout(() => {
    window.location.reload();
  }, 500);
};

// Listen for service worker controller change
navigator.serviceWorker?.addEventListener("controllerchange", () => {
  if (updateAvailable) {
    window.location.reload();
  }
});

// Check if running as PWA
window.addEventListener("load", () => {
  const isPWA =
    window.matchMedia("(display-mode: standalone)").matches ||
    window.navigator.standalone === true;

  if (isPWA) {
    console.log("🚀 Running as PWA");
    document.body.classList.add("pwa-mode");

    // Add PWA badge
    addPWABadge();
  }
});

// Add PWA badge
function addPWABadge() {
  const badge = document.createElement("div");
  badge.className = "pwa-badge";
  badge.innerHTML = '<i class="bi bi-phone"></i> App Mode';
  document.body.appendChild(badge);

  setTimeout(() => {
    badge.classList.add("show");
  }, 1000);

  setTimeout(() => {
    badge.classList.remove("show");
  }, 5000);
}

// Handle online/offline status
window.addEventListener("online", () => {
  toastr.success("Koneksi internet tersambung kembali");
  document.body.classList.remove("offline-mode");
});

window.addEventListener("offline", () => {
  toastr.warning("Tidak ada koneksi internet. Mode offline aktif.");
  document.body.classList.add("offline-mode");
});

// Add to CSS
const pwaStyles = document.createElement("style");
pwaStyles.textContent = `
  /* PWA Install Banner */
  #pwa-install-prompt {
    position: fixed;
    bottom: -200px;
    left: 0;
    right: 0;
    z-index: 9999;
    padding: 15px;
    transition: bottom 0.3s ease;
  }
  
  #pwa-install-prompt.show {
    bottom: 20px;
  }
  
  .pwa-install-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    max-width: 600px;
    margin: 0 auto;
    animation: slideUp 0.3s ease;
  }
  
  .pwa-install-content {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
  }
  
  .pwa-install-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
  }
  
  .pwa-install-text h4 {
    margin: 0 0 5px 0;
    color: white;
    font-size: 16px;
    font-weight: 600;
  }
  
  .pwa-install-text p {
    margin: 0;
    color: rgba(255,255,255,0.9);
    font-size: 13px;
  }
  
  .pwa-install-actions {
    display: flex;
    gap: 10px;
    align-items: center;
  }
  
  .pwa-btn-install {
    background: white;
    color: #667eea;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
  }
  
  .pwa-btn-install:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,255,255,0.3);
  }
  
  .pwa-btn-dismiss {
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .pwa-btn-dismiss:hover {
    background: rgba(255,255,255,0.3);
  }
  
  /* PWA Update Banner */
  #pwa-update-notif {
    position: fixed;
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    transition: top 0.3s ease;
    width: 90%;
    max-width: 500px;
  }
  
  #pwa-update-notif.show {
    top: 20px;
  }
  
  .pwa-update-banner {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    display: flex;
    align-items: center;
    gap: 15px;
    animation: slideDown 0.3s ease;
  }
  
  .pwa-update-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
    animation: rotate 2s linear infinite;
  }
  
  .pwa-update-text {
    flex: 1;
    color: white;
  }
  
  .pwa-update-text strong {
    display: block;
    font-size: 16px;
    margin-bottom: 5px;
  }
  
  .pwa-update-text p {
    margin: 0;
    font-size: 13px;
    opacity: 0.9;
  }
  
  .pwa-btn-update {
    background: white;
    color: #f5576c;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    white-space: nowrap;
  }
  
  .pwa-btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255,255,255,0.3);
  }
  
  /* PWA Badge */
  .pwa-badge {
    position: fixed;
    top: -60px;
    right: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    z-index: 9998;
    transition: top 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
  }
  
  .pwa-badge.show {
    top: 20px;
  }
  
  /* Offline Mode Indicator */
  body.offline-mode::before {
    content: 'Mode Offline';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: #f59e0b;
    color: white;
    text-align: center;
    padding: 8px;
    font-size: 13px;
    font-weight: 600;
    z-index: 9997;
  }
  
  body.offline-mode {
    padding-top: 35px;
  }
  
  /* Animations */
  @keyframes slideUp {
    from {
      transform: translateY(100px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }
  
  @keyframes slideDown {
    from {
      transform: translateY(-100px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }
  
  @keyframes rotate {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
  
  /* Mobile Responsive */
  @media (max-width: 768px) {
    #pwa-install-prompt {
      padding: 10px;
    }
    
    .pwa-install-banner {
      flex-direction: column;
      text-align: center;
    }
    
    .pwa-install-content {
      flex-direction: column;
      text-align: center;
    }
    
    .pwa-install-actions {
      width: 100%;
      justify-content: center;
    }
    
    .pwa-update-banner {
      flex-direction: column;
      text-align: center;
    }
    
    .pwa-btn-update {
      width: 100%;
      justify-content: center;
    }
  }
`;
document.head.appendChild(pwaStyles);
