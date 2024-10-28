<?php
if (isset($_GET['id'])) {
    $clientId = $_GET['id'];

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Récupérer les détails du client
    $stmt = $conn->prepare("SELECT * FROM CLIENT WHERE ID_CLIENT = :id");
    $stmt->execute(['id' => $clientId]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si le client existe, affiche les détails pour modification
    if ($client) {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Modifier Client</title>
            <link rel="stylesheet" href="style6.css"> 
        </head>
        <body>
            <h1>Modifier le Client : <?= htmlspecialchars($client['NOM']) ?></h1>
            <form action="update_client.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($client['ID_CLIENT']) ?>">
                
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['NOM']) ?>" required><br>
                
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($client['PRENOM']) ?>" required><br>
                
                <label for="civilite">Civilité:</label>
                <select id="civilite" name="civilite" required>
                    <option value="M." <?= $client['CIVILITE'] == 'M.' ? 'selected' : '' ?>>Mr</option>
                    <option value="Mme" <?= $client['CIVILITE'] == 'Mme' ? 'selected' : '' ?>>Mme</option>
                    <option value="Mlle" <?= $client['CIVILITE'] == 'Mlle' ? 'selected' : '' ?>>Mlle</option>
                </select><br>
                
                <label for="mobile">Mobile:</label>
                <input type="text" id="mobile" name="mobile" value="<?= htmlspecialchars($client['MOBILE']) ?>" required><br>
                
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($client['ADRESSE']) ?>" required><br>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($client['EMAIL']) ?>" required><br>
                
                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($client['VILLE']) ?>" required><br>
                
                <label for="code_postal">Code Postal:</label>
                <input type="text" id="code_postal" name="code_postal" value="<?= htmlspecialchars($client['CODE_POSTAL']) ?>" required><br>
                
                <label for="pays">Pays:</label>
                <input type="text" id="pays" name="pays" value="<?= htmlspecialchars($client['PAYS']) ?>" required><br>
                
                <!-- Bouton de mise à jour -->
                <button type="submit" name="action" value="update">Mettre à jour</button>
                
                <!-- Bouton de suppression -->
                <button type="submit" name="action" value="delete">Supprimer</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Client non trouvé.";
    }
} else {
    echo "ID du client manquant.";
}
?>
