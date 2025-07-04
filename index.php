<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>CV Builder - Acasă</title>
    <style>
        * {
            box-sizing: border-box;
        }

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

        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 80px;
        }

        .hero-text {
            width: 50%;
        }

        .hero-text h2 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .hero-text p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }

        .hero-text a {
            padding: 12px 25px;
            background-color: #ff5a5f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .hero-image {
            width: 40%;
        }

        .hero-image img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-top: 1px solid #ccc;
            color: #777;
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

<section class="hero">
    <div class="hero-text">
        <h2>Creează-ți un CV Profesionist în Câteva Minute</h2>
        <p>Cu CV Builder îți poți construi, edita și salva CV-ul online rapid și ușor. Începe chiar acum, este complet gratuit!</p>
        <a href="register.php">Începe acum →</a>
    </div>
    <div class="hero-image">
        <img src="https://cdn.pixabay.com/photo/2015/01/08/18/29/man-593333_960_720.jpg" alt="CV builder preview">
    </div>
</section>

<footer>
    © <?= date('Y') ?> CV Builder. Toate drepturile rezervate.
</footer>

</body>
</html>
