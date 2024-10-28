<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $clientId = $_POST['id'];

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Vérification de l'action (update ou delete)
    $action = $_POST['action'];

    if ($action === 'update') {
        // Récupérer les données du formulaire pour la mise à jour
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $civilite = $_POST['civilite'];
        $mobile = $_POST['mobile'];
        $adresse = $_POST['adresse'];
        $email = $_POST['email'];
        $ville = $_POST['ville'];
        $codePostal = $_POST['code_postal'];
        $pays = $_POST['pays'];

        // Requête de mise à jour
        $stmt = $conn->prepare("UPDATE CLIENT SET NOM = :nom, PRENOM = :prenom, CIVILITE = :civilite, MOBILE = :mobile, ADRESSE = :adresse, EMAIL = :email, VILLE = :ville, CODE_POSTAL = :code_postal, PAYS = :pays WHERE ID_CLIENT = :id");
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'civilite' => $civilite,
            'mobile' => $mobile,
            'adresse' => $adresse,
            'email' => $email,
            'ville' => $ville,
            'code_postal' => $codePostal,
            'pays' => $pays,
            'id' => $clientId
        ]);

        // Rediriger après mise à jour
        header('Location: afficher_clients.php?id=' . $clientId);
    } elseif ($action === 'delete') {
        // Requête de suppression
        $stmt = $conn->prepare("DELETE FROM CLIENT WHERE ID_CLIENT = :id");
        $stmt->execute(['id' => $clientId]);

        // Rediriger après suppression
        header('Location: afficher_clients.php');
    } else {
        echo "Action non valide.";
    }
    exit();
} else {
    echo "Aucune donnée soumise.";
}
?>
