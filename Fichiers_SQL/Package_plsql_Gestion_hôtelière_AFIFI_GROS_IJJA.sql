// Gestion de client
CREATE OR REPLACE PACKAGE Gestion_Clients AS
    PROCEDURE Ajouter_Client(
        p_id_client NUMBER,
        p_nom VARCHAR2,
        p_prenom VARCHAR2,
        p_civilite VARCHAR2,
        p_poste VARCHAR2,
        p_mobile VARCHAR2,
        p_adresse VARCHAR2,
        p_email VARCHAR2,
        p_ville VARCHAR2,
        p_code_postal VARCHAR2,
        p_pays VARCHAR2
    );

    PROCEDURE Modifier_Client(
        p_id_client NUMBER,
        p_nom VARCHAR2,
        p_prenom VARCHAR2,
        p_civilite VARCHAR2,
        p_poste VARCHAR2,
        p_mobile VARCHAR2,
        p_adresse VARCHAR2,
        p_email VARCHAR2,
        p_ville VARCHAR2,
        p_code_postal VARCHAR2,
        p_pays VARCHAR2
    );

    PROCEDURE Supprimer_Client(
        p_id_client NUMBER
    );

    FUNCTION Obtenir_Client(
        p_id_client NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Clients;
/


// Package body 
CREATE OR REPLACE PACKAGE BODY Gestion_Clients AS
    PROCEDURE Ajouter_Client(
        p_id_client NUMBER,
        p_nom VARCHAR2,
        p_prenom VARCHAR2,
        p_civilite VARCHAR2,
        p_poste VARCHAR2,
        p_mobile VARCHAR2,
        p_adresse VARCHAR2,
        p_email VARCHAR2,
        p_ville VARCHAR2,
        p_code_postal VARCHAR2,
        p_pays VARCHAR2
    ) IS
    BEGIN
        INSERT INTO CLIENT (ID_CLIENT, NOM, PRENOM, CIVILITE, POSTE, MOBILE, ADRESSE, EMAIL, VILLE, CODE_POSTAL, PAYS)
        VALUES (p_id_client, p_nom, p_prenom, p_civilite, p_poste, p_mobile, p_adresse, p_email, p_ville, p_code_postal, p_pays);
        COMMIT;
    END Ajouter_Client;

    PROCEDURE Modifier_Client(
        p_id_client NUMBER,
        p_nom VARCHAR2,
        p_prenom VARCHAR2,
        p_civilite VARCHAR2,
        p_poste VARCHAR2,
        p_mobile VARCHAR2,
        p_adresse VARCHAR2,
        p_email VARCHAR2,
        p_ville VARCHAR2,
        p_code_postal VARCHAR2,
        p_pays VARCHAR2
    ) IS
    BEGIN
        UPDATE CLIENT
        SET NOM = p_nom, PRENOM = p_prenom, CIVILITE = p_civilite, POSTE = p_poste,
            MOBILE = p_mobile, ADRESSE = p_adresse, EMAIL = p_email, VILLE = p_ville,
            CODE_POSTAL = p_code_postal, PAYS = p_pays
        WHERE ID_CLIENT = p_id_client;
        COMMIT;
    END Modifier_Client;

    PROCEDURE Supprimer_Client(
        p_id_client NUMBER
    ) IS
    BEGIN
        DELETE FROM CLIENT WHERE ID_CLIENT = p_id_client;
        COMMIT;
    END Supprimer_Client;

    FUNCTION Obtenir_Client(
        p_id_client NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR SELECT * FROM CLIENT WHERE ID_CLIENT = p_id_client;
        RETURN l_cursor;
    END Obtenir_Client;
END Gestion_Clients;
/

// Test : Ajouter_Client
BEGIN
    
    Gestion_Clients.Ajouter_Client(
        p_id_client => 21,
        p_nom => 'DUPONT',
        p_prenom => 'Victor',
        p_civilite => 'Mr',
        p_poste => 'Ingénieur',
        p_mobile => '+33606060618',
        p_adresse => '16 Rue de la République',
        p_email => 'Victor.dupont@mail.com',
        p_ville => 'Lyon',
        p_code_postal => '69001',
        p_pays => 'France'
    );
    -- Affichage d'un message pour indiquer que l'insertion est réussie
    DBMS_OUTPUT.PUT_LINE('Client ajouté avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout du client : ' || SQLERRM);
END;

// Test : Modifier_Client
BEGIN
    
    Gestion_Clients.Modifier_Client(
        p_id_client => 21,
        p_nom => 'DURAND',
        p_prenom => 'Victor',
        p_civilite => 'Mr',
        p_poste => 'Ingénieur',
        p_mobile => '+33606060618',
        p_adresse => '16 Rue de la République',
        p_email => 'Victor.durand@mail.com',
        p_ville => 'Lyon',
        p_code_postal => '69001',
        p_pays => 'France'
    );
    -- Affichage d'un message pour indiquer que la modification est réussie
    DBMS_OUTPUT.PUT_LINE('Client modifié avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la modification du client : ' || SQLERRM);
END;
// Test : Supprimer_Client
BEGIN
    -- Appel de la procédure pour supprimer un client
    Gestion_Clients.Supprimer_Client(p_id_client => 21);
    
    -- Affichage d'un message pour indiquer que la suppression est réussie
    DBMS_OUTPUT.PUT_LINE('Client supprimé avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression du client : ' || SQLERRM);
END;

// Test : Obtenir_Client
DECLARE
    v_client SYS_REFCURSOR;
    v_id_client CLIENT.ID_CLIENT%TYPE;
    v_nom CLIENT.NOM%TYPE;
    v_prenom CLIENT.PRENOM%TYPE;
    v_civilite CLIENT.CIVILITE%TYPE;
    v_poste CLIENT.POSTE%TYPE;
    v_mobile CLIENT.MOBILE%TYPE;
    v_adresse CLIENT.ADRESSE%TYPE;
    v_email CLIENT.EMAIL%TYPE;
    v_ville CLIENT.VILLE%TYPE;
    v_code_postal CLIENT.CODE_POSTAL%TYPE;
    v_pays CLIENT.PAYS%TYPE;
BEGIN
    -- Appel de la fonction pour récupérer les informations d'un client
    v_client := Gestion_Clients.Obtenir_Client(p_id_client => 10);

    
    LOOP
        FETCH v_client INTO v_id_client, v_nom, v_prenom, v_civilite, v_poste, v_mobile, v_adresse, v_email, v_ville, v_code_postal, v_pays;
        EXIT WHEN v_client%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('ID: ' || v_id_client || ', Nom: ' || v_nom || ', Prénom: ' || v_prenom || ', Civilité: ' || v_civilite);
        DBMS_OUTPUT.PUT_LINE('Poste: ' || v_poste || ', Mobile: ' || v_mobile || ', Adresse: ' || v_adresse || ', Email: ' || v_email);
        DBMS_OUTPUT.PUT_LINE('Ville: ' || v_ville || ', Code Postal: ' || v_code_postal || ', Pays: ' || v_pays);
    END LOOP;
    
    CLOSE v_client;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération des informations du client : ' || SQLERRM);
END;

// Gestion des chambres 

CREATE OR REPLACE PACKAGE Gestion_Chambres AS
    PROCEDURE Ajouter_Chambre(
        p_id_chambre NUMBER,
        p_numero_chambre NUMBER,
        p_categorie VARCHAR2,
        p_tarif NUMBER,
        p_disponible NUMBER,
        p_en_nettoyage NUMBER,
        p_besoin_maintenance NUMBER
    );

    PROCEDURE Modifier_Chambre(
        p_id_chambre NUMBER,
        p_numero_chambre NUMBER,
        p_categorie VARCHAR2,
        p_tarif NUMBER,
        p_disponible NUMBER,
        p_en_nettoyage NUMBER,
        p_besoin_maintenance NUMBER
    );

    PROCEDURE Supprimer_Chambre(
        p_id_chambre NUMBER
    );

    FUNCTION Obtenir_Chambre(
        p_id_chambre NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Chambres;
/

// package body 

CREATE OR REPLACE PACKAGE BODY Gestion_Chambres AS
    PROCEDURE Ajouter_Chambre(
        p_id_chambre NUMBER,
        p_numero_chambre NUMBER,
        p_categorie VARCHAR2,
        p_tarif NUMBER,
        p_disponible NUMBER,
        p_en_nettoyage NUMBER,
        p_besoin_maintenance NUMBER
    ) IS
    BEGIN
        INSERT INTO CHAMBRE (ID_CHAMBRE, NUMERO_CHAMBRE, CATEGORIE, TARIF, DISPONIBLE, EN_NETTOYAGE, BESOIN_MAINTENANCE)
        VALUES (p_id_chambre, p_numero_chambre, p_categorie, p_tarif, p_disponible, p_en_nettoyage, p_besoin_maintenance);
        COMMIT;
    END Ajouter_Chambre;

    PROCEDURE Modifier_Chambre(
        p_id_chambre NUMBER,
        p_numero_chambre NUMBER,
        p_categorie VARCHAR2,
        p_tarif NUMBER,
        p_disponible NUMBER,
        p_en_nettoyage NUMBER,
        p_besoin_maintenance NUMBER
    ) IS
    BEGIN
        UPDATE CHAMBRE
        SET NUMERO_CHAMBRE = p_numero_chambre,
            CATEGORIE = p_categorie,
            TARIF = p_tarif,
            DISPONIBLE = p_disponible,
            EN_NETTOYAGE = p_en_nettoyage,
            BESOIN_MAINTENANCE = p_besoin_maintenance
        WHERE ID_CHAMBRE = p_id_chambre;
        COMMIT;
    END Modifier_Chambre;

    PROCEDURE Supprimer_Chambre(
        p_id_chambre NUMBER
    ) IS
    BEGIN
        DELETE FROM CHAMBRE WHERE ID_CHAMBRE = p_id_chambre;
        COMMIT;
    END Supprimer_Chambre;

    FUNCTION Obtenir_Chambre(
        p_id_chambre NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR SELECT * FROM CHAMBRE WHERE ID_CHAMBRE = p_id_chambre;
        RETURN l_cursor;
    END Obtenir_Chambre;
END Gestion_Chambres;
/

// Test : Ajouter une chambre 

BEGIN
    Gestion_Chambres.Ajouter_Chambre(
        p_id_chambre => 21,
        p_numero_chambre => 113,
        p_categorie => 'Suite',
        p_tarif => 150,
        p_disponible => 1,
        p_en_nettoyage => 0,
        p_besoin_maintenance => 0
    );
    DBMS_OUTPUT.PUT_LINE('Chambre ajoutée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout de la chambre : ' || SQLERRM);
END;
/

// Test : Modifier_Chambre

BEGIN
    Gestion_Chambres.Modifier_Chambre(
        p_id_chambre => 21,
        p_numero_chambre => 113,
        p_categorie => 'Suite',
        p_tarif => 160,
        p_disponible => 0,
        p_en_nettoyage => 1,
        p_besoin_maintenance => 0
    );
    DBMS_OUTPUT.PUT_LINE('Chambre modifiée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la modification de la chambre : ' || SQLERRM);
END;
/

// Test : Supprimer_Chambre

BEGIN
    Gestion_Chambres.Supprimer_Chambre(p_id_chambre => 21);
    DBMS_OUTPUT.PUT_LINE('Chambre supprimée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression de la chambre : ' || SQLERRM);
END;
/

// Test : Obtenir_Chambre
DECLARE
    v_chambre SYS_REFCURSOR;
    v_id_chambre CHAMBRE.ID_CHAMBRE%TYPE;
    v_numero_chambre CHAMBRE.NUMERO_CHAMBRE%TYPE;
    v_categorie CHAMBRE.CATEGORIE%TYPE;
    v_tarif CHAMBRE.TARIF%TYPE;
    v_disponible CHAMBRE.DISPONIBLE%TYPE;
    v_en_nettoyage CHAMBRE.EN_NETTOYAGE%TYPE;
    v_besoin_maintenance CHAMBRE.BESOIN_MAINTENANCE%TYPE;
BEGIN
    -- Appel de la fonction pour récupérer les informations d'une chambre
    v_chambre := Gestion_Chambres.Obtenir_Chambre(p_id_chambre => 13);

    
    LOOP
        FETCH v_chambre INTO v_id_chambre, v_numero_chambre, v_categorie, v_tarif, v_disponible, v_en_nettoyage, v_besoin_maintenance;
        EXIT WHEN v_chambre%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('ID Chambre: ' || v_id_chambre || ', Numéro: ' || v_numero_chambre || 
                             ', Catégorie: ' || v_categorie || ', Tarif: ' || v_tarif || 
                             ', Disponible: ' || v_disponible || ', En Nettoyage: ' || v_en_nettoyage || 
                             ', Besoin de Maintenance: ' || v_besoin_maintenance);
    END LOOP;

    -- Fermeture du curseur
    CLOSE v_chambre;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération des informations de la chambre : ' || SQLERRM);
END;
/


// Gestion des réservations 
CREATE OR REPLACE PACKAGE Gestion_Reservations AS
    PROCEDURE Ajouter_Reservation(
        p_id_reservation NUMBER,
        p_id_client NUMBER,
        p_id_chambre NUMBER,
        p_date_debut DATE,
        p_date_fin DATE
    );

    PROCEDURE Modifier_Reservation(
        p_id_reservation NUMBER,
        p_id_client NUMBER,
        p_id_chambre NUMBER,
        p_date_debut DATE,
        p_date_fin DATE
    );

    PROCEDURE Supprimer_Reservation(
        p_id_reservation NUMBER
    );

    FUNCTION Obtenir_Reservation(
        p_id_reservation NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Reservations;
/

// Package body 
CREATE OR REPLACE PACKAGE BODY Gestion_Reservations AS
    PROCEDURE Ajouter_Reservation(
        p_id_reservation NUMBER,
        p_id_client NUMBER,
        p_id_chambre NUMBER,
        p_date_debut DATE,
        p_date_fin DATE
    ) IS
    BEGIN
        INSERT INTO RESERVATION (ID_RESERVATION, ID_CLIENT, ID_CHAMBRE, DATE_DEBUT, DATE_FIN)
        VALUES (p_id_reservation, p_id_client, p_id_chambre, p_date_debut, p_date_fin);
        COMMIT;
    END Ajouter_Reservation;

    PROCEDURE Modifier_Reservation(
        p_id_reservation NUMBER,
        p_id_client NUMBER,
        p_id_chambre NUMBER,
        p_date_debut DATE,
        p_date_fin DATE
    ) IS
    BEGIN
        UPDATE RESERVATION
        SET ID_CLIENT = p_id_client, DATE_DEBUT = p_date_debut, DATE_FIN = p_date_fin
        WHERE ID_RESERVATION = p_id_reservation;
        COMMIT;
    END Modifier_Reservation;

    PROCEDURE Supprimer_Reservation(
        p_id_reservation NUMBER
    ) IS
    BEGIN
        DELETE FROM RESERVATION WHERE ID_RESERVATION = p_id_reservation;
        COMMIT;
    END Supprimer_Reservation;

    FUNCTION Obtenir_Reservation(
        p_id_reservation NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR SELECT * FROM RESERVATION WHERE ID_RESERVATION = p_id_reservation;
        RETURN l_cursor;
    END Obtenir_Reservation;
END Gestion_Reservations;
/

// Test : Ajouter_Chambre

BEGIN
    Gestion_Reservations.Ajouter_Reservation(
        p_id_reservation => 16,
        p_id_client => 7,
        p_id_chambre => 12,  -- ID de la chambre manquante ajouté ici
        p_date_debut => TO_DATE('2024-11-01', 'YYYY-MM-DD'),
        p_date_fin => TO_DATE('2024-11-10', 'YYYY-MM-DD')
    );
    DBMS_OUTPUT.PUT_LINE('Réservation ajoutée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout de la réservation : ' || SQLERRM);
END;
/

// Test : Modifier_Reservation

BEGIN
    Gestion_Reservations.Modifier_Reservation(
        p_id_reservation => 16,
        p_id_client => 12,
        p_id_chambre => 10,
        p_date_debut => TO_DATE('2024-12-01', 'YYYY-MM-DD'),
        p_date_fin => TO_DATE('2024-12-15', 'YYYY-MM-DD')
    );
    DBMS_OUTPUT.PUT_LINE('Réservation modifiée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la modification de la réservation : ' || SQLERRM);
END;
/

// Test : Supprimer_Reservation

BEGIN
    Gestion_Reservations.Supprimer_Reservation(p_id_reservation => 16);
    DBMS_OUTPUT.PUT_LINE('Réservation supprimée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression de la réservation : ' || SQLERRM);
END;
/

// Test : Obtenir_Reservation

DECLARE
    v_reservation SYS_REFCURSOR;
    v_id_reservation RESERVATION.ID_RESERVATION%TYPE;
    v_id_client RESERVATION.ID_CLIENT%TYPE;
    v_id_chambre RESERVATION.ID_CHAMBRE%TYPE;
    v_date_debut RESERVATION.DATE_DEBUT%TYPE;
    v_date_fin RESERVATION.DATE_FIN%TYPE;
BEGIN
    -- Appel de la fonction pour obtenir les détails d'une réservation
    v_reservation := Gestion_Reservations.Obtenir_Reservation(p_id_reservation => 10);

    LOOP
        FETCH v_reservation INTO v_id_reservation, v_id_client, v_id_chambre, v_date_debut, v_date_fin;
        EXIT WHEN v_reservation%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('ID Réservation: ' || v_id_reservation || 
                             ', Client ID: ' || v_id_client || 
                             ', Chambre ID: ' || v_id_chambre || 
                             ', Date de début: ' || v_date_debut || 
                             ', Date de fin: ' || v_date_fin);
    END LOOP;

    -- Fermeture du curseur
    CLOSE v_reservation;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération de la réservation : ' || SQLERRM);
END;



// Gestion des factures 
CREATE OR REPLACE PACKAGE Gestion_Factures AS
    PROCEDURE Ajouter_Facture(
        p_id_facture NUMBER,
        p_montant_total_facture NUMBER,
        p_date_facture DATE,
        p_id_reservation NUMBER
    );

    PROCEDURE Modifier_Facture(
        p_id_facture NUMBER,
        p_montant_total_facture NUMBER,
        p_date_facture DATE,
        p_id_reservation NUMBER
    );

    PROCEDURE Supprimer_Facture(
        p_id_facture NUMBER
    );

    FUNCTION Obtenir_Facture(
        p_id_facture NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Factures;
/

// package body

CREATE OR REPLACE PACKAGE BODY Gestion_Factures AS
    PROCEDURE Ajouter_Facture(
        p_id_facture NUMBER,
        p_montant_total_facture NUMBER,
        p_date_facture DATE,
        p_id_reservation NUMBER
    ) IS
    BEGIN
        INSERT INTO FACTURE (ID_FACTURE, MONTANT_TOTAL_FACTURE, DATE_FACTURE, ID_RESERVATION)
        VALUES (p_id_facture, p_montant_total_facture, p_date_facture, p_id_reservation);
        COMMIT;
    END Ajouter_Facture;

    PROCEDURE Modifier_Facture(
        p_id_facture NUMBER,
        p_montant_total_facture NUMBER,
        p_date_facture DATE,
        p_id_reservation NUMBER
    ) IS
    BEGIN
        UPDATE FACTURE
        SET MONTANT_TOTAL_FACTURE = p_montant_total_facture,
            DATE_FACTURE = p_date_facture,
            ID_RESERVATION = p_id_reservation
        WHERE ID_FACTURE = p_id_facture;
        COMMIT;
    END Modifier_Facture;

    PROCEDURE Supprimer_Facture(
        p_id_facture NUMBER
    ) IS
    BEGIN
        DELETE FROM FACTURE WHERE ID_FACTURE = p_id_facture;
        COMMIT;
    END Supprimer_Facture;

    FUNCTION Obtenir_Facture(
        p_id_facture NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR SELECT * FROM FACTURE WHERE ID_FACTURE = p_id_facture;
        RETURN l_cursor;
    END Obtenir_Facture;
END Gestion_Factures;
/

// Test : Ajouter_Facture

BEGIN
    Gestion_Factures.Ajouter_Facture(
        p_id_facture => 16,
        p_montant_total_facture => 600,
        p_date_facture => TO_DATE('2024-10-24', 'YYYY-MM-DD'),
        p_id_reservation => 10
    );
    DBMS_OUTPUT.PUT_LINE('Facture ajoutée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout de la facture : ' || SQLERRM);
END;

// Test : Modifier_Facture
BEGIN
    Gestion_Factures.Modifier_Facture(
        p_id_facture => 16,
        p_montant_total_facture => 650,
        p_date_facture => TO_DATE('2024-10-24', 'YYYY-MM-DD'),
        p_id_reservation => 4
    );
    DBMS_OUTPUT.PUT_LINE('Facture modifiée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la modification de la facture : ' || SQLERRM);
END;

// Test : Supprimer_Facture

BEGIN
    Gestion_Factures.Supprimer_Facture(p_id_facture => 16);
    DBMS_OUTPUT.PUT_LINE('Facture supprimée avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression de la facture : ' || SQLERRM);
END;

// Test : Obtenir_Facture

DECLARE
    v_facture SYS_REFCURSOR;
    v_montant_total_facture FACTURE.MONTANT_TOTAL_FACTURE%TYPE;
    v_date_facture FACTURE.DATE_FACTURE%TYPE;
    v_id_reservation FACTURE.ID_RESERVATION%TYPE;
BEGIN
    v_facture := Gestion_Factures.Obtenir_Facture(p_id_facture => 14);

    LOOP
        FETCH v_facture INTO v_montant_total_facture, v_date_facture, v_id_reservation;
        EXIT WHEN v_facture%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('Montant: ' || v_montant_total_facture || ', Date: ' || v_date_facture || ', Réservation: ' || v_id_reservation);
    END LOOP;

    CLOSE v_facture;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération des détails de la facture : ' || SQLERRM);
END;



// Gestion des paiements

CREATE OR REPLACE PACKAGE Gestion_Paiements AS
    PROCEDURE Ajouter_Paiement(
        p_id_paiement NUMBER,
        p_id_facture NUMBER,
        p_id_client NUMBER,
        p_montant_paiement NUMBER,
        p_date_paiement DATE
    );

    PROCEDURE Modifier_Paiement(
        p_id_paiement NUMBER,
        p_id_facture NUMBER,
        p_id_client NUMBER,
        p_montant_paiement NUMBER,
        p_date_paiement DATE
    );

    PROCEDURE Supprimer_Paiement(
        p_id_paiement NUMBER
    );

    FUNCTION Obtenir_Paiement(
        p_id_paiement NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Paiements;
/

// Package body

CREATE OR REPLACE PACKAGE BODY Gestion_Paiements AS
    PROCEDURE Ajouter_Paiement(
        p_id_paiement NUMBER,
        p_id_facture NUMBER,
        p_id_client NUMBER,
        p_montant_paiement NUMBER,
        p_date_paiement DATE
    ) IS
    BEGIN
        INSERT INTO PAIEMENT (ID_PAIEMENT, ID_FACTURE, ID_CLIENT, MONTANT_PAIEMENT, DATE_PAIEMENT)
        VALUES (p_id_paiement, p_id_facture, p_id_client, p_montant_paiement, p_date_paiement);
        COMMIT;
    END Ajouter_Paiement;

    PROCEDURE Modifier_Paiement(
        p_id_paiement NUMBER,
        p_id_facture NUMBER,
        p_id_client NUMBER,
        p_montant_paiement NUMBER,
        p_date_paiement DATE
    ) IS
    BEGIN
        UPDATE PAIEMENT
        SET ID_FACTURE = p_id_facture,
            ID_CLIENT = p_id_client,
            MONTANT_PAIEMENT = p_montant_paiement,
            DATE_PAIEMENT = p_date_paiement
        WHERE ID_PAIEMENT = p_id_paiement;
        COMMIT;
    END Modifier_Paiement;

    PROCEDURE Supprimer_Paiement(
        p_id_paiement NUMBER
    ) IS
    BEGIN
        DELETE FROM PAIEMENT WHERE ID_PAIEMENT = p_id_paiement;
        COMMIT;
    END Supprimer_Paiement;

    FUNCTION Obtenir_Paiement(
        p_id_paiement NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR SELECT * FROM PAIEMENT WHERE ID_PAIEMENT = p_id_paiement;
        RETURN l_cursor;
    END Obtenir_Paiement;
END Gestion_Paiements;
/
//
Test : Ajouter_Paiement

BEGIN
    Gestion_Paiements.Ajouter_Paiement(
        p_id_paiement => 16,
        p_id_facture => 14,
        p_id_client => 10,
        p_montant_paiement => 600,
        p_date_paiement => TO_DATE('2024-11-03', 'YYYY-MM-DD')
    );
    DBMS_OUTPUT.PUT_LINE('Paiement ajouté avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout du paiement : ' || SQLERRM);
END;


Test : Modifier_Paiement

BEGIN
    Gestion_Paiements.Modifier_Paiement(
        p_id_paiement => 16,
        p_id_facture => 14,
        p_id_client => 10,
        p_montant_paiement => 650,
        p_date_paiement => TO_DATE('2024-10-24', 'YYYY-MM-DD')
    );
    DBMS_OUTPUT.PUT_LINE('Paiement modifié avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la modification du paiement : ' || SQLERRM);
END;

// Test : Supprimer_Paiement

BEGIN
    Gestion_Paiements.Supprimer_Paiement(p_id_paiement => 16);
    DBMS_OUTPUT.PUT_LINE('Paiement supprimé avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression du paiement : ' || SQLERRM);
END;

// Test : Obtenir_Paiement

DECLARE
    v_paiement SYS_REFCURSOR;
    v_id_facture PAIEMENT.ID_FACTURE%TYPE;
    v_id_client PAIEMENT.ID_CLIENT%TYPE;
    v_montant_paiement PAIEMENT.MONTANT_PAIEMENT%TYPE;
    v_date_paiement PAIEMENT.DATE_PAIEMENT%TYPE;
BEGIN
    v_paiement := Gestion_Paiements.Obtenir_Paiement(p_id_paiement => 10);

    LOOP
        FETCH v_paiement INTO v_id_facture, v_id_client, v_montant_paiement, v_date_paiement;
        EXIT WHEN v_paiement%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('Facture ID: ' || v_id_facture || ', Client ID: ' || v_id_client || ', Montant: ' || v_montant_paiement || ', Date: ' || v_date_paiement);
    END LOOP;

    CLOSE v_paiement;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération des détails du paiement : ' || SQLERRM);
END;

// Gestion des utilisateurs

CREATE OR REPLACE PACKAGE Gestion_Utilisateurs AS
    PROCEDURE Ajouter_Utilisateur(
        p_id_utilisateur NUMBER,
        p_role_utilisateur VARCHAR2,
        p_mot_de_passe VARCHAR2
    );

    PROCEDURE Modifier_Utilisateur(
        p_id_utilisateur NUMBER,
        p_role_utilisateur VARCHAR2,
        p_mot_de_passe VARCHAR2
    );

    PROCEDURE Supprimer_Utilisateur(
        p_id_utilisateur NUMBER
    );

    
    FUNCTION Verifier_Utilisateur(
        p_id_utilisateur NUMBER,
        p_mot_de_passe VARCHAR2
    ) RETURN NUMBER;  -- Retourne 1 pour TRUE, 0 pour FALSE
    
    FUNCTION Obtenir_Utilisateur(
        p_id_utilisateur NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Utilisateurs;
/



// Package body

CREATE OR REPLACE PACKAGE BODY Gestion_Utilisateurs AS
    PROCEDURE Ajouter_Utilisateur(
        p_id_utilisateur NUMBER,
        p_role_utilisateur VARCHAR2,
        p_mot_de_passe VARCHAR2
    ) IS
    BEGIN
        INSERT INTO UTILISATEUR (ID_UTILISATEUR, ROLE_UTILISATEUR, MOT_DE_PASSE)
        VALUES (p_id_utilisateur, p_role_utilisateur, p_mot_de_passe);
        COMMIT;
    END Ajouter_Utilisateur;

    PROCEDURE Modifier_Utilisateur(
        p_id_utilisateur NUMBER,
        p_role_utilisateur VARCHAR2,
        p_mot_de_passe VARCHAR2
    ) IS
    BEGIN
        UPDATE UTILISATEUR
        SET ROLE_UTILISATEUR = p_role_utilisateur, MOT_DE_PASSE = p_mot_de_passe
        WHERE ID_UTILISATEUR = p_id_utilisateur;
        COMMIT;
    END Modifier_Utilisateur;

    PROCEDURE Supprimer_Utilisateur(
        p_id_utilisateur NUMBER
    ) IS
    BEGIN
        DELETE FROM UTILISATEUR WHERE ID_UTILISATEUR = p_id_utilisateur;
        COMMIT;
    END Supprimer_Utilisateur;
FUNCTION Verifier_Utilisateur(
        p_id_utilisateur NUMBER,
        p_mot_de_passe VARCHAR2
    ) RETURN NUMBER IS
        v_mot_de_passe UTILISATEUR.MOT_DE_PASSE%TYPE;
    BEGIN
        SELECT MOT_DE_PASSE INTO v_mot_de_passe
        FROM UTILISATEUR
        WHERE ID_UTILISATEUR = p_id_utilisateur;
        
        IF v_mot_de_passe = p_mot_de_passe THEN
            RETURN 1;  -- Mot de passe correct
        ELSE
            RETURN 0;  -- Mot de passe incorrect
        END IF;
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            RETURN 0;  -- Utilisateur non trouvé ou mot de passe incorrect
    END Verifier_Utilisateur;
    
    FUNCTION Obtenir_Utilisateur(
        p_id_utilisateur NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR SELECT * FROM UTILISATEUR WHERE ID_UTILISATEUR = p_id_utilisateur;
        RETURN l_cursor;
    END Obtenir_Utilisateur;
END Gestion_Utilisateurs;
/

// Test : Ajouter_Utilisateur

BEGIN
    -- Test d'ajout d'un utilisateur
    Gestion_Utilisateurs.Ajouter_Utilisateur(
        p_id_utilisateur => 21,
        p_role_utilisateur => 'Admin',
        p_mot_de_passe => 'AdminPass2024!'
    );
    DBMS_OUTPUT.PUT_LINE('Utilisateur ajouté avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout de l''utilisateur : ' || SQLERRM);
END;
/

// Tester : Modifier_Utilisateur

BEGIN
    -- Test de modification d'un utilisateur
    Gestion_Utilisateurs.Modifier_Utilisateur(
        p_id_utilisateur => 21,
        p_role_utilisateur => 'Gestionnaire',
        p_mot_de_passe => 'GestionPass2024!'
    );
    DBMS_OUTPUT.PUT_LINE('Utilisateur modifié avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la modification de l''utilisateur : ' || SQLERRM);
END;
/

// Test : Verifier_Utilisateur
DECLARE
    v_result NUMBER;
BEGIN
    -- Test de vérification des identifiants d'un utilisateur (login)
    v_result := Gestion_Utilisateurs.Verifier_Utilisateur(p_id_utilisateur => 21, p_mot_de_passe => 'GestionPass2024!');

    IF v_result = 1 THEN
        DBMS_OUTPUT.PUT_LINE('Les identifiants sont corrects');
    ELSE
        DBMS_OUTPUT.PUT_LINE('Les identifiants sont incorrects');
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la vérification des identifiants : ' || SQLERRM);
END;
/

// Test : Supprimer_Utilisateur
BEGIN
    -- Test de suppression d'un utilisateur
    Gestion_Utilisateurs.Supprimer_Utilisateur(p_id_utilisateur => 21);
    DBMS_OUTPUT.PUT_LINE('Utilisateur supprimé avec succès');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression de l''utilisateur : ' || SQLERRM);
END;
/

// Test : Obtenir_Utilisateur

DECLARE
    v_utilisateur SYS_REFCURSOR;
    v_role UTILISATEUR.ROLE_UTILISATEUR%TYPE;
    v_mot_de_passe UTILISATEUR.MOT_DE_PASSE%TYPE;
BEGIN
    -- Test pour obtenir les informations d'un utilisateur
    v_utilisateur := Gestion_Utilisateurs.Obtenir_Utilisateur(p_id_utilisateur => 21);

    LOOP
        FETCH v_utilisateur INTO v_role, v_mot_de_passe;
        EXIT WHEN v_utilisateur%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('Rôle: ' || v_role || ', Mot de passe: ' || v_mot_de_passe);
    END LOOP;

    -- Fermeture du curseur
    CLOSE v_utilisateur;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération des informations de l''utilisateur : ' || SQLERRM);
END;
/

// Table PEUT_ETRE_RESERVE
CREATE OR REPLACE PACKAGE Gestion_Reservations_Chambres AS
    PROCEDURE Ajouter_Reservation_Chambre(
        p_id_reservation NUMBER,
        p_id_chambre NUMBER
    );

    PROCEDURE Supprimer_Reservation_Chambre(
        p_id_reservation NUMBER,
        p_id_chambre NUMBER
    );

    FUNCTION Obtenir_Reservation_Chambre(
        p_id_reservation NUMBER
    ) RETURN SYS_REFCURSOR;
END Gestion_Reservations_Chambres;
/

// Package body 

CREATE OR REPLACE PACKAGE BODY Gestion_Reservations_Chambres AS
    PROCEDURE Ajouter_Reservation_Chambre(
        p_id_reservation NUMBER,
        p_id_chambre NUMBER
    ) IS
    BEGIN
        INSERT INTO PEUT_ETRE_RESERVE (ID_RESERVATION, ID_CHAMBRE)
        VALUES (p_id_reservation, p_id_chambre);
        COMMIT;
    END Ajouter_Reservation_Chambre;

    PROCEDURE Supprimer_Reservation_Chambre(
        p_id_reservation NUMBER,
        p_id_chambre NUMBER
    ) IS
    BEGIN
        DELETE FROM PEUT_ETRE_RESERVE
        WHERE ID_RESERVATION = p_id_reservation AND ID_CHAMBRE = p_id_chambre;
        COMMIT;
    END Supprimer_Reservation_Chambre;

    FUNCTION Obtenir_Reservation_Chambre(
        p_id_reservation NUMBER
    ) RETURN SYS_REFCURSOR IS
        l_cursor SYS_REFCURSOR;
    BEGIN
        OPEN l_cursor FOR 
            SELECT * FROM PEUT_ETRE_RESERVE
            WHERE ID_RESERVATION = p_id_reservation;
        RETURN l_cursor;
    END Obtenir_Reservation_Chambre;
END Gestion_Reservations_Chambres;
/
// Test : Ajouter_Reservation_Chambre
BEGIN
    -- Ajoute la relation entre une réservation et une chambre
    Gestion_Reservations_Chambres.Ajouter_Reservation_Chambre(
        p_id_reservation => 16, 
        p_id_chambre => 13
    );
    DBMS_OUTPUT.PUT_LINE('Relation entre la réservation et la chambre ajoutée avec succès.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de l''ajout de la relation : ' || SQLERRM);
END;
/

// Test : Supprimer_Reservation_Chambre
BEGIN
    -- Supprime la relation entre une réservation et une chambre
    Gestion_Reservations_Chambres.Supprimer_Reservation_Chambre(
        p_id_reservation => 16, 
        p_id_chambre => 13
    );
    DBMS_OUTPUT.PUT_LINE('Relation entre la réservation et la chambre supprimée avec succès.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la suppression de la relation : ' || SQLERRM);
END;
/

// Test : Obtenir_Reservation_Chambre
DECLARE
    v_reservation_chambre SYS_REFCURSOR;
    v_id_reservation PEUT_ETRE_RESERVE.ID_RESERVATION%TYPE;
    v_id_chambre PEUT_ETRE_RESERVE.ID_CHAMBRE%TYPE;
BEGIN
    -- Appel de la fonction pour obtenir les chambres associées à une réservation
    v_reservation_chambre := Gestion_Reservations_Chambres.Obtenir_Reservation_Chambre(p_id_reservation => 7);

    
    LOOP
        FETCH v_reservation_chambre INTO v_id_reservation, v_id_chambre;
        EXIT WHEN v_reservation_chambre%NOTFOUND;
        DBMS_OUTPUT.PUT_LINE('ID Réservation: ' || v_id_reservation || ', ID Chambre: ' || v_id_chambre);
    END LOOP;

    -- Fermeture du curseur
    CLOSE v_reservation_chambre;
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Erreur lors de la récupération des données : ' || SQLERRM);
END;
/


// Triggers

CREATE OR REPLACE TRIGGER Verif_Etat_Chambre
BEFORE INSERT ON RESERVATION
FOR EACH ROW
DECLARE
    v_nettoyage NUMBER;
    v_maintenance NUMBER;
    v_disponible NUMBER;
BEGIN
    SELECT EN_NETTOYAGE, BESOIN_MAINTENANCE, DISPONIBLE INTO v_nettoyage, v_maintenance, v_disponible
    FROM CHAMBRE
    WHERE ID_CHAMBRE = :NEW.ID_CHAMBRE;

    IF v_disponible = 0 THEN
        RAISE_APPLICATION_ERROR(-20004, 'La chambre n''est pas disponible pour réservation.');
    ELSIF v_nettoyage = 1 THEN
        RAISE_APPLICATION_ERROR(-20002, 'La chambre est actuellement en nettoyage.');
    ELSIF v_maintenance = 1 THEN
        RAISE_APPLICATION_ERROR(-20003, 'La chambre a besoin de maintenance.');
    END IF;
END;
/


// Triggers

CREATE OR REPLACE TRIGGER MAJ_Etat_Chambre
AFTER UPDATE OF EN_NETTOYAGE, BESOIN_MAINTENANCE ON CHAMBRE
FOR EACH ROW
BEGIN
    IF :NEW.EN_NETTOYAGE = 0 AND :NEW.BESOIN_MAINTENANCE = 0 THEN
        UPDATE CHAMBRE
        SET DISPONIBLE = 1
        WHERE ID_CHAMBRE = :NEW.ID_CHAMBRE;
    ELSE
        UPDATE CHAMBRE
        SET DISPONIBLE = 0
        WHERE ID_CHAMBRE = :NEW.ID_CHAMBRE;
    END IF;
END;
/
