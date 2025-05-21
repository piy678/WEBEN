//Bestell-ID speichern und Rechnungsdaten laden und wenn keine Bestellung vorhanden ist, dann eine Fehlermeldung anzeigen
document.addEventListener("DOMContentLoaded", () => {
  const orderId = new URLSearchParams(window.location.search).get("order_id");
  if (!orderId) {
    document.getElementById("invoice-data").innerHTML = "<p>Keine Bestellung angegeben.</p>";
    return;
  }
//Lade die Rechnungsdaten
  fetch("../../Backend/logic/getInvoiceData.php?order_id=" + orderId)
    .then(res => res.json())
    .then(data => {
      if (!data || !data.artikel) {
        document.getElementById("invoice-data").innerHTML = "<p>Fehler beim Laden der Daten.</p>";
        return;
      }
//Daten von der Bestellung anzeigen und dem Unternehmen
      const anschrift = data.anschrift;
      const artikel = data.artikel;
      const datum = new Date(data.datum).toLocaleDateString("de-DE");
      const rechnungsnummer = data.rechnungsnummer;
//html für die Rechnung erstellen
      let html = `
        <h2>Rechnung Nr. ${rechnungsnummer}</h2>
        <p><strong>Datum:</strong> ${datum}</p>
        <div class="mb-4">
  <h5><strong>Absender:</strong></h5>
  <p>
    SmartTicketing GmbH<br>
    Tel: +43 123 456789<br>
    E-Mail: info@smartticketing.at
  </p>
</div>

        <p><strong>Rechnung an:</strong><br>
        ${anschrift.vorname} ${anschrift.nachname}<br>
        ${anschrift.adresse}<br>
        ${anschrift.plz} ${anschrift.ort}</p>
        <table class="table mt-4">
          <thead><tr><th>Artikel</th><th>Menge</th><th>Preis</th></tr></thead>
          <tbody>`;
//Gesamtpreis der Artikel berechnen und anzeigen
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
//in invoice-data div einfügen
      document.getElementById("invoice-data").innerHTML = html;
    });
});
//Rechnung als PDF herunterladen
document.getElementById("pdf-download").addEventListener("click", () => {
  const element = document.getElementById("invoice-data");

  const opt = {
    margin:       [0.5, 0.5, 0.5, 0.5], // top, left, bottom, right
    filename:     `rechnung-${Date.now()}.pdf`,
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  {
      scale: 2,
      useCORS: true,
      scrollY: 0 
    },
    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' },
    pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] } // automatische Umbrüche
  };
// Konfiguration für den PDF-Download
  html2pdf().set(opt).from(element).save();
});


