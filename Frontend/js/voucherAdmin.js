document.addEventListener("DOMContentLoaded", () => { //
  fetch("../components/header.html") //Header-Datei laden und im Element mit id="header" einfügen
    .then(res => res.text())
    .then(html => document.getElementById("header").innerHTML = html);
//Footer-Datei laden und im Element mit id="footer" einfügen
  fetch("../components/footer.html")
    .then(res => res.text())
    .then(html => document.getElementById("footer").innerHTML = html);
// Lade alle vorhandenen Gutscheine und zeige sie an
  loadVouchers();
//Wenn das Formular abgesendet wird Seite neu laden und Gutschein erstellen
  document.getElementById("voucherForm").addEventListener("submit", function (e) {
    e.preventDefault();
    createVoucher();
  });
});
// Werte aus dem Formular lesen
function createVoucher() {
  const value = document.getElementById("voucher_value").value;
  const valid_until = document.getElementById("voucher_valid_until").value;
 // Anfrage an Backend senden
  fetch("../../Backend/logic/createVoucher.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ value, valid_until })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {  // Erfolg: Zeige Code, lade Liste neu, leere Formular
        alert("Gutschein erstellt: " + data.code);
        loadVouchers();
        document.getElementById("voucherForm").reset();
      } else {  // Fehler: Zeige Nachricht
        alert(data.message);
      }
    });
}

function loadVouchers() {  // Gutscheine vom Backend holen
  fetch("../../Backend/logic/getVouchers.php")
    .then(res => res.json())
    .then(vouchers => {
      const list = document.getElementById("voucher_list");
      if (!Array.isArray(vouchers)) { // Wenn keine gültige Liste zurückkommt, Fehler anzeigen
        list.innerHTML = "<p>Fehler beim Laden der Gutscheine.</p>";
        return;
      }
  // HTML für alle Gutscheine erstellen und einfügen
       list.innerHTML = vouchers.map(v =>
        `<div class="card">
          <div class="card-content">
            <h3>Gutschein</h3>
            <p><strong>Code:</strong> ${v.code}</p>
            <p><strong>Wert:</strong> ${v.value} €</p>
            <p><strong>Gültig bis:</strong> ${v.valid_until}</p>
            <p><strong>Status:</strong> <span class="${v.status.toLowerCase()}">${v.status}</span></p>
          </div>
        </div>`
      ).join(""); // Alle HTML-Blöcke zu einem String verbinden
    });
}
