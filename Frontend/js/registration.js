document.getElementById("registerForm").addEventListener("submit", async function (e) {
    e.preventDefault();
  
    const password = document.getElementById("password").value;
    const passwordRepeat = document.getElementById("passwordRepeat").value;
  
    if (password !== passwordRepeat) {
      alert("Passwörter stimmen nicht überein");
      return;
    }
  
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
  
    fetch("http://localhost/Projekt/ProjektGruppe28/Backend/logic/registration.php", {

        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(user)
      })
      .then(res => res.text()) // NICHT sofort .json()
.then(txt => {
  console.log("🔍 Antwort vom Server (raw):", txt); // <-- Wichtig!
})
.catch(err => {
  console.error("Fehler bei der Registrierung:", err);
});
      
  });
  