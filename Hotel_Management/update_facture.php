<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $factureId = $_POST['id'];
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
        $montantTotal = $_POST['montant'];
        $date = $_POST['date'];
        $idReservation = $_POST['id_reservation'];

        // Préparer et exécuter la requête de mise à jour
        $stmt = $conn->prepare("UPDATE FACTURE SET MONTANT_TOTAL_FACTURE = :montant, DATE_FACTURE = TO_DATE(:date_facture, 'YYYY-MM-DD'), ID_RESERVATION = :id_reservation WHERE ID_FACTURE = :id");

        // Exécution de la requête avec des valeurs
        $stmt->execute([
            'montant' => $montantTotal,
            'date_facture' => $date, 
            'id_reservation' => $idReservation,
            'id' => $factureId
        ]);

        // Rediriger vers afficher_factures.php après la mise à jour
        header('Location: afficher_factures.php?id=' . $factureId);
        exit();
    }

    // Si l'action est de suppression
    elseif ($action === 'delete') {
        // Préparer et exécuter la requête de suppression
        $stmt = $conn->prepare("DELETE FROM FACTURE WHERE ID_FACTURE = :id");
        $stmt->execute(['id' => $factureId]);

        // Rediriger vers la liste des factures après la suppression
        header('Location: afficher_factures.php');
        exit();
    }
} else {
    echo "Aucune donnée soumise.";
}
?>
