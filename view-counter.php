<?php
// view-counter.php
header('Content-Type: application/json');

$file = 'view.txt';
$current_count = 0;

// 1. Lire le nombre de vues actuel
if (file_exists($file)) {
    // Lire le contenu, le convertir en entier
    $current_count = (int)file_get_contents($file);
}

// 2. Incrémenter le compteur
$new_count = $current_count + 1;

// 3. Écrire la nouvelle valeur dans le fichier
// LOCK_EX verrouille le fichier pour éviter la corruption en cas d'accès multiples et simultanés.
if (file_put_contents($file, $new_count, LOCK_EX) !== false) {
    // Succès : Renvoyer le nouveau compte au format JSON
    echo json_encode(['count' => $new_count]);
} else {
    // Erreur d'écriture
    http_response_code(500);
    echo json_encode(['error' => 'Could not update view count.']);
}
?>