<?php
include 'db.php';
session_start();

$message = "";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $message = "<p class='error'>Există deja un cont cu acest username sau email.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;

            $conn->query("INSERT INTO profiles (user_id, full_name, phone, address, summary)
                          VALUES ($user_id, '', '', '', '')");

            header("Location: dashboard.php");
            exit;
        } else {
            $message = "<p class='error'>Eroare la înregistrare.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Înregistrare – CV Builder</title>
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

        input::placeholder {
            color: #999;
            font-style: italic;
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
    <h2>Crează un cont nou</h2>
    <?= $message ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Ex: ion.popescu" required>
        <input type="email" name="email" placeholder="Ex: ion@email.com" required>
        <input type="password" name="password" placeholder="Alege o parolă sigură" required>
        <button type="submit" name="register">Înregistrează-te</button>
    </form>
</div>

<footer>
    © <?= date('Y') ?> CV Builder. Toate drepturile rezervate.
</footer>

</body>
</html>
