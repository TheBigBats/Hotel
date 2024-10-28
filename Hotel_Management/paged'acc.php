<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: login.php"); // Rediriger vers la page de connexion si non connecté
    exit();
}

// Affichage de la page 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="stylepaged'acc.css"> 
    
    
</head>
<body>
    <header class="header">
        <h1>Bienvenue dans votre tableau de bord</h1>
        <p>ID Utilisateur : <?php echo $_SESSION['id_utilisateur']; ?></p>
        <p>Rôle : <?php echo $_SESSION['role']; ?></p>
        <a href="logout.php">Déconnexion</a> <!-- Lien pour se déconnecter -->
    </header>

    <nav class="nav">
        <a href="afficher_clients.php">Client</a>
        <a href="afficher_chambres.php">Chambre</a>
        <a href="afficher_reservations.php">Réservation</a>
        <a href="afficher_factures.php">Facture</a>
        <a href="afficher_Paiements.php">Paiement</a>
    </nav>

    <main>
        <h2>Gestion des Services Hôteliers</h2>
        
        <p> Vous pouvez gérer les clients, chambres, réservations, factures et paiements à partir du menu ci-dessus.</p>
    </main>
</body>
</html>
