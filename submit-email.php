<?php
// submit-email.php

// 1. Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Vérifier si l'e-mail a été soumis et le nettoyer
    if (isset($_POST['user_email']) && !empty($_POST['user_email'])) {
        
        // Nettoyage de l'e-mail pour éviter les injections de code (sécurité de base)
        $email = filter_var(trim($_POST['user_email']), FILTER_SANITIZE_EMAIL);
        
        // 3. Spécifier le nom du fichier de destination
        $file = 'data.txt';
        
        // 4. Formater la ligne à écrire (e-mail + horodatage)
        $data_to_write = $email . " | " . date('Y-m-d H:i:s') . "\n";
        
        // 5. Écrire dans le fichier (mode APPEND: ajoute au lieu d'écraser)
        // Le flag FILE_APPEND assure que les nouvelles données sont ajoutées à la fin.
        // LOCK_EX verrouille le fichier pendant l'écriture pour éviter les conflits d'accès.
        if (file_put_contents($file, $data_to_write, FILE_APPEND | LOCK_EX) !== false) {
            
            // Succès : Rediriger l'utilisateur vers la page d'accueil ou une page de succès
            header('Location: index.html?status=success'); 
            exit;
        } else {
            // Erreur d'écriture
            error_log("Erreur lors de l'écriture dans data.txt: " . $email);
            header('Location: index.html?status=error');
            exit;
        }
    } else {
        // E-mail manquant
        header('Location: index.html?status=missing_email');
        exit;
    }
} else {
    // Accès direct au script sans formulaire
    header('Location: index.html');
    exit;
}
?>