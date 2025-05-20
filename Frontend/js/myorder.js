 
    document.addEventListener("DOMContentLoaded", () => {
      fetch("../../Backend/logic/getOrders.php")
        .then(res => res.json())
        .then(orders => {
          const container = document.getElementById("order-list");
          container.innerHTML = "";

          if (orders.length === 0) {
            container.innerHTML = "<p>Keine Bestellungen gefunden.</p>";
            return;
          }

          orders.forEach(order => {
            container.innerHTML += `
              <div>
                <strong>Bestellung #${order.id}</strong><br>
                Datum: ${order.created_at} – Gesamt: ${order.total_price} €<br>
                <button class="btn btn-primary btn-sm" onclick="showOrderDetails(${order.id})">Details</button>
                <button class="btn btn-secondary btn-sm"
  onclick="window.open('invoice.html?order_id=' + ${order.id}, '_blank')">
  Rechnung anzeigen
</button>
              </div>
              <hr>
            `;
          });
        })
        .catch(error => {
          console.error("Fehler beim Laden der Bestellungen:", error);
          document.getElementById("order-list").innerHTML = "Fehler beim Laden.";
        });
    });

    function showOrderDetails(orderId) {
      fetch(`../../Backend/logic/getOrderItems.php?order_id=${orderId}`)
    .then(res => res.json())
    .then(items => {
      if (items.length === 0) {
        alert("Keine Bestellpositionen gefunden.");
        return;
      }

      let msg = `Details für Bestellung #${orderId}:\n`;
      items.forEach(item => {
        msg += `- ${item.title} x ${item.quantity} = ${item.price}€\n`;
      });

      alert(msg);
    })
    .catch(err => {
      console.error("Fehler beim Laden der Bestellpositionen:", err);
      alert("Fehler beim Laden der Bestellpositionen.");
    });
}



