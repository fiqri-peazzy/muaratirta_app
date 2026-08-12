/**
 * Chat Assistant JavaScript
 * PDAM Muaratirta Gorontalo
 */

// Global variables
let sessionId = generateSessionId();
let modalCekTagihan, modalPengaduan;

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Initialize modals
  modalCekTagihan = new bootstrap.Modal(
    document.getElementById("modalCekTagihan")
  );
  modalPengaduan = new bootstrap.Modal(
    document.getElementById("modalPengaduan")
  );

  // Event listeners
  document
    .getElementById("chatWidgetBtn")
    .addEventListener("click", toggleChat);
  document.getElementById("closeChatBtn").addEventListener("click", toggleChat);
  document.getElementById("sendBtn").addEventListener("click", sendMessage);
  document
    .getElementById("messageInput")
    .addEventListener("keypress", function (e) {
      if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

  // Auto resize textarea
  const textarea = document.getElementById("messageInput");
  textarea.addEventListener("input", function () {
    this.style.height = "auto";
    this.style.height = Math.min(this.scrollHeight, 100) + "px";
  });
});

// Generate unique session ID
function generateSessionId() {
  return (
    "session_" + Date.now() + "_" + Math.random().toString(36).substr(2, 9)
  );
}

// Toggle chat window
function toggleChat() {
  const chatWindow = document.getElementById("chatWindow");
  const notificationBadge = document.getElementById("notificationBadge");

  chatWindow.classList.toggle("active");

  if (chatWindow.classList.contains("active")) {
    notificationBadge.style.display = "none";
    document.getElementById("messageInput").focus();
    scrollToBottom();
  }
}

// Send message
async function sendMessage() {
  const messageInput = document.getElementById("messageInput");
  const message = messageInput.value.trim();

  if (!message) return;

  // Add user message to chat
  addMessage(message, "user");

  // Clear input
  messageInput.value = "";
  messageInput.style.height = "auto";

  // Show typing indicator
  showTypingIndicator();

  try {
    // Send to API
    const apiPath =
      (typeof BASE_URL !== "undefined" ? BASE_URL : "..") +
      "/api/chat-handler.php";
    const response = await fetch(apiPath, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        message: message,
        session_id: sessionId,
      }),
    });

    const data = await response.json();

    // Remove typing indicator
    removeTypingIndicator();

    if (data.success) {
      // Add bot response
      addMessage(data.message, "bot");

      // Check intent for special actions
      handleIntent(data.intent);
    } else {
      addMessage("Maaf, terjadi kesalahan. Silakan coba lagi.", "bot");
    }
  } catch (error) {
    removeTypingIndicator();
    addMessage("Maaf, koneksi bermasalah. Silakan coba lagi.", "bot");
    console.error("Error:", error);
  }
}

// Add message to chat
function addMessage(text, type) {
  const chatBody = document.getElementById("chatBody");
  const messageDiv = document.createElement("div");
  messageDiv.className = `message ${type}-message`;

  const avatar = document.createElement("div");
  avatar.className = "message-avatar";
  avatar.innerHTML =
    type === "bot"
      ? '<i class="bi bi-robot"></i>'
      : '<i class="bi bi-person-fill"></i>';

  const content = document.createElement("div");
  content.className = "message-content";

  // Convert line breaks to <br> and preserve formatting
  const formattedText = text.replace(/\n/g, "<br>");
  content.innerHTML = formattedText;

  messageDiv.appendChild(avatar);
  messageDiv.appendChild(content);
  chatBody.appendChild(messageDiv);

  scrollToBottom();
}

// Show typing indicator
function showTypingIndicator() {
  const chatBody = document.getElementById("chatBody");
  const typingDiv = document.createElement("div");
  typingDiv.className = "message bot-message";
  typingDiv.id = "typingIndicator";

  const avatar = document.createElement("div");
  avatar.className = "message-avatar";
  avatar.innerHTML = '<i class="bi bi-robot"></i>';

  const indicator = document.createElement("div");
  indicator.className = "typing-indicator";
  indicator.innerHTML = "<span></span><span></span><span></span>";

  typingDiv.appendChild(avatar);
  typingDiv.appendChild(indicator);
  chatBody.appendChild(typingDiv);

  scrollToBottom();
}

// Remove typing indicator
function removeTypingIndicator() {
  const indicator = document.getElementById("typingIndicator");
  if (indicator) {
    indicator.remove();
  }
}

// Scroll chat to bottom
function scrollToBottom() {
  const chatBody = document.getElementById("chatBody");
  chatBody.scrollTop = chatBody.scrollHeight;
}

// Handle intent-specific actions
function handleIntent(intent) {
  // Currently no automatic actions, but can be extended
  console.log("Intent detected:", intent);
}

// Show Cek Tagihan Modal
function showCekTagihan() {
  modalCekTagihan.show();
  document.getElementById("hasilTagihan").innerHTML = "";
  document.getElementById("noPelangganTagihan").value = "";
}

// Cek Tagihan
async function cekTagihan() {
  const noPelanggan = document
    .getElementById("noPelangganTagihan")
    .value.trim();
  const hasilDiv = document.getElementById("hasilTagihan");

  if (!noPelanggan) {
    hasilDiv.innerHTML =
      '<div class="alert alert-warning">Masukkan nomor pelanggan</div>';
    return;
  }

  hasilDiv.innerHTML =
    '<div class="loading"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Mengecek tagihan...</p></div>';

  try {
    const formData = new FormData();
    formData.append("id_pel", noPelanggan);

    const apiPath =
      (typeof BASE_URL !== "undefined" ? BASE_URL : "..") +
      "/api/get-tagihan-detail.php";
    const response = await fetch(apiPath, {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (
      data.status !== "true" ||
      !data.pelanggan ||
      data.pelanggan.length === 0
    ) {
      hasilDiv.innerHTML =
        '<div class="alert alert-danger">Data tidak ditemukan. Periksa kembali nomor pelanggan Anda.</div>';
      return;
    }

    // Display tagihan info
    let html =
      '<div class="tagihan-results" style="max-height: 400px; overflow-y: auto;">';

    // Basic Info header from first record
    const info = data.pelanggan[0];
    html += `<div class="card mb-3 border-primary">
                    <div class="card-body py-2 px-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="mb-0 text-primary"><i class="bi bi-person-badge me-2"></i>Data Pelanggan</h6>
                        </div>
                        <div class="small">
                            <div class="d-flex justify-content-between"><span>Nama:</span><strong>${info.NAMA}</strong></div>
                            <div class="d-flex justify-content-between"><span>No. Samb:</span><strong>${info.NOSAMW}</strong></div>
                            <div class="d-flex justify-content-between"><span>Alamat:</span><strong>${info.ALAMAT}</strong></div>
                        </div>
                    </div>
                </div>`;

    html += '<h6><i class="bi bi-file-text"></i> Daftar Tagihan Keluar</h6>';

    data.pelanggan.forEach((item) => {
      html += '<div class="tagihan-card mb-2">';
      html += '<div class="tagihan-info">';
      html += `<div class="tagihan-item"><label>Periode</label><strong>${
        item.PERIODE || "-"
      }</strong></div>`;
      html += `<div class="tagihan-item"><label>Stand Meter</label><strong>${item.METER_LALU} - ${item.METER_KINI} m³</strong></div>`;
      html += `<div class="tagihan-item"><label>Pemakaian</label><strong>${
        item.PAKAI || "-"
      } m³</strong></div>`;
      html += `<div class="tagihan-item"><label>Tagihan</label><strong class="text-primary">Rp ${formatRupiah(
        item.TAGIHAN || 0
      )}</strong></div>`;
      html += "</div></div>";
    });

    html += "</div>";

    hasilDiv.innerHTML = html;

    // Send info to chat
    const totalUnpaid = data.pelanggan.length;
    const totalBill = data.pelanggan.reduce(
      (sum, item) => sum + parseInt(item.TAGIHAN || 0),
      0
    );

    addMessage(
      `Halo, untuk pelanggan ${
        info.NAMA
      } (${noPelanggan}), ditemukan ${totalUnpaid} catatan tagihan dengan total Rp ${formatRupiah(
        totalBill
      )}.`,
      "bot"
    );
  } catch (error) {
    hasilDiv.innerHTML =
      '<div class="alert alert-danger">Terjadi kesalahan saat mengambil data. Silakan coba lagi.</div>';
    console.error("Error:", error);
  }
}

// Show Form Pengaduan Modal
function showFormPengaduan() {
  modalPengaduan.show();
  document.getElementById("formPengaduan").reset();
}

// Submit Pengaduan
async function submitPengaduan() {
  const form = document.getElementById("formPengaduan");

  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  const formData = new FormData(form);
  const submitBtn = event.target;
  submitBtn.disabled = true;
  submitBtn.innerHTML =
    '<span class="spinner-border spinner-border-sm me-2"></span>Mengirim...';

  try {
    const apiPath =
      (typeof BASE_URL !== "undefined" ? BASE_URL : "..") +
      "/api/submit-pengaduan-chat.php";
    const response = await fetch(apiPath, {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (data.success) {
      // Close modal
      modalPengaduan.hide();

      // Show success message in chat
      addMessage(
        "Pengaduan Anda berhasil dikirim! Tim kami akan segera menindaklanjuti. Nomor pengaduan: #" +
          data.id,
        "bot"
      );

      // Reset form
      form.reset();

      // Show success alert
      showAlert("success", "Pengaduan berhasil dikirim!");
    } else {
      showAlert("danger", data.message || "Gagal mengirim pengaduan");
    }
  } catch (error) {
    showAlert("danger", "Terjadi kesalahan. Silakan coba lagi.");
    console.error("Error:", error);
  } finally {
    submitBtn.disabled = false;
    submitBtn.innerHTML = "Kirim Pengaduan";
  }
}

// Format Rupiah
function formatRupiah(angka) {
  return new Intl.NumberFormat("id-ID").format(angka);
}

// Show Alert
function showAlert(type, message) {
  const alertDiv = document.createElement("div");
  alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
  alertDiv.style.zIndex = "9999";
  alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

  document.body.appendChild(alertDiv);

  setTimeout(() => {
    alertDiv.remove();
  }, 5000);
}

// Auto-show chat on first visit (optional)
window.addEventListener("load", function () {
  // Uncomment to auto-show on first visit
  if (!localStorage.getItem("chatShown")) {
    setTimeout(() => {
      toggleChat();
      localStorage.setItem("chatShown", "true");
    }, 2000);
  }
});
