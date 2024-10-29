<?php

if (isset($_GET['id'])) {
    $paiementId = $_GET['id'];

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Récupérer les détails du paiement
    $stmt = $conn->prepare("SELECT * FROM PAIEMENT WHERE ID_PAIEMENT = :id");
    $stmt->execute(['id' => $paiementId]);
    $paiement = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si le paiement existe, affichez les détails pour modification
    if ($paiement) {
        
        echo "<h1>Modifier le Paiement : " . htmlspecialchars($paiement['ID_PAIEMENT']) . "</h1>";
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Modifier Paiement</title>
            <link rel="stylesheet" href="style6.css"> 
        </head>
        <body>
            <form action="update_paiement.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($paiement['ID_PAIEMENT']) ?>">
                
                <label for="id_facture">ID Facture:</label>
                <input type="number" id="id_facture" name="id_facture" value="<?= htmlspecialchars($paiement['ID_FACTURE']) ?>" required><br>
                
                <label for="id_client">ID Client:</label>
                <input type="number" id="id_client" name="id_client" value="<?= htmlspecialchars($paiement['ID_CLIENT']) ?>" required><br>
                
                <label for="montant">Montant:</label>
                <input type="number" step="0.01" id="montant" name="montant" value="<?= htmlspecialchars($paiement['MONTANT_PAIEMENT']) ?>" required><br>
                
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?= htmlspecialchars($paiement['DATE_PAIEMENT']) ?>" required><br>
                
                <!-- Bouton de mise à jour -->
                <button type="submit" name="action" value="update">Mettre à jour</button>
                
                <!-- Bouton de suppression -->
                <button type="submit" name="action" value="delete">Supprimer</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Paiement non trouvé.";
    }
} else {
    echo "ID du paiement manquant.";
}
?>
