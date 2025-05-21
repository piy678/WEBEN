function loadOrders() {
    fetch("../../Backend/logic/getOrders.php") 
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById("orders");
        container.innerHTML = "";
  //Bestellungen in HTML-Elemente umwandeln
        data.forEach(order => {
          container.innerHTML += `
            <div>
              <h3>Bestellung #${order.id}</h3>
              <p>Datum: ${order.created_at} – Gesamt: ${order.total_price} €</p>
              <button onclick="showOrderDetails(${order.id})">Details</button>
            </div>
          `;
        });
      });
  }
  //Bestellungs Positionen laden nach den Klick auf Details
  function showOrderDetails(orderId) {
    alert("Details für Bestellung " + orderId + " werden später angezeigt.");
  }
  