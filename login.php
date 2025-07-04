<?php
include 'db.php';
session_start();

$message = "";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "<p class='error'>Parolă incorectă.</p>";
        }
    } else {
        $message = "<p class='error'>Utilizator inexistent.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Autentificare – CV Builder</title>
    <style>
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

        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #ff5a5f;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-top: 1px solid #ccc;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<header>
    <h1>CV Builder</h1>
    <nav>
        <a href="index.php">Acasă</a>
        <a href="login.php">Autentificare</a>
        <a href="register.php">Înregistrare</a>
    </nav>
</header>

<div class="container">
    <h2>Autentificare cont</h2>
    <?= $message ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Nume utilizator" required>
        <input type="password" name="password" placeholder="Parolă" required>
        <button type="submit" name="login">Autentifică-te</button>
    </form>
</div>

<footer>
    © <?= date('Y') ?> CV Builder. Toate drepturile rezervate.
</footer>

</body>
</html>
