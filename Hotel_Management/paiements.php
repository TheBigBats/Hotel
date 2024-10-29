<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour insérer un paiement
if (isset($_POST['ajouter'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO PAIEMENT (ID_PAIEMENT, ID_FACTURE, ID_CLIENT, MONTANT_PAIEMENT, DATE_PAIEMENT) 
                                VALUES (:id_paiement, :id_facture, :id_client, :montant_paiement, TO_DATE(:date_paiement, 'YYYY-MM-DD'))");
        $stmt->execute([
            ':id_paiement' => $_POST['id_paiement'],
            ':id_facture' => $_POST['id_facture'],
            ':id_client' => $_POST['id_client'],
            ':montant_paiement' => $_POST['montant_paiement'],
            ':date_paiement' => $_POST['date_paiement'],
        ]);
        echo "<p style='color: black;'>Paiement ajouté avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de l'ajout du paiement : " . $e->getMessage() . "</p>";
    }
}

// Fonction pour mettre à jour un paiement
if (isset($_POST['modifier'])) {
    try {
        $stmt = $conn->prepare("UPDATE PAIEMENT 
                                SET ID_FACTURE = :id_facture, ID_CLIENT = :id_client, MONTANT_PAIEMENT = :montant_paiement, 
                                    DATE_PAIEMENT = TO_DATE(:date_paiement, 'YYYY-MM-DD') 
                                WHERE ID_PAIEMENT = :id_paiement");
        $stmt->execute([
            ':id_paiement' => $_POST['id_paiement'],
            ':id_facture' => $_POST['id_facture'],
            ':id_client' => $_POST['id_client'],
            ':montant_paiement' => $_POST['montant_paiement'],
            ':date_paiement' => $_POST['date_paiement'],
        ]);
        echo "<p style='color: black;'>Paiement modifié avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de la modification du paiement : " . $e->getMessage() . "</p>";
    }
}

// Fonction pour supprimer un paiement
if (isset($_POST['supprimer'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM PAIEMENT WHERE ID_PAIEMENT = :id_paiement");
        $stmt->execute([':id_paiement' => $_POST['id_paiement']]);
        echo "<p style='color: green;'>Paiement supprimé avec succès!</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>Erreur lors de la suppression du paiement : " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Paiements</title>
    <link rel="stylesheet" href="stylegestionpaiement.css">
</head>
<body>
    <h1>Gestion des Paiements</h1>
    
    <form method="post">
        <div class="form-group">
            <label for="id_paiement">ID Paiement :</label>
            <input type="number" name="id_paiement" required>

            <label for="id_facture">ID Facture :</label>
            <input type="number" name="id_facture" required>

            <label for="id_client">ID Client :</label>
            <input type="number" name="id_client" required>

            <label for="montant_paiement">Montant Paiement :</label>
            <input type="number" step="0.01" name="montant_paiement" required>

            <label for="date_paiement">Date Paiement :</label>
            <input type="date" name="date_paiement" required>
        </div>
        
        <div class="buttons">
            <button type="submit" name="ajouter">Ajouter</button>
        </div>
    </form>
    
    <a href="afficher_paiements.php">
        <button class="consult-button">Consulter les Paiements</button>
    </a>
</body>
</html>
