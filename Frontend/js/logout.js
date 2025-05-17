function logout() {
    fetch("../../Backend/logic/logout.php")
      .then(res => res.json())
      .then(data => {
          if (data.success) {
            window.location.href = "../Frontend\sites\index.html"; // 
          }
        })
        .catch(err => {
          console.error("Fehler beim Logout:", err);
        });
  }
  