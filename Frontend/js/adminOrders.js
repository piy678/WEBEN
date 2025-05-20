document.addEventListener("DOMContentLoaded", () => {
  const userId = new URLSearchParams(window.location.search).get("user_id");
  if (!userId) return;

  fetch(`../../Backend/logic/getOrdersByUser.php?user_id=${userId}`)
    .then(res => res.json())
    .then(orders => {
      const container = document.getElementById("order-container");
      if (!orders.length) {
        container.innerHTML = "<p>Keine Bestellungen gefunden.</p>";
        return;
      }

     orders.forEach(order => {
  const div = document.createElement("div");
  div.className = "card mb-3 p-3";
  div.innerHTML = `
    <strong>Bestellung #${order.id}</strong><br>
    Datum: ${order.created_at} – 
    <span class="order-total">Gesamt: ${order.total_price} €</span><br>
    <button class="btn btn-sm btn-outline-primary mt-2" onclick="loadOrderItems(${order.id})">Details</button>
    <div id="items-${order.id}" class="ms-3 mt-2"></div>
  `;
  div.id = `order-${order.id}`; // NEU: für updateTotalDisplay()
  container.appendChild(div);
});

    });
});

function loadOrderItems(orderId) {
  fetch(`../../Backend/logic/getOrderItemsAdmin.php?order_id=${orderId}`)
    .then(res => res.json())
    .then(items => {
      const container = document.getElementById("items-" + orderId);
      if (!items.length) {
        container.innerHTML = "<em>Keine Positionen gefunden.</em>";
        updateTotalDisplay(orderId, 0);
        return;
      }

      let html = "<ul>";
      let newTotal = 0;

      items.forEach(item => {
        const line = item.price * item.quantity;
        newTotal += line;

        html += `
          <li>
            ${item.title} × ${item.quantity} = ${line.toFixed(2)} €
            <button class="btn btn-sm btn-danger ms-2" onclick="deleteOrderItem(${item.id}, ${orderId})">Entfernen</button>
          </li>`;
      });

      html += "</ul>";
      container.innerHTML = html;

      updateTotalDisplay(orderId, newTotal); 
    });
}


function deleteOrderItem(itemId, orderId) {
  fetch(`../../Backend/logic/deleteOrderItem.php?item_id=${itemId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        loadOrderItems(orderId);
      } else {
        alert("Löschen fehlgeschlagen.");
      }
    })
    .catch(() => alert("Fehler beim Löschen."));
}


function updateTotalDisplay(orderId, newTotal) {
  const orderCard = document.getElementById(`order-${orderId}`);
  if (!orderCard) return;

  const totalSpan = orderCard.querySelector(".order-total");
  if (totalSpan) {
    totalSpan.textContent = `Gesamt: ${newTotal.toFixed(2)} €`;
  }
}
