document.addEventListener("DOMContentLoaded", loadCartSummary);

function loadCartSummary() {
  fetch("../../backend/logic/getCartItems.php")
    .then(res => res.json())
    .then(cart => {
      const container = document.getElementById("cart-summary");
      let total = 0;
      container.innerHTML = "";

      cart.forEach(item => {
        total += item.price * item.quantity;
        container.innerHTML += `
          <div>${item.title} - ${item.quantity} x ${item.price}€</div>
        `;
      });

      document.getElementById("total-price").textContent = total.toFixed(2) + " €";
    });
}

function applyVoucher() {
  const code = document.getElementById("voucher").value;

  // Aktuellen Preis extrahieren (aus dem DOM, z. B. "19.99 €" → 19.99)
  const priceText = document.getElementById("total-price").textContent;
  const total = parseFloat(priceText.replace("€", "").trim());

  fetch("../../Backend/logic/useVoucher.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ code, total })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Gutschein eingelöst!");
        document.getElementById("total-price").textContent = data.newTotal + " €";
      } else {
        alert(data.message);
      }
    });
}


function submitOrder() {
  fetch("../../Backend/logic/submitOrder.php", { method: "POST" })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Bestellung erfolgreich!");
        window.location.href = "myorders.html"; // Weiterleitung zur Bestellübersicht
      } else {
        alert(data.message);
      }
    });
}
