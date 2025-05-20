document.addEventListener("DOMContentLoaded", () => {
  const orderId = new URLSearchParams(window.location.search).get("order_id");
  if (!orderId) {
    document.getElementById("invoice-data").innerHTML = "<p>Keine Bestellung angegeben.</p>";
    return;
  }

  fetch("../../Backend/logic/getInvoiceData.php?order_id=" + orderId)
    .then(res => res.json())
    .then(data => {
      if (!data || !data.artikel) {
        document.getElementById("invoice-data").innerHTML = "<p>Fehler beim Laden der Daten.</p>";
        return;
      }

      const anschrift = data.anschrift;
      const artikel = data.artikel;
      const datum = new Date(data.datum).toLocaleDateString("de-DE");
      const rechnungsnummer = data.rechnungsnummer;

      let html = `
        <h2>Rechnung Nr. ${rechnungsnummer}</h2>
        <p><strong>Datum:</strong> ${datum}</p>
        <p><strong>Rechnung an:</strong><br>
        ${anschrift.vorname} ${anschrift.nachname}<br>
        ${anschrift.adresse}<br>
        ${anschrift.plz} ${anschrift.ort}</p>
        <table class="table mt-4">
          <thead><tr><th>Artikel</th><th>Menge</th><th>Preis</th></tr></thead>
          <tbody>`;

      let total = 0;
      artikel.forEach(item => {
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
      </tr></tbody></table>`;

      document.getElementById("invoice-data").innerHTML = html;
    });
});
