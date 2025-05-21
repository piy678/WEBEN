document.getElementById("editForm").addEventListener("submit", function (e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  //Formulardaten validieren
  fetch("../../Backend/logic/updateUser.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      document.getElementById("msg").textContent = data.message;

      if (data.success) {
        // Optional: Benutzer informieren
        alert(" Daten erfolgreich aktualisiert!");

        // Nach kurzer Pause zurück zur Kontoseite
        setTimeout(() => {
          window.location.href = "account.html";
        }, 1500);
      }
    })
    .catch(error => {
      console.error("Fehler beim Aktualisieren:", error);
      document.getElementById("msg").textContent = "Es ist ein Fehler aufgetreten.";
    });
});
