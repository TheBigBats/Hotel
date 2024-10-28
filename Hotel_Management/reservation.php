<?php

if (isset($_GET['id'])) {
    $reservationId = $_GET['id'];

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Récupérer les détails de la réservation
    $stmt = $conn->prepare("SELECT * FROM RESERVATION WHERE ID_RESERVATION = :id");
    $stmt->execute(['id' => $reservationId]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si la réservation existe, affichez les détails pour modification
    if ($reservation) {
        // Afficher le formulaire pour modifier les informations de la réservation
        echo "<h1>Modifier la Réservation ID : " . htmlspecialchars($reservation['ID_RESERVATION']) . "</h1>";
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Modifier Réservation</title>
            <link rel="stylesheet" href="style6.css"> 
        </head>
        <body>
            <form action="update_reservation.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($reservation['ID_RESERVATION']) ?>">
                
                <label for="id_client">ID Client:</label>
                <input type="text" id="id_client" name="id_client" value="<?= htmlspecialchars($reservation['ID_CLIENT']) ?>" required><br>
                
                <label for="id_chambre">ID Chambre:</label>
                <input type="text" id="id_chambre" name="id_chambre" value="<?= htmlspecialchars($reservation['ID_CHAMBRE']) ?>" required><br>
                
                <label for="date_debut">Date Début:</label>
                <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($reservation['DATE_DEBUT']) ?>" required><br>
                
                <label for="date_fin">Date Fin:</label>
                <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($reservation['DATE_FIN']) ?>" required><br>
                <!-- Bouton de mise à jour -->
                <button type="submit" name="action" value="update">Mettre à jour</button>
                
                <!-- Bouton de suppression -->
                <button type="submit" name="action" value="delete">Supprimer</button>
                
            </form>
           
        </body>
        </html>
        <?php
    } else {
        echo "Réservation non trouvée.";
    }
} else {
    echo "ID de la réservation manquant.";
}
?>
