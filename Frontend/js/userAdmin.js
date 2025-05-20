document.addEventListener("DOMContentLoaded", () => {
  fetch("../../Backend/logic/getUsers.php")
    .then(res => res.json())
    .then(users => {
      const table = document.getElementById("user-table");
      table.innerHTML = "";

      users.forEach(user => {
        const row = document.createElement("tr");
      row.innerHTML = `
  <td>${user.id}</td>
  <td>${user.vorname} ${user.nachname}</td>
  <td>${user.email}</td>
  <td>${user.is_active == 1 ? "Aktiv" : "Deaktiviert"}</td>
  <td class="d-flex gap-2">
    <a href="admin_bestellungen.php?user_id=${user.id}" class="btn btn-info btn-sm">Bestellungen</a>
    <form method="POST" action="../backend/logic/${user.is_active == 1 ? 'deaktivieren' : 'aktivieren'}.php">
      <input type="hidden" name="id" value="${user.id}">
      <button type="submit" class="btn btn-sm btn-${user.is_active == 1 ? 'danger' : 'success'}">
        ${user.is_active == 1 ? 'Deaktivieren' : 'Aktivieren'}
      </button>
    </form>
  </td>
`;


        table.appendChild(row);
      });
    })
    .catch(err => {
      console.error("Fehler beim Laden der Benutzer:", err);
    });
});

