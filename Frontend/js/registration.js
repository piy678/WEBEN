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
  