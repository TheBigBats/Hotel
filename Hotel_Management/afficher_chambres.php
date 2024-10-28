<?php
try {
    // Connexion à la base Oracle via PDO
    $conn = new PDO('oci:dbname=pdbestia', 'AFIFIBZ2425', 'AFIFIBZ242501');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Mode d'erreur
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer toutes les chambres
$stmt = $conn->query("SELECT * FROM CHAMBRE");
$chambres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Chambres</title>
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
                window.location.href = `gestion_chambres.php?id=${selectedRowId}`; // Redirection vers chambre.php avec l'ID de la chambre
            } else {
                alert('Veuillez sélectionner une chambre à modifier.');
            }
        }
    </script>
</head>

<body>
    <h1>Liste des Chambres</h1>

    <table>
        <thead>
            <tr>
                <th>ID Chambre</th>
                <th>Type Chambre</th>
                <th>Numéro Chambre</th>
                <th>Prix</th>
                <th>En Nettoyage</th>
                <th>Besoin de Maintenance</th>
                <th>Disponible</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chambres as $chambre): ?>
                <tr id="row-<?= htmlspecialchars($chambre['ID_CHAMBRE']) ?>" onclick="selectRow(<?= htmlspecialchars($chambre['ID_CHAMBRE']) ?>)">
                    <td><?= htmlspecialchars($chambre['ID_CHAMBRE']) ?></td>
                    <td><?= htmlspecialchars($chambre['CATEGORIE']) ?></td>
                    <td><?= htmlspecialchars($chambre['NUMERO_CHAMBRE']) ?></td>
                    <td><?= htmlspecialchars($chambre['TARIF']) ?> €</td>
                    <td><?= htmlspecialchars($chambre['EN_NETTOYAGE']) ? 'Oui' : 'Non' ?></td>
                    <td><?= htmlspecialchars($chambre['BESOIN_MAINTENANCE']) ? 'Oui' : 'Non' ?></td>
                    <td><?= htmlspecialchars($chambre['DISPONIBLE']) ? 'Oui' : 'Non' ?></td>
                    <td>
                        <a href="chambre.php?id=<?= htmlspecialchars($chambre['ID_CHAMBRE']) ?>">Modifier</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="buttons">
        <a href="chambres.php">
            <button class="consult-button">Nouveau</button>
        </a>
       
    </div>
</body>
</html>
