<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    
    <meta charset="UTF-8">
    <title>Dashboard – CV Builder</title>
    <style>

[contenteditable][data-placeholder]:empty::before {
    content: attr(data-placeholder);
    color: #aaa;
    font-style: italic;
    pointer-events: none;
}


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

        .dashboard {
            display: flex;
            height: calc(100vh - 70px);
        }

        .left-menu {
            width: 20%;
            background-color: #ffffff;
            border-right: 1px solid #ddd;
            padding: 20px;
            overflow-y: auto;
        }

        .left-menu h3 {
            margin-top: 0;
            color: #2c3e50;
        }

        .section-toggle {
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            cursor: pointer;
        }

        .section-toggle.selected {
            border-color: #ff5a5f;
            background-color: #ffecec;
        }

        .middle-preview {
            width: 50%;
            overflow-y: scroll;
            background-color: white;
            padding: 30px;
            position: relative;
        }

        .highlight-section {
            outline: 2px dashed #ff5a5f;
            background-color: #fff8f8;
        }

        .right-panel {
            width: 30%;
            background-color: #ffffff;
            border-left: 1px solid #ddd;
            padding: 20px;
            overflow-y: auto;
        }

        .template-box {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 15px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .color-palette {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .color-box {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            padding: 8px 12px;
            background-color: #ff5a5f;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #e94e53;
        }

        .download-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        [contenteditable] {
            padding: 4px;
            border: 1px dashed transparent;
        }

        [contenteditable]:focus {
            outline: none;
            border-color: #aaa;
            background-color: #f0f8ff;
        }


    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('.section-toggle');
            const editableGroups = {
                'Date personale': ['nume', 'contact', 'adresa'],
                'Educație': ['liceu', 'facultate'],
                'Experiență': ['experienta', 'cursuri', 'voluntariat'],
                'Competențe': ['tehnice', 'lingvistice', 'sociale']
            };

            sections.forEach((section) => {
                section.addEventListener('click', () => {
                    sections.forEach(s => {
                        s.classList.remove('selected');
                        const btn = s.querySelector('button');
                        if (btn) btn.textContent = 'Schimbă design';
                    });

                    section.classList.add('selected');
                    const btn = section.querySelector('button');
                    if (btn) btn.textContent = 'Editează';

                    document.querySelectorAll('[data-section]').forEach(el => {
                        el.classList.remove('highlight-section');
                    });

                    const sectionName = section.querySelector('strong').innerText.trim();
                    const group = editableGroups[sectionName];
                    if (group) {
                        group.forEach(id => {
                            const el = document.querySelector(`[data-section="${id}"]`);
                            if (el) el.classList.add('highlight-section');
                        });
                    }
                });
            });
        });
    </script>
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

<div class="dashboard">
    <!-- Coloana stânga -->
    <div class="left-menu">
        <h3>Secțiuni CV</h3>
        <div class="section-toggle">
            <strong>Date personale</strong><br>
            <button>Schimbă design</button>
        </div>
        <div class="section-toggle">
            <strong>Educație</strong><br>
            <button>Schimbă design</button>
        </div>
        <div class="section-toggle">
            <strong>Experiență</strong><br>
            <button>Schimbă design</button>
        </div>
        <div class="section-toggle">
            <strong>Competențe</strong><br>
            <button>Schimbă design</button>
        </div>
    </div>

   
<!-- Coloana centrală -->
<div id="cv-preview" class="middle-preview" style="max-width: 800px; margin: 100px auto 0 auto; border: 1px dashed #ccc; padding: 40px 20px; text-align: left; overflow-y: auto; height: calc(100vh - 120px); background: #f9f9f9;">

    <!-- DATE PERSONALE -->
    <h3>Date personale</h3>
    <label for="nume">Nume complet</label>
    <p style="font-size: 24px;" contenteditable="true" data-section="nume" data-placeholder="Nume complet"></p>

    <label for="contact">Telefon și Email</label>
    <p style="font-size: 18px;" contenteditable="true" data-section="contact" data-placeholder="Telefon: 07xxxxxxxx · Email: exemplu@email.com"></p>

    <label for="adresa">Adresă</label>
    <p contenteditable="true" data-section="adresa" data-placeholder="Adresă completă"></p>

    <hr>

    <!-- EDUCAȚIE -->
    <h3>Educație</h3>
    <label for="liceu">Liceu</label>
    <p contenteditable="true" data-section="liceu" data-placeholder="Liceu: nume instituție, ani"></p>

    <label for="facultate">Facultate</label>
    <p contenteditable="true" data-section="facultate" data-placeholder="Facultate: nume, ani, domeniu"></p>

    <hr>

    <!-- EXPERIENȚĂ -->
    <h3>Experiență profesională</h3>
    <label for="experienta">Experiență anterioară</label>
    <p contenteditable="true" data-section="experienta" data-placeholder="Companie: Post ocupat, Responsabilități"></p>

    <label for="cursuri">Cursuri / Diplome</label>
    <p contenteditable="true" data-section="cursuri" data-placeholder="Cursuri / Diplome recunoscute"></p>

    <label for="voluntariat">Voluntariat / Practică / Internship</label>
    <p contenteditable="true" data-section="voluntariat" data-placeholder="Voluntariat / Practică / Internship"></p>

    <hr>

    <!-- COMPETENȚE -->
    <h3>Competențe</h3>
    <label for="tehnice">Competențe tehnice</label>
    <p contenteditable="true" data-section="tehnice" data-placeholder="Ex: HTML, CSS, baze de date"></p>

    <label for="lingvistice">Competențe lingvistice</label>
    <p contenteditable="true" data-section="lingvistice" data-placeholder="Ex: Engleză – avansat, Franceză – mediu"></p>

    <label for="sociale">Competențe sociale</label>
    <p contenteditable="true" data-section="sociale" data-placeholder="Ex: Comunicare, lucru în echipă, leadership"></p>
</div>


   <!-- Coloana dreapta -->
<div class="right-panel">
    <h3>Șabloane și personalizare</h3>

    <div class="template-box">
        <strong>Paletă de culori:</strong>
        <div class="color-palette">
            <div class="color-box" data-color="#e5d5ff" style="background:#e5d5ff"></div>
            <div class="color-box" data-color="#d4edda" style="background:#d4edda"></div>
            <div class="color-box" data-color="#ffe0b2" style="background:#ffe0b2"></div>
            <div class="color-box" data-color="#bbdefb" style="background:#bbdefb"></div>
            <div class="color-box" data-color="#ffcccb" style="background:#ffcccb"></div>
            <div class="color-box" data-color="#d0e1ff" style="background:#d0e1ff"></div>
        </div>
    </div>

    <div class="template-box">
        <strong>Stil fonturi:</strong>
        <select id="font-style">
            <option value="inherit">Default</option>
            <option value="Georgia, serif">Serif</option>
            <option value="Arial, sans-serif">Sans-serif</option>
            <option value="'Courier New', monospace">Monospace</option>
        </select>
    </div>

    <div class="template-box">
        <strong>Alege template:</strong>
        <button class="template-btn" data-template="clasic">Clasic</button>
        <button class="template-btn" data-template="modern">Modern</button>
        <button class="template-btn" data-template="elegant">Elegant</button>
    </div>
    <hr>
    <div style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
        <button id="saveBtn" style="margin-top: 20px; background: #28a745;">💾 Salvează CV</button>
        <p id="saveStatus" style="color: green; display:none; font-weight: bold; text-align:center;">✔ CV salvat cu succes!</p>

        <a href="preview.php" style="text-align:center; background-color:#2c3e50; color:white; padding:10px; border-radius:4px; text-decoration:none; font-weight:bold;">
            👁️ Previzualizează CV-ul
        </a>
    </div>
</div>



<script>
//  Aplicare culoare fundal
document.querySelectorAll(".color-box").forEach(box => {
    box.addEventListener("click", () => {
        const color = box.getAttribute("data-color");
        document.getElementById("cv-preview").style.backgroundColor = color;
    });
});

// 🅰 Aplicare font
document.getElementById("font-style").addEventListener("change", (e) => {
    const font = e.target.value;
    document.getElementById("cv-preview").style.fontFamily = font;
});

//  Aplicare template
const templateBtns = document.querySelectorAll(".template-btn");
const preview = document.getElementById("cv-preview");

templateBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        preview.classList.remove("clasic", "modern", "elegant");
        const t = btn.getAttribute("data-template");
        preview.classList.add(t);
    });
});
</script>



<script>
// Functie care verifică dacă valoarea este diferită de placeholder
function cleanValue(selector) {
    const el = document.querySelector(selector);
    if (!el) return '';
    const value = el.innerText.trim();
    const placeholder = el.dataset.placeholder?.trim() || '';
    return (value === placeholder || value === '') ? '' : value;
}

// Salvare date la click
document.getElementById("saveBtn").addEventListener("click", function () {
    const data = {
        full_name: cleanValue('[data-section="nume"]'),
        summary: cleanValue('[data-section="contact"]'),
        address: cleanValue('[data-section="adresa"]'),
        liceu: cleanValue('[data-section="liceu"]'),
        facultate: cleanValue('[data-section="facultate"]'),
        experienta: cleanValue('[data-section="experienta"]'),
        cursuri: cleanValue('[data-section="cursuri"]'),
        voluntariat: cleanValue('[data-section="voluntariat"]'),
        tehnice: cleanValue('[data-section="tehnice"]'),
        lingvistice: cleanValue('[data-section="lingvistice"]'),
        sociale: cleanValue('[data-section="sociale"]')
    };

    fetch("save_profile.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        const status = document.getElementById("saveStatus");
        if (response.success) {
            status.style.display = "block";
            setTimeout(() => status.style.display = "none", 3000);
        } else {
            alert("❌ Eroare la salvare: " + response.message);
        }
    })
    .catch(err => {
        console.error("Eroare fetch:", err);
        alert("❌ Eroare la salvarea CV-ului.");
    });
});
</script>


