<?php
session_start();

// Afișare erori pentru debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php';

$user_id = $_SESSION['user_id'] ?? null;

// Verificăm dacă utilizatorul e autentificat
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Neautentificat']);
    exit;
}

// Debug sesiune – scris în fișier (opțional)
file_put_contents('debug_session.txt', print_r($_SESSION, true));

// Verificăm dacă user_id există în tabela users
$stmt_user = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Utilizatorul nu există în baza de date.']);
    exit;
}

// Preluăm datele JSON din request
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Date JSON invalide']);
    exit;
}

// Extragem câmpurile text
$full_name   = trim($data['full_name'] ?? '');
$summary     = trim($data['summary'] ?? '');
$address     = trim($data['address'] ?? '');
$liceu       = trim($data['liceu'] ?? '');
$facultate   = trim($data['facultate'] ?? '');
$experienta  = trim($data['experienta'] ?? '');
$cursuri     = trim($data['cursuri'] ?? '');
$voluntariat = trim($data['voluntariat'] ?? '');
$tehnice     = trim($data['tehnice'] ?? '');
$lingvistice = trim($data['lingvistice'] ?? '');
$sociale     = trim($data['sociale'] ?? '');

// Extragem stilurile vizuale
$bg_color      = trim($data['bg_color'] ?? '');
$font_family   = trim($data['font_family'] ?? '');
$template_name = trim($data['template_name'] ?? '');

// Parsează Telefon și Email din `summary`
$phone = '';
$email = '';
if (strpos($summary, '·') !== false) {
    [$phonePart, $emailPart] = array_map('trim', explode('·', $summary, 2));
    $phone = preg_replace('/^Telefon:/i', '', $phonePart);
    $email = preg_replace('/^Email:/i', '', $emailPart);
} else {
    $phone = $summary;
    $email = '';
}

try {
    // Verificăm dacă există deja o intrare pentru acest user
    $stmt_check = $conn->prepare("SELECT id FROM cv_data WHERE user_id = ?");
    $stmt_check->bind_param("i", $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // UPDATE
        $stmt = $conn->prepare("UPDATE cv_data SET
            full_name = ?, phone = ?, email = ?, address = ?,
            liceu = ?, facultate = ?, experienta = ?, cursuri = ?, voluntariat = ?,
            tehnice = ?, lingvistice = ?, sociale = ?,
            bg_color = ?, font_family = ?, template_name = ?
            WHERE user_id = ?");
        $stmt->bind_param("sssssssssssssssi",
            $full_name, $phone, $email, $address,
            $liceu, $facultate, $experienta, $cursuri, $voluntariat,
            $tehnice, $lingvistice, $sociale,
            $bg_color, $font_family, $template_name,
            $user_id
        );
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO cv_data (
            user_id, full_name, phone, email, address,
            liceu, facultate, experienta, cursuri, voluntariat,
            tehnice, lingvistice, sociale,
            bg_color, font_family, template_name
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssssssssssss",
            $user_id, $full_name, $phone, $email, $address,
            $liceu, $facultate, $experienta, $cursuri, $voluntariat,
            $tehnice, $lingvistice, $sociale,
            $bg_color, $font_family, $template_name
        );
    }

    // Executăm query-ul
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Eroare SQL: ' . $stmt->error]);
    }
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => 'Excepție: ' . $e->getMessage()]);
}
