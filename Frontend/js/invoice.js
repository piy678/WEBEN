document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const orderId = params.get("order_id");
  
    if (!orderId) {
      document.getElementById("invoice-data").innerHTML = "<p>Keine Bestellung angegeben.</p>";
      return;
    }

    fetch("../../Backend/logic/getOrderItems.php?order_id=" + orderId)
      .then(res => res.json())
      .then(data => {
        if (!data.length) {
          document.getElementById("invoice-data").innerHTML = "<p>Keine Daten zur Bestellung gefunden.</p>";
          return;
        }
  
        let html = `<p>Bestellung #${orderId}</p><table>
          <tr><th>Artikel</th><th>Menge</th><th>Preis</th></tr>`;
  
        let total = 0;
  
        data.forEach(item => {
          const line = item.quantity * item.price;
          total += line;
          html += `<tr>
            <td>${item.title}</td>
            <td>${item.quantity}</td>
            <td>${line.toFixed(2)} €</td>
          </tr>`;
        });
  
        html += `<tr>
          <td colspan="2"><strong>Gesamt</strong></td>
          <td><strong>${total.toFixed(2)} €</strong></td>
        </tr></table>`;
  
        document.getElementById("invoice-data").innerHTML = html;
      });
  });
  