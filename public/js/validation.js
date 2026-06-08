// public/js/validation.js
function validateBookingForm(event) {
    const form = event.target;
    const nama = form.elements['nama_customer'];
    const email = form.elements['email'];
    const telp = form.elements['no_whatsapp'];
    const jumlah = form.elements['jumlah'];
    let valid = true;
    clearErrors(form);
    if (!nama || !nama.value.trim()) { showError(nama, 'Nama wajib diisi'); valid = false; }
    if (!email || !email.value.trim() || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.value)) { showError(email, 'Email tidak valid'); valid = false; }
    if (!telp || !telp.value.trim() || !/^\d{10,15}$/.test(telp.value)) { showError(telp, 'No. WhatsApp harus angka (10‑15 digit)'); valid = false; }
    if (!jumlah || !jumlah.value.trim() || isNaN(jumlah.value) || Number(jumlah.value) <= 0) { showError(jumlah, 'Jumlah tiket harus angka > 0'); valid = false; }
    if (!valid) { event.preventDefault(); }
}
function validateRegisterForm(event) {
    const form = event.target;
    const email = form.elements['email'];
    const password = form.elements['password'];
    const confirm = form.elements['confirm_password'];
    let valid = true;
    clearErrors(form);
    if (!email || !email.value.trim() || !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email.value)) { showError(email, 'Email tidak valid'); valid = false; }
    if (!password || password.value.length < 6) { showError(password, 'Password minimal 6 karakter'); valid = false; }
    if (!confirm || password.value !== confirm.value) { showError(confirm, 'Konfirmasi password tidak cocok'); valid = false; }
    if (!valid) { event.preventDefault(); }
}
function clearErrors(form) {
    const msgs = form.querySelectorAll('.error-msg');
    msgs.forEach(m => m.textContent = '');
}
function showError(input, msg) {
    if (!input) return;
    let span = input.parentNode.querySelector('.error-msg');
    if (!span) {
        span = document.createElement('span');
        span.className = 'error-msg';
        span.style.color = 'crimson';
        input.parentNode.appendChild(span);
    }
    span.textContent = msg;
}

document.addEventListener('DOMContentLoaded', () => {
    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) bookingForm.addEventListener('submit', validateBookingForm);
    const registerForm = document.getElementById('register-form');
    if (registerForm) registerForm.addEventListener('submit', validateRegisterForm);
});
