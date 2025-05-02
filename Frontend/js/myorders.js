function loadOrders() {
    fetch("../../Backend/logic/getOrders.php")
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById("orders");
        container.innerHTML = "";
  
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
  
  function showOrderDetails(orderId) {
    // TODO: hier kannst du fetch machen zu z.B. getOrderItems.php?orderId=...
    alert("Details für Bestellung " + orderId + " werden später angezeigt.");
  }
  