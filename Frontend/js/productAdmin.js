document.getElementById('productForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
  
    const response = await fetch('../../Backend/logic/addTicket.php', {
      method: 'POST',
      body: formData
    });
    const result = await response.json();
    document.getElementById('feedback').innerText = result.status === 'success' ? "Gespeichert!" : "Fehler!";
  });
  