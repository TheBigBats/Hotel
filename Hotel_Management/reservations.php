<?php

try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour insérer une réservation
if (isset($_POST['ajouter'])) {
    $stmt = $conn->prepare("INSERT INTO RESERVATION (ID_RESERVATION, ID_CLIENT, ID_CHAMBRE, DATE_DEBUT, DATE_FIN) VALUES (:id_reservation, :id_client, :id_chambre, :date_debut, :date_fin)");
    $stmt->execute([
        ':id_reservation' => $_POST['id_reservation'],
        ':id_client' => $_POST['id_client'],
        ':id_chambre' => $_POST['id_chambre'],
        ':date_debut' => $_POST['date_debut'],
        ':date_fin' => $_POST['date_fin']
    ]);
    echo "Réservation ajoutée avec succès!";
}

// Fonction pour mettre à jour une réservation
if (isset($_POST['modifier'])) {
    $stmt = $conn->prepare("UPDATE RESERVATION SET ID_CLIENT = :id_client, ID_CHAMBRE = :id_chambre, DATE_DEBUT = :date_debut, DATE_FIN = :date_fin WHERE ID_RESERVATION = :id_reservation");
    $stmt->execute([
        ':id_reservation' => $_POST['id_reservation'],
        ':id_client' => $_POST['id_client'],
        ':id_chambre' => $_POST['id_chambre'],
        ':date_debut' => $_POST['date_debut'],
        ':date_fin' => $_POST['date_fin']
    ]);
    echo "Réservation modifiée avec succès!";
}

// Fonction pour supprimer une réservation
if (isset($_POST['supprimer'])) {
    $stmt = $conn->prepare("DELETE FROM RESERVATION WHERE ID_RESERVATION = :id_reservation");
    $stmt->execute([':id_reservation' => $_POST['id_reservation']]);
    echo "Réservation supprimée avec succès!";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réservations</title>
    <link rel="stylesheet" href="stylegestionreservation.css"> <!-- Assurez-vous d'avoir votre feuille de style -->
</head>
<body>
    <h1>Gestion des Réservations</h1>

    
    <form method="post">
        <div class="form-group">
            <label for="id_reservation">ID Réservation :</label>
            <input type="number" name="id_reservation" required>

            <label for="id_client">ID Client :</label>
            <input type="number" name="id_client" required>

            <label for="id_chambre">ID Chambre :</label>
            <input type="number" name="id_chambre" required>

            <label for="date_debut">Date Début :</label>
            <input type="date" name="date_debut" required>

            <label for="date_fin">Date Fin :</label>
            <input type="date" name="date_fin" required>
        </div>
        <div class="buttons">
            <button type="submit" name="ajouter">Ajouter</button>
            
        </div>
       
    </form>

    <a href="afficher_reservations.php">
        <button class="consult-button">Consulter les Réservations</button>
    </a>
</body>
</html>
