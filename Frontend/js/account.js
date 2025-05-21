//Html user-data hinzufügen der Daten
document.addEventListener("DOMContentLoaded", () => {
  fetch("../../Backend/logic/getUserData.php")
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const user = data.user;
        document.getElementById("user-data").innerHTML = `
          <p><strong>Vorname:</strong> ${user.vorname}</p>
          <p><strong>Nachname:</strong> ${user.nachname}</p>
          <p><strong>E-Mail:</strong> ${user.email}</p>
          <p><strong>Adresse:</strong> ${user.adresse}</p>
          <p><strong>PLZ/Ort:</strong> ${user.plz} ${user.ort}</p>
          <p><strong>Zahlungsmethode:</strong> ${user.zahlungsmethode}</p>
        `;
      } else {
        document.getElementById("user-data").textContent = data.message;
      }
    });
});
