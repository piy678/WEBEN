document.addEventListener("DOMContentLoaded", () => {
  fetch("../components/header.html")
    .then(res => res.text())
    .then(html => document.getElementById("header").innerHTML = html);

  fetch("../components/footer.html")
    .then(res => res.text())
    .then(html => document.getElementById("footer").innerHTML = html);

  loadVouchers();

  document.getElementById("voucherForm").addEventListener("submit", function (e) {
    e.preventDefault();
    createVoucher();
  });
});

function createVoucher() {
  const value = document.getElementById("voucher_value").value;
  const valid_until = document.getElementById("voucher_valid_until").value;

  fetch("../../Backend/logic/createVoucher.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ value, valid_until })
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alert("Gutschein erstellt: " + data.code);
        loadVouchers();
        document.getElementById("voucherForm").reset();
      } else {
        alert(data.message);
      }
    });
}

function loadVouchers() {
  fetch("../../Backend/logic/getVouchers.php")
    .then(res => res.json())
    .then(vouchers => {
      const list = document.getElementById("voucher_list");
      if (!Array.isArray(vouchers)) {
        list.innerHTML = "<p>Fehler beim Laden der Gutscheine.</p>";
        return;
      }

      list.innerHTML = vouchers.map(v =>
        `<div class="voucher">
          <strong>Code:</strong> ${v.code}<br>
          <strong>Wert:</strong> ${v.value} €<br>
          <strong>Gültig bis:</strong> ${v.valid_until}<br>
          <strong>Status:</strong> <span class="${v.status.toLowerCase()}">${v.status}</span>
        </div>`
      ).join("");
    });
}
