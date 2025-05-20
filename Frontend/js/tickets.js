function debounce(func, delay) {
  let timer;
  return function () {
    clearTimeout(timer);
    timer = setTimeout(() => func.apply(this, arguments), delay);
  };
}

document.addEventListener("DOMContentLoaded", loadTickets);

document.getElementById("category").addEventListener("change", loadTickets);
document.getElementById("search").addEventListener("input", debounce(loadTickets, 300));
document.getElementById("priceMin").addEventListener("input", debounce(loadTickets, 300));
document.getElementById("priceMax").addEventListener("input", debounce(loadTickets, 300));
document.getElementById("rating").addEventListener("change", loadTickets);
document.getElementById("onlyAvailable").addEventListener("change", loadTickets);


function loadTickets() {
  const category = document.getElementById("category").value;
  const search = document.getElementById("search").value;
  const minPrice = document.getElementById("priceMin").value;
  const maxPrice = document.getElementById("priceMax").value;
  const rating = document.getElementById("rating").value;
  const available = document.getElementById("onlyAvailable").checked ? 1 : 0;

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

  fetch(url)
    .then(res => res.json())
    .then(data => updateTicketList(data))
    .catch(err => {
      console.error("Fehler beim JSON-Parsing oder Laden:", err);
    });
}


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

    container.appendChild(col);
  });
}


function addToCart(id, title, price) {
  fetch("../../Backend/logic/addToCart.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, title, price, quantity: 1 })
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message || "Zum Warenkorb hinzugefügt!");
      if (typeof updateCartCount === "function") {
        updateCartCount();
      }
    })
    .catch(err => alert("Fehler beim Hinzufügen."));
}