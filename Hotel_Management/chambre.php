<?php

if (isset($_GET['id'])) {
    $chambreId = $_GET['id'];

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Récupérer les détails de la chambre
    $stmt = $conn->prepare("SELECT * FROM CHAMBRE WHERE ID_CHAMBRE = :id");
    $stmt->execute(['id' => $chambreId]);
    $chambre = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si la chambre existe, affichez les détails pour modification
    if ($chambre) {
        // Afficher le formulaire pour modifier les informations de la chambre
        echo "<h1>Modifier la Chambre : " . htmlspecialchars($chambre['NUMERO_CHAMBRE']) . "</h1>";
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Modifier Chambre</title>
            <link rel="stylesheet" href="style6.css"> 
        </head>
        <body>
        <form action="update_chambre.php" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($chambre['ID_CHAMBRE']) ?>">

            <label for="numero">Numéro:</label>
            <input type="text" id="numero" name="numero" value="<?= htmlspecialchars($chambre['NUMERO_CHAMBRE']) ?>" required><br>

            <label for="categorie">Catégorie:</label>
            <select id="categorie" name="categorie" required>
                <option value="Standard" <?= $chambre['CATEGORIE'] === 'Standard' ? 'selected' : '' ?>>Standard</option>
                <option value="Deluxe" <?= $chambre['CATEGORIE'] === 'Deluxe' ? 'selected' : '' ?>>Deluxe</option>
                <option value="Suite" <?= $chambre['CATEGORIE'] === 'Suite' ? 'selected' : '' ?>>Suite</option>
                <option value="Lit Double" <?= $chambre['CATEGORIE'] === 'Lit Double' ? 'selected' : '' ?>>Lit Double</option>
            </select><br>

            <label for="disponible">Disponible:</label>
            <input type="checkbox" id="disponible" name="disponible" value="1" <?= $chambre['DISPONIBLE'] ? 'checked' : '' ?>><br>

            <label for="en_nettoyage">En Nettoyage:</label>
            <input type="checkbox" id="en_nettoyage" name="en_nettoyage" value="1" <?= $chambre['EN_NETTOYAGE'] ? 'checked' : '' ?>><br>

            <label for="besoin_maintenance">Besoin de Maintenance:</label>
            <input type="checkbox" id="besoin_maintenance" name="besoin_maintenance" value="1" <?= $chambre['BESOIN_MAINTENANCE'] ? 'checked' : '' ?>><br>

            <label for="prix">Prix:</label>
            <input type="text" id="prix" name="prix" value="<?= htmlspecialchars($chambre['TARIF']) ?>" required><br>

            <button type="submit" name="action" value="update">Mettre à jour</button>
            <button type="submit" name="action" value="delete">Supprimer</button>
        </form>  
        </body>
        </html>
        <?php
    } else {
        echo "Chambre non trouvée.";
    }
} else {
    echo "ID de la chambre manquant.";
}
?>
