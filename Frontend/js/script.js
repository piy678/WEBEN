document.addEventListener("DOMContentLoaded", () => {
  // HEADER einfügen
  fetch("../components/header.php")
    .then(res => res.text())
    .then(html => {
      const wrapper = document.createElement("div");
      wrapper.innerHTML = html;
      document.body.insertBefore(wrapper, document.body.firstChild);

      // cart-count NACHDEM der Header im DOM ist:
      updateCartCount();
    });

  // FOOTER einfügen
  fetch("../components/footer.html")
    .then(res => res.text())
    .then(html => {
      const wrapper = document.createElement("div");
      wrapper.innerHTML = html;
      document.body.appendChild(wrapper);
    });
});
// Produkte im Warenkorb Anzahl anzeigen
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
