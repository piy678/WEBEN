function logout() {
    fetch("../../Backend/logic/logout.php")
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          window.location.href = "login.html"; // oder Startseite
        }
      })
      .catch(err => {
        console.error("Fehler beim Logout:", err);
      });
  }
  