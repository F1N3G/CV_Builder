<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Obține profile_id
$stmt = $conn->prepare("SELECT id FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
$profile_id = $profile['id'] ?? null;

if (!$profile_id) {
    echo "Profilul nu a fost găsit.";
    exit();
}

// Adaugă skill
if (isset($_POST['save'])) {
    $skill_name = $_POST['skill_name'];
    $skill_level = $_POST['skill_level'];

    $stmt = $conn->prepare("INSERT INTO skills (profile_id, skill_name, skill_level) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $profile_id, $skill_name, $skill_level);
    $stmt->execute();
}

// Selectează skill-uri
$stmt = $conn->prepare("SELECT * FROM skills WHERE profile_id = ?");
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$skills_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Competențele mele</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 20%;
            float: left;
            height: 100vh;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            margin: 10px 0;
            text-decoration: none;
        }
        .content {
            margin-left: 22%;
            padding: 30px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3>CV Builder</h3>
    <a href="dashboard.php">Date personale</a>
    <a href="education.php">Educație</a>
    <a href="experience.php">Experiență</a>
    <a href="skills.php">Competențe</a>
    <a href="logout.php" style="margin-top: 20px;">Logout</a>
</div>

<div class="content">
    <h2>Adaugă competență</h2>
    <form method="POST">
        <input type="text" name="skill_name" placeholder="Nume competență" required><br>
        <select name="skill_level" required>
            <option value="">Nivel...</option>
            <option value="beginner">Începător</option>
            <option value="intermediate">Mediu</option>
            <option value="advanced">Avansat</option>
        </select><br>
        <button type="submit" name="save">Salvează</button>
    </form>

    <hr>

    <h2>Competențe adăugate</h2>
    <?php if ($skills_result->num_rows > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Competență</th>
                <th>Nivel</th>
            </tr>
            <?php while ($row = $skills_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['skill_name']) ?></td>
                    <td><?= ucfirst($row['skill_level']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nu ai adăugat competențe.</p>
    <?php endif; ?>
</div>

</body>
</html>
