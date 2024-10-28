<?php

try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour insérer un client
if (isset($_POST['ajouter'])) {
    $stmt = $conn->prepare("INSERT INTO CLIENT (ID_CLIENT, NOM, PRENOM, CIVILITE, MOBILE, ADRESSE, EMAIL, VILLE, CODE_POSTAL, PAYS) VALUES (:id, :nom, :prenom, :civilite, :mobile, :adresse, :email, :ville, :code_postal, :pays)");
    $stmt->execute([
        ':id' => $_POST['id_client'],
        ':nom' => strtoupper($_POST['nom']), // Nom en majuscules
        ':prenom' => ucfirst(strtolower($_POST['prenom'])), // Prénom avec première lettre en majuscule
        ':civilite' => ucfirst($_POST['civilite']),
        ':mobile' => $_POST['mobile'],
        ':adresse' => $_POST['adresse'],
        ':email' => $_POST['email'],
        ':ville' => ucfirst($_POST['ville']),
        ':code_postal' => $_POST['code_postal'],
        ':pays' => ucfirst($_POST['pays'])
    ]);
    echo "Client ajouté avec succès!";
}

// Fonction pour mettre à jour un client
if (isset($_POST['modifier'])) {
    $stmt = $conn->prepare("UPDATE CLIENT SET NOM = :nom, PRENOM = :prenom, CIVILITE = :civilite, MOBILE = :mobile, ADRESSE = :adresse, EMAIL = :email, VILLE = :ville, CODE_POSTAL = :code_postal, PAYS = :pays WHERE ID_CLIENT = :id");
    $stmt->execute([
        ':id' => $_POST['id_client'],
        ':nom' => strtoupper($_POST['nom']), // Nom en majuscules
        ':prenom' => ucfirst(strtolower($_POST['prenom'])), // Prénom avec première lettre en majuscule
        ':civilite' => ucfirst($_POST['civilite']),
        ':mobile' => $_POST['mobile'],
        ':adresse' => $_POST['adresse'],
        ':email' => $_POST['email'],
        ':ville' => ucfirst($_POST['ville']),
        ':code_postal' => $_POST['code_postal'],
        ':pays' => ucfirst($_POST['pays'])
    ]);
    echo "Client modifié avec succès!";
}

// Fonction pour supprimer un client
if (isset($_POST['supprimer'])) {
    $stmt = $conn->prepare("DELETE FROM CLIENT WHERE ID_CLIENT = :id");
    $stmt->execute([':id' => $_POST['id_client']]);
    echo "Client supprimé avec succès!";
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Clients</title>
    <link rel="stylesheet" href="stylegestionclient.css">
</head>
<body>
    <h1>Gestion des Clients</h1>
    

    <!-- Formulaire pour ajouter -->
    <form method="post">
    <div class="form-group">
        <label for="id_client">ID Client :</label>
        <input type="number" name="id_client" required>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required>

        <label for="civilite">Civilité :</label>
        <select name="civilite" required>
            <option value="Mr">Mr</option>
            <option value="Mme">Mme</option>
            <option value="Mlle">Mlle</option>
        </select>
    </div>

    <div class="form-group">
        <label for="mobile">Mobile :</label>
        <input type="text" name="mobile" required>

        <label for="adresse">Adresse :</label>
        <input type="text" name="adresse" required>

        <label for="email">Email :</label>
        <input type="email" name="email" required>

        <label for="ville">Ville :</label>
        <input type="text" name="ville" required>

        <label for="code_postal">Code Postal :</label>
        <input type="text" name="code_postal" required>

        <label for="pays">Pays :</label>
        <input type="text" name="pays" required>
    </div>
    
    <div class="buttons">
        <button type="submit" name="ajouter">Ajouter</button>
        
    </div>
  </form>
  
    <a href="afficher_clients.php">
        <button class="consult-button">Consulter les Clients</button>
    </a>
    
</body>
</html>
