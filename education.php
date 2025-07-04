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

// Adaugă educație
if (isset($_POST['save'])) {
    $institution = $_POST['institution'];
    $degree = $_POST['degree'];
    $field = $_POST['field'];
    $start = $_POST['start_year'];
    $end = $_POST['end_year'];

    $stmt = $conn->prepare("INSERT INTO education (profile_id, institution, degree, field, start_year, end_year) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssii", $profile_id, $institution, $degree, $field, $start, $end);
    $stmt->execute();
}

// Selectează educația
$stmt = $conn->prepare("SELECT * FROM education WHERE profile_id = ?");
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$education_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Educația mea</title>
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
    <h2>Adaugă educație</h2>
    <form method="POST">
        <input type="text" name="institution" placeholder="Instituție" required><br>
        <input type="text" name="degree" placeholder="Diplomă / Grad" required><br>
        <input type="text" name="field" placeholder="Domeniu de studiu" required><br>
        <input type="number" name="start_year" placeholder="An început (ex: 2020)" required><br>
        <input type="number" name="end_year" placeholder="An sfârșit (ex: 2023)" required><br>
        <button type="submit" name="save">Salvează</button>
    </form>

    <hr>

    <h2>Educația adăugată</h2>
    <?php if ($education_result->num_rows > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Instituție</th>
                <th>Diplomă</th>
                <th>Domeniu</th>
                <th>Început</th>
                <th>Final</th>
            </tr>
            <?php while ($row = $education_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['institution']) ?></td>
                    <td><?= htmlspecialchars($row['degree']) ?></td>
                    <td><?= htmlspecialchars($row['field']) ?></td>
                    <td><?= $row['start_year'] ?></td>
                    <td><?= $row['end_year'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nu ai educație adăugată încă.</p>
    <?php endif; ?>
</div>

</body>
</html>
