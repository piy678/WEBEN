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
    <title>Benutzerverwaltung</title>
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
                    <?php if ($row["is_active"]): ?>
                        <form method="POST" action="deaktivieren.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">Deaktivieren</button>
                        </form>
                    <?php else: ?>
                        <form method="POST" action="aktivieren.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit">Aktivieren</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
