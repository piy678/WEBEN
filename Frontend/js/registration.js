document.getElementById("registerForm").addEventListener("submit", async function (e) {
    e.preventDefault();
  //Passwortfeld und Passwortwiederholung
    const password = document.getElementById("password").value;
    const passwordRepeat = document.getElementById("passwordRepeat").value;
  //Passwörter vergleichen
    if (password !== passwordRepeat) {
      alert("Passwörter stimmen nicht überein");
      return;
    }
  // Überprüfen, ob alle Felder ausgefüllt sind wenn speichern
    const user = {
      vorname: document.getElementById("vorname").value,
      nachname: document.getElementById("nachname").value,
      adresse: document.getElementById("adresse").value,
      plz: document.getElementById("plz").value,
      ort: document.getElementById("ort").value,
      email: document.getElementById("email").value,
      benutzername: document.getElementById("benutzername").value,
      password,
      zahlung: document.getElementById("zahlung").value
    };
  //backend die User Daten senden
   fetch('../../Backend/logic/registration.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(user)
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        window.location.href = '../sites/login.html';
    } else {
        alert(data.message);
    }
});

      
  });
  