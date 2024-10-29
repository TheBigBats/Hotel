<?php

if (isset($_GET['id'])) {
    $factureId = $_GET['id'];

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Récupérer les détails de la facture
    $stmt = $conn->prepare("SELECT * FROM FACTURE WHERE ID_FACTURE = :id");
    $stmt->execute(['id' => $factureId]);
    $facture = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si la facture existe, affichez les détails pour modification
    if ($facture) {
        
        echo "<h1>Modifier la Facture : " . htmlspecialchars($facture['ID_FACTURE']) . "</h1>";
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Modifier Facture</title>
            <link rel="stylesheet" href="style6.css"> 
        </head>
        <body>
            <form action="update_facture.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($facture['ID_FACTURE']) ?>">
                
                <label for="montant">Montant:</label>
    <input type="number" step="0.01" id="montant" name="montant" value="<?= htmlspecialchars($facture['MONTANT_TOTAL_FACTURE'] ?? '') ?>" required><br>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?= htmlspecialchars($facture['DATE_FACTURE']) ?>" required><br>
                
                <label for="id_reservation">ID Reservation:</label>
                <input type="number" id="id_reservation" name="id_reservation" value="<?= htmlspecialchars($facture['ID_RESERVATION']) ?>" required><br>
                
                <!-- Bouton de mise à jour -->
                <button type="submit" name="action" value="update">Mettre à jour</button>
                
                <!-- Bouton de suppression -->
                <button type="submit" name="action" value="delete">Supprimer</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Facture non trouvée.";
    }
} else {
    echo "ID de la facture manquant.";
}
?>
