document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');
    if (!id) return;
  
    const res = await fetch(`../../backend/logic/getTickets.php`);
    const tickets = await res.json();
    const ticket = tickets.find(t => t.id == id);
    if (!ticket) return;
  
    // Felder füllen
    document.querySelector('[name="id"]').value = ticket.id;
    document.querySelector('[name="name"]').value = ticket.title;
    document.getElementById('previewImage').src = `../../backend/productpictures/${ticket.image}`;

    document.querySelector('[name="rating"]').value = ticket.description || "";
    document.querySelector('[name="category"]').value = ticket.category;
    document.querySelector('[name="rating"]').value = ticket.rating;
    document.querySelector('[name="price"]').value = ticket.price;
  });
  
  document.getElementById('editForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const res = await fetch('../../backend/logic/updateTicket.php', {
      method: 'POST',
      body: formData
    });
    const result = await res.json();
    document.getElementById('feedback').innerText = result.status === 'success' ? "Gespeichert!" : "Fehler!";
  });
  