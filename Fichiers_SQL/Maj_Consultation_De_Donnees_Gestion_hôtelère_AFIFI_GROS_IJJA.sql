// Mise à jour la table RESERVATION
UPDATE RESERVATION
SET ID_CHAMBRE = 2
WHERE ID_RESERVATION = 1;

// Mise à jour la table CHAMBRE
UPDATE CHAMBRE
SET DISPONIBLE = 0
WHERE ID_CHAMBRE = 20;


// Supprimer les derniers 5 ligne de la table Reservation ( il reste 15 lignes)
DELETE FROM RESERVATION
WHERE ID_RESERVATION IN (
    SELECT ID_RESERVATION
    FROM (
        SELECT ID_RESERVATION
        FROM RESERVATION
        ORDER BY ID_RESERVATION DESC
    ) 
    WHERE ROWNUM <= 5
);
// Supprimer un client dans la table CLIENT
DELETE FROM CLIENT
WHERE ID_CLIENT = 7;

// Lister toutes les chambres disponibles

SELECT * FROM CHAMBRE
WHERE DISPONIBLE = 1;

// Obtenir toutes les factures pour un client spécifique

SELECT * FROM FACTURE F
JOIN RESERVATION R ON F.ID_RESERVATION = R.ID_RESERVATION
WHERE R.ID_CLIENT = 2;

//  Voir toutes les réservations pour une période donnée

SELECT * FROM RESERVATION
WHERE DATE_DEBUT >= TO_DATE('2024-10-01', 'YYYY-MM-DD')
AND DATE_FIN <= TO_DATE('2024-10-10', 'YYYY-MM-DD');
