
document.addEventListener("DOMContentLoaded", loadCartSummary);
//den Warenkorb laden und die Daten anzeigen
function loadCartSummary() {
  fetch("../../Backend/logic/getCartItems.php")
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
//Gutschein anwenden
function applyVoucher() {
  const code = document.getElementById("voucher").value;

  // Aktuellen Preis extrahieren (aus dem DOM, z. B. "19.99 €" → 19.99)
  const priceText = document.getElementById("total-price").textContent;
  const total = parseFloat(priceText.replace("€", "").trim());
//Gutschein an Backend senden
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

//Bestellung abschicken
function submitOrder() {
  const paymentMethod = document.getElementById("payment-method").value;

  if (!paymentMethod) {
    alert("Bitte wählen Sie eine Zahlungsart.");
    return;
  }

  fetch("../../Backend/logic/submitOrder.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ payment: paymentMethod })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Bestellung erfolgreich!");
        window.location.href = "myorders.html";
      } else {
        alert(data.message);
      }
    });
}

