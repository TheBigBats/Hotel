<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour insérer une facture
if (isset($_POST['ajouter'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO FACTURE (ID_FACTURE, MONTANT_TOTAL_FACTURE, DATE_FACTURE, ID_RESERVATION) 
                                VALUES (:id_facture, :montant_total_facture, TO_DATE(:date_facture, 'YYYY-MM-DD'), :id_reservation)");
        $stmt->execute([
            ':id_facture' => $_POST['id_facture'],
            ':montant_total_facture' => $_POST['montant_total_facture'],
            ':date_facture' => $_POST['date_facture'],
            ':id_reservation' => $_POST['id_reservation']
        ]);
        echo "<p style='color: black;'>Facture ajoutée avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de l'ajout de la facture : " . $e->getMessage() . "</p>";
    }
}

// Fonction pour mettre à jour une facture
if (isset($_POST['modifier'])) {
    try {
        $stmt = $conn->prepare("UPDATE FACTURE 
                                SET MONTANT_TOTAL_FACTURE = :montant_total_facture, DATE_FACTURE = TO_DATE(:date_facture, 'YYYY-MM-DD'), ID_RESERVATION = :id_reservation 
                                WHERE ID_FACTURE = :id_facture");
        $stmt->execute([
            ':id_facture' => $_POST['id_facture'],
            ':montant_total_facture' => $_POST['montant_total_facture'],
            ':date_facture' => $_POST['date_facture'],
            ':id_reservation' => $_POST['id_reservation']
        ]);
        echo "<p style='color: black;'>Facture modifiée avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de la modification de la facture : " . $e->getMessage() . "</p>";
    }
}

// Fonction pour supprimer une facture
if (isset($_POST['supprimer'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM FACTURE WHERE ID_FACTURE = :id_facture");
        $stmt->execute([':id_facture' => $_POST['id_facture']]);
        echo "<p style='color: green;'>Facture supprimée avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de la suppression de la facture : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Factures</title>
    <link rel="stylesheet" href="stylegestionfacture.css">
</head>
<body>
    <h1>Gestion des Factures</h1>
    
    <form method="post">
        <div class="form-group">
            <label for="id_facture">ID Facture :</label>
            <input type="number" name="id_facture" required>

            <label for="montant_total_facture">Montant Total :</label>
            <input type="number" step="0.01" name="montant_total_facture" required>

            <label for="date_facture">Date Facture :</label>
            <input type="date" name="date_facture" required>

            <label for="id_reservation">ID Réservation :</label>
            <input type="number" name="id_reservation" required>
        </div>
        
        <div class="buttons">
            <button type="submit" name="ajouter">Ajouter</button>
            
        </div>
    </form>
    
    <a href="afficher_factures.php">
        <button class="consult-button">Consulter les Factures</button>
    </a>
</body>
</html>
