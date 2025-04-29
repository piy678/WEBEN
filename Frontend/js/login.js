// login.js
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');

  form.addEventListener('submit', function (e) {
    const login = document.getElementById('login').value.trim();
    const password = document.getElementById('password').value;

    if (!login || !password) {
      e.preventDefault();
      alert('Bitte Benutzername/E-Mail und Passwort eingeben.');
    }
  });
});
