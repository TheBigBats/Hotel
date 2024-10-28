<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_utilisateur = trim($_POST['id_utilisateur']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    // Connexion à la base de données Oracle 
    $conn = oci_connect('AFIFIBZ2425', 'AFIFIBZ242501', 'pdbestia');

    if (!$conn) {
        $e = oci_error();
        echo "Erreur de connexion : " . $e['message'];
    } else {
        // Requête pour vérifier les identifiants et le rôle
        $stid = oci_parse($conn, 'SELECT * FROM UTILISATEUR WHERE ID_UTILISATEUR = :id_utilisateur AND ROLE_UTILISATEUR = :role');
        oci_bind_by_name($stid, ':id_utilisateur', $id_utilisateur);
        oci_bind_by_name($stid, ':role', $role);
        oci_execute($stid);

        $user = oci_fetch_array($stid, OCI_ASSOC);

        // Comparaison du mot de passe
        if ($user && $user['MOT_DE_PASSE'] === $password) {
            // Authentification réussie, créer la session
            $_SESSION['id_utilisateur'] = $id_utilisateur;
            $_SESSION['role'] = $role;
            header("Location: paged'acc.php"); // Rediriger vers la page d'acc
            exit();
        } else {
            $error = "ID Utilisateur, rôle ou mot de passe incorrect.";
        }

        // Fermer la connexion
        oci_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo" style="color: #fff; font-size: 1.7em;">
            <ion-icon name="bed"></ion-icon>Hotel Management
        </a>
    </header>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <div class="login-container">
        <h2>Connexion</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <span class="icon"><ion-icon name="id-card"></ion-icon></span>
                <label for="id_utilisateur">ID Utilisateur :</label>
                <input type="text" id="id_utilisateur" name="id_utilisateur" required>
            </div>
            <div class="input-group">
            <span class="icon"><ion-icon name="build"></ion-icon></span>
                <label for="role">Rôle :</label>
                <input type="text" id="role" name="role" required>
            </div>
            <div class="input-group">
            <span class="icon"><ion-icon name="lock-open"></ion-icon></span>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Se connecter</button>
            <div class="register-link">
                <p> Vous avez pas un compte?<a href="#"> S'enregistrer </a></p>
           </div>
        </form>
        
    </div>

        <div class="welcome-message" id="welcome" >
            <h3>Bienvenue!</h3>
            <p>Accédez à votre espace de gestion en toute simplicité.<br> 
            Connectez-vous pour gérer efficacement vos services hôteliers.</p>
            <a href="Documentation.html">C'est parti</a>
        </div>
        <script>
        // Fonction pour masquer le message de bienvenue sur redimensionnement
        function checkWindowSize() {
            const welcomeMessage = document.getElementById('welcome');
            if (window.innerWidth < 900) { 
                welcomeMessage.style.display = 'none'; 
            } else {
                welcomeMessage.style.display = 'block'; 
            }
        }

        // Événements pour détecter le redimensionnement de la fenêtre
        window.addEventListener('resize', checkWindowSize);
        // Appel initial pour définir l'état au chargement de la page
        checkWindowSize();
    </script>
</body>
</html>
