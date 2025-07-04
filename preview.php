<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM cv_data WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Preview CV – CV Builder</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f2f4ff;
        }
        header {
            background-color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }
        header h1 {
            margin: 0;
            color: #2c3e50;
        }
        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: bold;
        }
        .middle-preview {
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h3 { color: #2c3e50; }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        p {
            background: #f7f9ff;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<header>
    <h1>CV Builder</h1>
    <nav>
        <a href="index.php">Acasă</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="middle-preview">
    <h2>Previzualizare CV</h2>

    <h3>Date personale</h3>
    <label>Nume complet</label>
    <p><?= htmlspecialchars($profile['full_name'] ?? '') ?></p>

    <label>Telefon</label>
    <p><?= htmlspecialchars($profile['phone'] ?? '') ?></p>

    <label>Email</label>
    <p><?= htmlspecialchars($profile['email'] ?? '') ?></p>

    <label>Adresă</label>
    <p><?= htmlspecialchars($profile['address'] ?? '') ?></p>

    <h3>Educație</h3>
    <label>Liceu</label>
    <p><?= htmlspecialchars($profile['liceu'] ?? '') ?></p>

    <label>Facultate</label>
    <p><?= htmlspecialchars($profile['facultate'] ?? '') ?></p>

    <h3>Experiență profesională</h3>
    <label>Experiență anterioară</label>
    <p><?= htmlspecialchars($profile['experienta'] ?? '') ?></p>

    <label>Cursuri / Diplome</label>
    <p><?= htmlspecialchars($profile['cursuri'] ?? '') ?></p>

    <label>Voluntariat / Practică</label>
    <p><?= htmlspecialchars($profile['voluntariat'] ?? '') ?></p>

    <h3>Competențe</h3>
    <label>Tehnice</label>
    <p><?= htmlspecialchars($profile['tehnice'] ?? '') ?></p>

    <label>Lingvistice</label>
    <p><?= htmlspecialchars($profile['lingvistice'] ?? '') ?></p>

    <label>Sociale</label>
    <p><?= htmlspecialchars($profile['sociale'] ?? '') ?></p>
</div>

</body>
</html>
