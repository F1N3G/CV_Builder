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

// Adaugă experiență
if (isset($_POST['save'])) {
    $job_title = $_POST['job_title'];
    $company = $_POST['company'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO experience (profile_id, job_title, company, start_date, end_date, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $profile_id, $job_title, $company, $start_date, $end_date, $description);
    $stmt->execute();
}

// Selectează experiența
$stmt = $conn->prepare("SELECT * FROM experience WHERE profile_id = ?");
$stmt->bind_param("i", $profile_id);
$stmt->execute();
$experience_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Experiență profesională</title>
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
    <h2>Adaugă experiență profesională</h2>
    <form method="POST">
        <input type="text" name="job_title" placeholder="Titlu job" required><br>
        <input type="text" name="company" placeholder="Companie" required><br>
        <input type="date" name="start_date" required><br>
        <input type="date" name="end_date" required><br>
        <textarea name="description" placeholder="Descriere" required></textarea><br>
        <button type="submit" name="save">Salvează</button>
    </form>

    <hr>

    <h2>Experiență adăugată</h2>
    <?php if ($experience_result->num_rows > 0): ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Job</th>
                <th>Companie</th>
                <th>Start</th>
                <th>Final</th>
                <th>Descriere</th>
            </tr>
            <?php while ($row = $experience_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['job_title']) ?></td>
                    <td><?= htmlspecialchars($row['company']) ?></td>
                    <td><?= $row['start_date'] ?></td>
                    <td><?= $row['end_date'] ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Nu ai adăugat experiență.</p>
    <?php endif; ?>
</div>

</body>
</html>
