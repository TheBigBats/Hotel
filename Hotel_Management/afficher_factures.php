<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer toutes les factures
$stmt = $conn->query("SELECT * FROM FACTURE");
$factures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Factures</title>
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

        function modifierChambre() {
            if (selectedRowId) {
                window.location.href = `reservation.php?id=${selectedRowId}`; 
            } else {
                alert('Veuillez sélectionner une facture à modifier.');
            }
        }
    </script>
</head>
<body>
    <h1>Liste des Factures</h1>
    <table>
        <thead>
            <tr>
                <th>ID Facture</th>
                <th>Montant</th>
                <th>Date de Facture</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($factures as $facture): ?>
                <tr id="row-<?= htmlspecialchars($facture['ID_FACTURE']) ?>" onclick="selectRow(<?= htmlspecialchars($facture['ID_FACTURE']) ?>)">
                    <td><?= htmlspecialchars($facture['ID_FACTURE']) ?></td>
                    <td><?= htmlspecialchars($facture['MONTANT_TOTAL_FACTURE']) ?>€</td>
                    <td><?= htmlspecialchars($facture['DATE_FACTURE']) ?></td>
                    <td>
                        <a href="facture.php?id=<?= htmlspecialchars($facture['ID_FACTURE']) ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="buttons">
        <a href="factures.php">
            <button class="consult-button">Nouvelle Facture</button>
        </a>
    </div>
</body>
</html>
