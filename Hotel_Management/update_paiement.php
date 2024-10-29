<?php
// Vérifiez si les données ont été envoyées via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $paiementId = $_POST['id'];
    $action = $_POST['action']; // Vérifier si l'action est de mise à jour ou suppression

    // Connexion à la base de données Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Si l'action est de mise à jour
    if ($action === 'update') {
        $montant = $_POST['montant'];
        $date = $_POST['date'];
        $idFacture = $_POST['id_facture'];
        $idClient = $_POST['id_client'];

        // Préparer et exécuter la requête de mise à jour
        $stmt = $conn->prepare("UPDATE PAIEMENT SET MONTANT_PAIEMENT = :montant, DATE_PAIEMENT = TO_DATE(:date_paiement, 'YYYY-MM-DD'), ID_FACTURE = :id_facture, ID_CLIENT = :id_client WHERE ID_PAIEMENT = :id");

        // Exécution de la requête avec des valeurs
        $stmt->execute([
            'montant' => $montant,
            'date_paiement' => $date,
            'id_facture' => $idFacture,
            'id_client' => $idClient,
            'id' => $paiementId
        ]);

        // Rediriger vers afficher_paiements.php après la mise à jour
        header('Location: afficher_paiements.php?id=' . $paiementId);
        exit();
    }

    // Si l'action est de suppression
    elseif ($action === 'delete') {
        // Préparer et exécuter la requête de suppression
        $stmt = $conn->prepare("DELETE FROM PAIEMENT WHERE ID_PAIEMENT = :id");
        $stmt->execute(['id' => $paiementId]);

        // Rediriger vers la liste des paiements après la suppression
        header('Location: afficher_paiements.php');
        exit();
    }
} else {
    echo "Aucune donnée soumise.";
}
?>
