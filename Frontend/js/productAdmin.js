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

  async function loadTickets() {
    const res = await fetch('../../Backend/logic/getTickets.php');
    const tickets = await res.json();
    const list = document.getElementById('ticketList');
    
    list.innerHTML = tickets.map(t => `
      <div class="card p-2 mb-2">
        <strong>${t.title}</strong> (${t.category}) – ${t.price} €<br>
        Bewertung: ${t.rating}<br>
        <img src="../../backend/productpictures/${t.image}" width="100"><br>
  
        <button class="btn btn-sm btn-warning mt-1" onclick="editTicket(${t.id}, '${t.title}', '${t.category}', ${t.price}, ${t.rating}, '${t.image}')">Bearbeiten</button>
        <button class="btn btn-sm btn-danger mt-1" onclick="deleteTicket(${t.id})">Löschen</button>
      </div>
    `).join('');
  }

  
  async function deleteTicket(id) {
    if (!confirm("Wirklich löschen?")) return;
  
    await fetch('../../Backend/logic/deleteTicket.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + id
    });
    loadTickets();
  }
  
  function editTicket(id, title, category, price, rating, image) {
    document.querySelector('form').innerHTML += `
      <input type="hidden" name="id" value="${id}">
      <input type="hidden" name="currentImage" value="${image}">
      <button type="submit" class="btn btn-success">Änderung speichern</button>
    `;
    document.querySelector('[name="name"]').value = title;
    document.querySelector('[name="category"]').value = category;
    document.querySelector('[name="price"]').value = price;
    document.querySelector('[name="rating"]').value = rating;
  }
  
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
  
    e.target.reset();
    loadTickets();
  });
  