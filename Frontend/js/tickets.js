function debounce(func, delay) { //Funktion: verhindert zu häufiges Aufrufen von loadTickets bei schnellem Tippen
  let timer;
  return function () {
    clearTimeout(timer); // alten Timer löschen, falls Nutzer weiter tippt
    timer = setTimeout(() => func.apply(this, arguments), delay); // neue Ausführung verzögert starten
  };
}
//Beim Laden der Seite sofort Tickets anzeigen
document.addEventListener("DOMContentLoaded", loadTickets);
//Filter-Elemente
document.getElementById("category").addEventListener("change", loadTickets);
document.getElementById("search").addEventListener("input", debounce(loadTickets, 300));
document.getElementById("priceMin").addEventListener("input", debounce(loadTickets, 300));
document.getElementById("priceMax").addEventListener("input", debounce(loadTickets, 300));
document.getElementById("rating").addEventListener("change", loadTickets);
document.getElementById("onlyAvailable").addEventListener("change", loadTickets);

//Tickets Anzeigen 
function loadTickets() { //Werte aus den Filterfeldern lesen
  const category = document.getElementById("category").value;
  const search = document.getElementById("search").value;
  const minPrice = document.getElementById("priceMin").value;
  const maxPrice = document.getElementById("priceMax").value;
  const rating = document.getElementById("rating").value;
  const available = document.getElementById("onlyAvailable").checked ? 1 : 0;
//Werte aus der URL holen und an das Backend senden
  const params = new URLSearchParams({
    category,
    search,
    minPrice,
    maxPrice,
    rating,
    available
  });

  const url = "../../Backend/logic/getTickets.php?" + params.toString();
  console.log("→ Anfrage an:", url); 
//Warenkorb Anfrage an Backend schicken und Tickets anzeigen
  fetch(url)
    .then(res => res.json())
    .then(data => updateTicketList(data))
    .catch(err => {
      console.error("Fehler beim JSON-Parsing oder Laden:", err);
    });
}

//Ticketliste im HTML anzeigen
function updateTicketList(data) {
  const container = document.getElementById("ticket-list");
  container.innerHTML = "";

  if (data.length === 0) {
    container.innerHTML = "<p>Keine Tickets gefunden.</p>";
    return;
  }

  container.className = "row"; // Bootstrap Row für Grid-Layout

  data.forEach(ticket => {
    const col = document.createElement("div");
    col.className = "col-md-4 mb-4"; // Jede Karte nimmt 1/3 Breite auf Desktop

    const imagePath = ticket.image && ticket.image.trim() !== ""
      ? `../../Backend/productpictures/${ticket.image}`
      : "../res/img/placeholder.jpg";
//HTML-Karte zusammenbauen
    col.innerHTML = `
      <div class="card h-100 shadow-sm">
        <img src="${imagePath}" class="card-img-top" alt="${ticket.title}">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">${ticket.title}</h5>
          <p class="card-text"><strong>${ticket.price} €</strong><br>${ticket.rating}★ Bewertung</p>
          <div class="mt-auto">
            <button class="btn btn-primary w-100" onclick="addToCart(${ticket.id}, '${ticket.title}', ${ticket.price})">
              In den Warenkorb
            </button>
          </div>
        </div>
      </div>
    `;
// zur Seite hinzufügen
    container.appendChild(col);
  });
}

//Tickets in den Warenkorb hinzufügen
function addToCart(id, title, price) {
  fetch("../../Backend/logic/addToCart.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, title, price, quantity: 1 })
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message || "Zum Warenkorb hinzugefügt!");
      if (typeof updateCartCount === "function") { // Zähler im Header aktualisieren, wenn Funktion existiert
        updateCartCount();
      }
    })
    .catch(err => alert("Fehler beim Hinzufügen."));
}