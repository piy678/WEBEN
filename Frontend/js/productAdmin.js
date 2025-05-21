window.addEventListener('DOMContentLoaded', loadTickets);

  async function loadTickets() {
    const res = await fetch('../../Backend/logic/getTickets.php');
    const tickets = await res.json();
    const list = document.getElementById('ticketList');
    //Tickets in HTML umwandeln anzeigen mit Bild es löschen können und bearbeiten 
    list.innerHTML = tickets.map(t => `
      <div class="card p-2 mb-2"> 
        <strong>${t.title}</strong> (${t.category}) – ${t.price} €<br>
        Bewertung: ${t.rating}<br>
        <img src="../../Backend/productpictures/${t.image}" width="100"><br>
  
        <button class="btn btn-warning" onclick="window.location.href='edit_ticket.html?id=${t.id}'">Bearbeiten</button>
        <button class="btn btn-sm btn-danger mt-1" onclick="deleteTicket(${t.id})">Löschen</button>
      </div>
    `).join('');
  }

  //Ticket löschen
  async function deleteTicket(id) {
    if (!confirm("Wirklich löschen?")) return;
  
    await fetch('../../Backend/logic/deleteTicket.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + id
    });
    loadTickets();
  }
  
  //Ticket erstellen oder aktualisieren
  document.getElementById('productForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const isUpdate = formData.has('id');
    const endpoint = isUpdate ? 'updateTicket.php' : 'addTicket.php';
  
    const response = await fetch('../../Backend/logic/' + endpoint, {
      method: 'POST',
      body: formData
    });
    const result = await response.json();
    document.getElementById('feedback').innerText = result.status;
  //Formular wird geleert
    e.target.reset();
const form = document.getElementById('productForm');
form.querySelectorAll('input[name="id"], input[name="currentImage"]').forEach(el => el.remove());

    loadTickets();
  });
  