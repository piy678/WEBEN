document.addEventListener('DOMContentLoaded', async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const id = urlParams.get('id');
  if (!id) return;

  try {
    // Ticket laden
    const res = await fetch(`../../Backend/logic/getTickets.php`);
    const tickets = await res.json();
    const ticket = tickets.find(t => t.id == id);
    if (!ticket) return;

    // Felder füllen
    document.querySelector('[name="id"]').value = ticket.id;
    document.querySelector('[name="name"]').value = ticket.title;
    document.getElementById('previewImage').src = `../../backend/productpictures/${ticket.image}`;
    document.querySelector('[name="description"]').value = ticket.description || "";
    document.querySelector('[name="category"]').value = ticket.category.toLowerCase(); 
    document.querySelector('[name="rating"]').value = ticket.rating;
    document.querySelector('[name="price"]').value = ticket.price;
    document.querySelector('[name="currentImage"]').value = ticket.image;
  } catch (err) {
    console.error("Fehler beim Laden des Tickets:", err);
    document.getElementById('feedback').innerText = "Fehler beim Laden der Daten.";
  }
});
// Formular absenden
document.getElementById('editForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const fileInput = e.target.querySelector('[name="image"]');
  
  // Sicherstellen, dass Datei gültig ist
  if (fileInput.files.length > 0 && !fileInput.files[0]) {
    document.getElementById('feedback').innerText = 'Fehler: Bilddatei ist nicht mehr verfügbar.';
    return;
  }
//Daten Formdata erstellen
  const formData = new FormData(e.target);
  try {
    const res = await fetch('../../backend/logic/updateTicket.php', {
      method: 'POST',
      body: formData
    });
// Antwort verarbeiten
    const result = await res.json();
    console.log("Serverantwort:", result);
    // Feedback anzeigen
    document.getElementById('feedback').innerText =
    document.getElementById('feedback').innerText =
    result.status === 'success' ? "Gespeichert!" : `Fehler: ${result.message || "Unbekannter Fehler"}`;
//nach Admin-Seite weiterleiten
  if (result.status === 'success') {
    window.location.href = 'products_admin.php';
  }
  } catch (err) {
    console.error("Fehler beim Senden des Formulars:", err);
    document.getElementById('feedback').innerText = "Netzwerkfehler oder Server nicht erreichbar.";
  }
  
}
);

