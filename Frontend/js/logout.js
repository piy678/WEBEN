function logout() {
    fetch("../../Backend/logic/logout.php")
      .then(res => res.json()) // JSON-Antwort erwarten
      .then(data => { // Daten verarbeiten
          if (data.success) { // Wenn der Logout erfolgreich war
            window.location.href = "../Frontend\sites\index.php"; // zur Startseite weiterleiten
          }
        }) // Fehlerbehandlung
        .catch(err => {
          console.error("Fehler beim Logout:", err);
        });
  }
  