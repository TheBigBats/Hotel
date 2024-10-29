<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer tous les paiements
$stmt = $conn->query("SELECT * FROM PAIEMENT");
$paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Paiements</title>
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

        function modifierPaiement() {
            if (selectedRowId) {
                window.location.href = `paiement.php?id=${selectedRowId}`; 
            } else {
                alert('Veuillez sélectionner un paiement à modifier.');
            }
        }
    </script>
</head>
<body>
    <h1>Liste des Paiements</h1>
    <table>
        <thead>
            <tr>
                <th>ID Paiement</th>
                <th>ID Facture</th>
                <th>ID Client</th>
                <th>Montant</th>
                <th>Date de Paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paiements as $paiement): ?>
                <tr id="row-<?= htmlspecialchars($paiement['ID_PAIEMENT']) ?>" onclick="selectRow(<?= htmlspecialchars($paiement['ID_PAIEMENT']) ?>)">
                    <td><?= htmlspecialchars($paiement['ID_PAIEMENT']) ?></td>
                    <td><?= htmlspecialchars($paiement['ID_FACTURE']) ?></td>
                    <td><?= htmlspecialchars($paiement['ID_CLIENT']) ?></td>
                    <td><?= htmlspecialchars($paiement['MONTANT_PAIEMENT']) ?>€</td>
                    <td><?= htmlspecialchars($paiement['DATE_PAIEMENT']) ?></td>
                    <td>
                        <a href="paiement.php?id=<?= htmlspecialchars($paiement['ID_PAIEMENT']) ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="buttons">
        <a href="paiements.php">
            <button class="consult-button">Nouveau Paiement</button>
        </a>
    </div>
</body>
</html>
