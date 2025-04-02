<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($vorname, $nachname, $email, $benutzername, $passwort) {
        $passwort_hash = password_hash($passwort, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (vorname, nachname, email, benutzername, passwort) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $vorname, $nachname, $email, $benutzername, $passwort_hash);

        return $stmt->execute();
    }

    public function login($benutzername, $passwort) {
        $sql = "SELECT * FROM users WHERE benutzername = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $benutzername);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($passwort, $user['passwort'])) {
            return $user;
        } else {
            return false;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzerregistrierung</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2 class="form-heading">Registrierung</h2>

        <form id="registration-form" method="POST" action="../backend/controllers/register.php">
        

            <label for="vorname">Vorname:</label>
            <input type="text" name="vorname" id="vorname" required><br>

            <label for="nachname">Nachname:</label>
            <input type="text" name="nachname" id="nachname" required><br>

            <label for="adresse">Adresse:</label>
            <input type="text" name="adresse" id="adresse" required><br>

            <label for="plz">PLZ:</label>
            <input type="text" name="plz" id="plz" required><br>

            <label for="ort">Ort:</label>
            <input type="text" name="ort" id="ort" required><br>

            <label for="email">E-Mail-Adresse:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="benutzername">Benutzername:</label>
            <input type="text" name="benutzername" id="benutzername" required><br>

            <label for="passwort">Passwort:</label>
            <input type="password" name="passwort" id="passwort" required><br>

            <label for="passwort_repeat">Passwort wiederholen:</label>
            <input type="password" name="passwort_repeat" id="passwort_repeat" required><br>

            <button type="submit">Registrieren</button>
        </form>
    </div>
</body>
</html>
