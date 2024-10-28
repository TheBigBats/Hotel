<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour insérer une chambre
if (isset($_POST['ajouter'])) {
    $stmt = $conn->prepare("INSERT INTO CHAMBRE (ID_CHAMBRE, CATEGORIE, NUMERO_CHAMBRE, TARIF, DISPONIBLE, EN_NETTOYAGE, BESOIN_MAINTENANCE) VALUES (:id, :categorie, :numero, :tarif, :disponible, :en_nettoyage, :besoin_maintenance)");
    $stmt->execute([
        ':id' => $_POST['id_chambre'],
        ':categorie' => $_POST['type_chambre'], 
        ':numero' => $_POST['numero_chambre'],
        ':tarif' => $_POST['prix'],
        ':disponible' => isset($_POST['disponible']) ? 1 : 0, // 1 si disponible, sinon 0
        ':en_nettoyage' => isset($_POST['en_nettoyage']) ? 1 : 0, // 1 si en nettoyage, sinon 0
        ':besoin_maintenance' => isset($_POST['besoin_maintenance']) ? 1 : 0 // 1 si besoin de maintenance, sinon 0
    ]);
    echo "Chambre ajoutée avec succès!";
}

// Fonction pour mettre à jour une chambre
if (isset($_POST['modifier'])) {
    $stmt = $conn->prepare("UPDATE CHAMBRE SET CATEGORIE = :categorie, NUMERO_CHAMBRE = :numero, TARIF = :tarif, DISPONIBLE = :disponible, EN_NETTOYAGE = :en_nettoyage, BESOIN_MAINTENANCE = :besoin_maintenance WHERE ID_CHAMBRE = :id");
    $stmt->execute([
        ':id' => $_POST['id_chambre'],
        ':categorie' => $_POST['type_chambre'], 
        ':numero' => $_POST['numero_chambre'],
        ':tarif' => $_POST['prix'],
        ':disponible' => isset($_POST['disponible']) ? 1 : 0,
        ':en_nettoyage' => isset($_POST['en_nettoyage']) ? 1 : 0,
        ':besoin_maintenance' => isset($_POST['besoin_maintenance']) ? 1 : 0
    ]);
    echo "Chambre modifiée avec succès!";
}

// Fonction pour supprimer une chambre
if (isset($_POST['supprimer'])) {
    $stmt = $conn->prepare("DELETE FROM CHAMBRE WHERE ID_CHAMBRE = :id");
    $stmt->execute([':id' => $_POST['id_chambre']]);
    echo "Chambre supprimée avec succès!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Chambres</title>
    <link rel="stylesheet" href="stylegestionchambre.css">
</head>
<body>
    <h1>Gestion des Chambres</h1>

    
    <form method="post">
        <div class="form-group">
            <label for="id_chambre">ID Chambre :</label>
            <input type="number" name="id_chambre" required>
            <label for="numero_chambre">Numéro Chambre :</label>
            <input type="text" name="numero_chambre" required>

            <label for="type_chambre">Catégorie :</label> 
            <select name="type_chambre" required>
                <option value="Standard">Standard</option>
                <option value="Deluxe">Deluxe</option>
                <option value="Suite">Suite</option>
                <option value="Lit Double">Lit Double</option>
            </select>

            <label for="prix">Tarif :</label> 
            <input type="number" step="0.01" name="prix" required>

            <label for="en_nettoyage">En Nettoyage :</label>
            <input type="checkbox" name="en_nettoyage">

            <label for="besoin_maintenance">Besoin de Maintenance :</label>
            <input type="checkbox" name="besoin_maintenance">

            <label for="disponible">Disponible :</label>
            <input type="checkbox" name="disponible"> <!-- Case à cocher pour la disponibilité -->
        </div>
        <div class="form-buttons">
              <button type="submit" name="ajouter">Ajouter</button>
           </div>
    </form>
    <a href="afficher_chambres.php">
        <button class="consult-button">Consulter les Chambres</button>
    </a>
</body>
</html>
