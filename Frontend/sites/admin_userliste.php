<?php
// Verbindung zur Datenbank
$conn = new mysqli("localhost", "root", "", "webshop");

// Fehlerprüfung
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Alle Benutzer abrufen
$result = $conn->query("SELECT * FROM benutzer");
?>

<!DOCTYPE html>
<html lang="de">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kundenverwaltung</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
</head>
<body>
    <h2>Kundenkonten verwalten (Admin)</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Status</th>
            <th>Aktion</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['vorname'] . " " . $row['nachname']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['is_active'] ? "Aktiv" : "Deaktiviert" ?></td>
                 <td>
    <a href="admin_bestellungen.php?user_id=<?= $row['id'] ?>" class="btn btn-info btn-sm mt-1">Bestellungen</a>
  </td>
                <td>
                    <?php if ($row["is_active"]): ?>
                        <form method="POST" action="../../Backend/logic/deaktivieren.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">Deaktivieren</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="../../Backend/logic/aktivieren.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">Aktivieren</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <script src="../js/script.js"></script>
</body>
</html>
