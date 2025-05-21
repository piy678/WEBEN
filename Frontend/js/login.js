// login.js
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');
//Wenn der Benutzer auf den Button klickt wird die Funktion aufgerufen und die Daten werden an das Backend gesendet
  form.addEventListener('submit', function (e) {
    const login = document.getElementById('login').value.trim();
    const password = document.getElementById('password').value;
//wenn login und password leer sind wird eine Fehlermeldung angezeigt
    if (!login || !password) {
      e.preventDefault();
      alert('Bitte Benutzername/E-Mail und Passwort eingeben.');
    }
  });
});
