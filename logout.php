<?php
session_start();        // Pornește sesiunea
session_unset();        // Șterge toate variabilele din sesiune
session_destroy();      // Închide sesiunea complet

header("Location: login.php");  // Redirecționează către pagina de login
exit();
