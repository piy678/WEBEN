//Produkte im Warenkorb angezeigen
document.addEventListener("DOMContentLoaded", function () {
  loadCart();
});

//alle Produkte im Warenkorb zurückgeben, Produkte aus dem Backend laden und anzeigen
function loadCart() {
  fetch("../../Backend/logic/getCartItems.php")
  .then(res => res.text())
  .then(txt => {
    console.log("Antwort vom Server:", txt);  // was PHP zurückgibt
    const data = JSON.parse(txt); 
      const container = document.getElementById("cart-items");
      container.innerHTML = "";

      if (!data.length) {
        container.innerHTML = "<p>Dein Warenkorb ist leer.</p>";
        document.getElementById("total-price").textContent = "0 €";
        return;
      }

      let total = 0;

      data.forEach(function (item) {
        total += item.price * item.quantity;

        container.innerHTML += `
  <div class="cart-item">
    <strong>${item.title}</strong> - ${item.price} € x ${item.quantity}
    <div class="cart-buttons mt-2">
      <button class="btn btn-sm btn-success me-1" onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
      <button class="btn btn-sm btn-success me-1" onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
      <button class="btn btn-sm btn-danger" onclick="removeFromCart(${item.id})">Löschen</button>
    </div>
  </div>
`;

      });
      // Gesamtpreis berechnen und anzeigen
      document.getElementById("total-price").textContent = total.toFixed(2) + " €";
    })
    .catch(function (error) {
      console.error("Fehler beim Laden des Warenkorbs:", error);
    });
}
// Produkte im Warenkorb aktualisieren, Menge erhöhen oder verringern
function updateQuantity(id, quantity) {
  if (quantity <= 0) {
    removeFromCart(id);
    return;
  }
// Menge aktualisieren
  fetch("../../Backend/logic/cartFunctions.php?action=updateQuantity", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: id, quantity: quantity })
  })
    .then(response => response.json()) //Antwort verarbeiten
    .then(function () {
      loadCart();
    })
    .catch(function (error) {
      console.error("Fehler beim Aktualisieren der Menge:", error);
    });
}
// Produkt aus dem Warenkorb entfernen
function removeFromCart(id) {
  fetch("../../Backend/logic/cartFunctions.php?action=removeFromCart", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: id })
  })
    .then(response => response.json())
    .then(function () {
      loadCart();
    })
    .catch(function (error) {
      console.error("Fehler beim Entfernen des Produkts:", error);
    });
}
  function updateCartCount() {
    fetch("../../Backend/logic/getCartItems.php")
      .then(res => res.json())
      .then(data => {
        let total = 0;
        data.forEach(item => total += item.quantity);
        const badge = document.getElementById("cart-count");
        if (badge) {
          badge.textContent = total;
        }
      })
      .catch(err => console.error("Fehler beim Laden des Warenkorb-Zählers:", err));
  }

  document.addEventListener("DOMContentLoaded", updateCartCount);

function goToCheckout() {
  alert("Zur Kasse geht's hier weiter...");
}
function goToCheckout() {
  window.location.href = "checkout.html";
}

