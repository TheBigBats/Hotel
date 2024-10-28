<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $idReservation = $_POST['id'];
    $idClient = $_POST['id_client'];
    $idChambre = $_POST['id_chambre'];
    $dateDebut = $_POST['date_debut'];
    $dateFin = $_POST['date_fin'];
    $action = $_POST['action']; // Récupérer l'action (update ou delete)

    // Connexion à la base Oracle via PDO
    try {
        $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }

    // Exécuter l'action en fonction de la valeur de $action
    if ($action == 'update') {
        // Préparer et exécuter la requête de mise à jour
        $stmt = $conn->prepare("UPDATE RESERVATION 
                                 SET ID_CLIENT = :id_client, 
                                     ID_CHAMBRE = :id_chambre, 
                                     DATE_DEBUT = TO_DATE(:date_debut, 'YYYY-MM-DD'), 
                                     DATE_FIN = TO_DATE(:date_fin, 'YYYY-MM-DD') 
                                 WHERE ID_RESERVATION = :id_reservation");

        
        $stmt->execute([
            'id_client' => $idClient,
            'id_chambre' => $idChambre,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'id_reservation' => $idReservation
        ]);

        echo "Réservation mise à jour avec succès!";
    } elseif ($action == 'delete') {
        // Préparer et exécuter la requête de suppression
        $stmt = $conn->prepare("DELETE FROM RESERVATION WHERE ID_RESERVATION = :id_reservation");
        $stmt->execute(['id_reservation' => $idReservation]);

        echo "Réservation supprimée avec succès!";
    } else {
        echo "Action non reconnue.";
    }

    // Rediriger vers afficher_reservations.php après l'action
    header('Location: afficher_reservations.php');
    exit();
} else {
    echo "Aucune donnée soumise.";
}
?>
