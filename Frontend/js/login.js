// login.js – Login über fetch() mit JSON und Feedback

document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');

  // Beim Absenden des Formulars
  form.addEventListener('submit', function (e) {
    e.preventDefault(); // Standard-HTML-POST verhindern

    // Eingabewerte holen
    const login = document.getElementById('login').value.trim();
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    // Wenn Felder leer sind: Fehlermeldung anzeigen
    if (!login || !password) {
      alert('Bitte Benutzername/E-Mail und Passwort eingeben.');
      return;
    }

    // Daten als JSON-Objekt zusammenstellen
    const payload = {
      login: login,
      password: password,
      remember: remember
    };

    // AJAX-Request an das Backend schicken (JSON-Login)
    fetch('../../Backend/logic/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(payload)
    })
      .then(res => res.json()) // Antwort als JSON interpretieren
      .then(data => {
        if (data.success) {
          // Bei Erfolg zur passenden Seite weiterleiten
          window.location.href = data.redirect || '../sites/tickets.html';
        } else {
          // Bei Fehler Nachricht anzeigen
          alert(data.message || 'Login fehlgeschlagen.');
        }
      })
      .catch(err => {
        console.error('Fehler beim Login:', err);
        alert('Fehler beim Login – bitte später erneut versuchen.');
      });
  });
});
