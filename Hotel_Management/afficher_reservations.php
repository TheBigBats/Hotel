<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer toutes les réservations
$stmt = $conn->query("SELECT * FROM RESERVATION");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Réservations</title>
    <link rel="stylesheet" href="style5.css">
    <script>
        let selectedRowId = null;

        function selectRow(id) {
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.classList.remove('selected'); // Enlève la sélection des autres lignes
            });

            const selectedRow = document.getElementById(`row-${id}`);
            selectedRow.classList.add('selected'); // Surligne la ligne sélectionnée
            selectedRowId = id; // Enregistre l'ID de la ligne sélectionnée
        }

        function modifierReservation() {
            if (selectedRowId) {
                window.location.href = `reservation.php?id=${selectedRowId}`; // Redirection vers reservation.php avec l'ID de la réservation
            } else {
                alert('Veuillez sélectionner une réservation à modifier.');
            }
        }
    </script>
</head>

<body>
    <h1>Liste des Réservations</h1>

    <table>
        <thead>
            <tr>
                <th>ID Réservation</th>
                <th>ID Client</th>
                
                <th>ID Chambre</th>
                
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reservations)): ?>
                <tr>
                    <td colspan="9">Aucune réservation trouvée.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($reservations as $reservation): ?>
                    <tr id="row-<?= htmlspecialchars($reservation['ID_RESERVATION']) ?>" onclick="selectRow(<?= htmlspecialchars($reservation['ID_RESERVATION']) ?>)">
                        <td><?= htmlspecialchars($reservation['ID_RESERVATION']) ?></td>
                        <td><?= htmlspecialchars($reservation['ID_CLIENT']) ?></td>
                        <td><?= htmlspecialchars($reservation['ID_CHAMBRE']) ?></td>
                        
                        <td><?= htmlspecialchars($reservation['DATE_DEBUT']) ?></td>
                        <td><?= htmlspecialchars($reservation['DATE_FIN']) ?></td>
                        <td>
                            <a href="reservation.php?id=<?= htmlspecialchars($reservation['ID_RESERVATION']) ?>">Modifier</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="buttons">
        <a href="reservations.php">
            <button class="consult-button">Nouvelle Réservation</button>
        </a>
    </div>
</body>
</html>
