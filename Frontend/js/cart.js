//Produkte im Warenkorb angezeigen
document.addEventListener("DOMContentLoaded", function () {
  loadCart();
});

//alle Produkte im Warenkorb zurückgeben, Produkte aus dem Backend laden und anzeigen
function loadCart() {
  fetch("../../backend/logic/getCartItems.php")
    .then(response => response.json()) //Antwort verarbeiten
    .then(data => {
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
            <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
            <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">-</button>
            <button onclick="removeFromCart(${item.id})">Löschen</button>
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
  fetch("../../backend/logic/cartFunctions.php?action=updateQuantity", {
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
  fetch("../../backend/logic/cartFunctions.php?action=removeFromCart", {
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

function goToCheckout() {
  alert("Zur Kasse geht's hier weiter...");
}
