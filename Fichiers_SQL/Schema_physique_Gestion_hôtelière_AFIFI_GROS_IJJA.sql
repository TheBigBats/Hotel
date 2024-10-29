/*==============================================================*/
/* Nom de SGBD :  ORACLE Version 11g                            */
/* Date de cr�ation :  23/10/2024 02:18:30                      */
/*==============================================================*/


alter table PAIEMENT
   drop constraint FK_PAIEMENT_PEUT_EFFE_CLIENT;

alter table PAIEMENT
   drop constraint FK_PAIEMENT_PEUT_ETRE_FACTURE;

alter table PEUT_ETRE_RESERVE
   drop constraint FK_PEUT_ETR_PEUT_ETRE_CHAMBRE;

alter table PEUT_ETRE_RESERVE
   drop constraint FK_PEUT_ETR_PEUT_ETRE_RESERVAT;

alter table RESERVATION
   drop constraint FK_RESERVAT_PEUT_AVOI_CLIENT;

alter table FACTURE
   add ID_RESERVATION NUMBER(9) not null;

drop table CHAMBRE cascade constraints;

drop table CLIENT cascade constraints;

drop table FACTURE cascade constraints;

drop index PEUT_EFFECTUE_FK;

drop index PEUT_ETRE_PAYEE_FK;

drop table PAIEMENT cascade constraints;

drop index PEUT_ETRE_RESERVE2_FK;

drop index PEUT_ETRE_RESERVE_FK;

drop table PEUT_ETRE_RESERVE cascade constraints;

drop index PEUT_AVOIR_FK;

drop table RESERVATION cascade constraints;

drop table UTILISATEUR cascade constraints;

/*==============================================================*/
/* Table : CHAMBRE                                              */
/*==============================================================*/
create table CHAMBRE 
(
   ID_CHAMBRE           NUMBER(9)            not null
      constraint CKC_ID_CHAMBRE_CHAMBRE check (ID_CHAMBRE between 0.01 and 1000000),
   NUMERO_CHAMBRE       NUMBER(9)            not null
      constraint CKC_NUMERO_CHAMBRE_CHAMBRE check (NUMERO_CHAMBRE between 0.01 and 1000000),
   CATEGORIE            VARCHAR2(50)         not null
      constraint CKC_CATEGORIE_CHAMBRE check (CATEGORIE in ('Standard','Deluxe','Suite','Lit Double')),
   TARIF                NUMBER(10,2)         not null
      constraint CKC_TARIF_CHAMBRE check (TARIF >= 0),
   DISPONIBLE           SMALLINT             not null,
   EN_NETTOYAGE         SMALLINT             not null,
   BESOIN_MAINTENANCE   SMALLINT             not null,
   constraint PK_CHAMBRE primary key (ID_CHAMBRE)
);

/*==============================================================*/
/* Table : CLIENT                                               */
/*==============================================================*/
create table CLIENT 
(
   ID_CLIENT            NUMBER(9)            not null
      constraint CKC_ID_CLIENT_CLIENT check (ID_CLIENT between 0.01 and 1000000),
   NOM                  VARCHAR2(50)         not null
      constraint CKC_NOM_CLIENT check (NOM = upper(NOM)),
   PRENOM               VARCHAR2(50)         not null
      constraint CKC_PRENOM_CLIENT check (PRENOM = INITCAP(PRENOM)),
   CIVILITE             VARCHAR2(10)         not null
      constraint CKC_CIVILITE_CLIENT check (CIVILITE = INITCAP(CIVILITE)),
   POSTE                VARCHAR2(50)        
      constraint CKC_POSTE_CLIENT check (POSTE IS NULL OR LENGTH(POSTE) <= 50),
   MOBILE               VARCHAR2(15)         not null
      constraint CKC_MOBILE_CLIENT CHECK (LENGTH(MOBILE) between 10 and 15),
   ADRESSE              VARCHAR2(225)        not null
      constraint CKC_ADRESSE_CLIENT check (LENGTH(ADRESSE) <= 225),
   EMAIL                VARCHAR2(100)        not null
      constraint CKC_EMAIL_CLIENT check (LENGTH(EMAIL) between 5 and 100),
   VILLE                VARCHAR2(100)        not null
      constraint CKC_VILLE_CLIENT check (VILLE = INITCAP(VILLE)),
   CODE_POSTAL          VARCHAR2(10)         not null
      constraint CKC_CODE_POSTAL_CLIENT CHECK (LENGTH(CODE_POSTAL) between 4 and 10),
   PAYS                 VARCHAR2(100)        not null
      constraint CKC_PAYS_CLIENT check (PAYS = INITCAP(PAYS)),
   constraint PK_CLIENT primary key (ID_CLIENT)
);

/*==============================================================*/
/* Table : FACTURE                                              */
/*==============================================================*/
create table FACTURE 
(
   ID_FACTURE           NUMBER(9)            not null
      constraint CKC_ID_FACTURE_FACTURE check (ID_FACTURE between 0.01 and 1000000),
   MONTANT_TOTAL_FACTURE NUMBER(10,2)         not null
      constraint CKC_MONTANT_TOTAL_FAC_FACTURE check (MONTANT_TOTAL_FACTURE >= 0),
   DATE_FACTURE         DATE                 not null,
   ID_RESERVATION       NUMBER(9)            not null,
   constraint PK_FACTURE primary key (ID_FACTURE)
);

/*==============================================================*/
/* Table : PAIEMENT                                             */
/*==============================================================*/
create table PAIEMENT 
(
   ID_PAIEMENT          NUMBER(9)            not null
      constraint CKC_ID_PAIEMENT_PAIEMENT check (ID_PAIEMENT between 0.01 and 1000000),
   ID_FACTURE           NUMBER(9)            not null
      constraint CKC_ID_FACTURE_PAIEMENT check (ID_FACTURE between 0.01 and 1000000),
   ID_CLIENT            NUMBER(9)            not null
      constraint CKC_ID_CLIENT_PAIEMENT check (ID_CLIENT between 0.01 and 1000000),
   MONTANT_PAIEMENT     NUMBER(10,2)         not null
      constraint CKC_MONTANT_PAIEMENT_PAIEMENT check (MONTANT_PAIEMENT >= 0),
   DATE_PAIEMENT        DATE                 not null,
   constraint PK_PAIEMENT primary key (ID_PAIEMENT)
);

/*==============================================================*/
/* Index : PEUT_ETRE_PAYEE_FK                                   */
/*==============================================================*/
create index PEUT_ETRE_PAYEE_FK on PAIEMENT (
   ID_FACTURE ASC
);

/*==============================================================*/
/* Index : PEUT_EFFECTUE_FK                                     */
/*==============================================================*/
create index PEUT_EFFECTUE_FK on PAIEMENT (
   ID_CLIENT ASC
);

/*==============================================================*/
/* Table : PEUT_ETRE_RESERVE                                    */
/*==============================================================*/
create table PEUT_ETRE_RESERVE 
(
   ID_CHAMBRE           NUMBER(9)            not null
      constraint CKC_ID_CHAMBRE_PEUT_ETR check (ID_CHAMBRE between 0.01 and 1000000),
   ID_RESERVATION       NUMBER(9)            not null
      constraint CKC_ID_RESERVATION_PEUT_ETR check (ID_RESERVATION between 0.01 and 1000000),
   constraint PK_PEUT_ETRE_RESERVE primary key (ID_CHAMBRE, ID_RESERVATION)
);

/*==============================================================*/
/* Index : PEUT_ETRE_RESERVE_FK                                 */
/*==============================================================*/
create index PEUT_ETRE_RESERVE_FK on PEUT_ETRE_RESERVE (
   ID_CHAMBRE ASC
);

/*==============================================================*/
/* Index : PEUT_ETRE_RESERVE2_FK                                */
/*==============================================================*/
create index PEUT_ETRE_RESERVE2_FK on PEUT_ETRE_RESERVE (
   ID_RESERVATION ASC
);

/*==============================================================*/
/* Table : RESERVATION                                          */
/*==============================================================*/
create table RESERVATION 
(
   ID_RESERVATION       NUMBER(9)            not null
      constraint CKC_ID_RESERVATION_RESERVAT check (ID_RESERVATION between 0.01 and 1000000),
   ID_CLIENT            NUMBER(9)            not null
      constraint CKC_ID_CLIENT_RESERVAT check (ID_CLIENT between 0.01 and 1000000),
   ID_CHAMBRE           NUMBER(9)            not null,  -- Ajout de la colonne ici
   DATE_DEBUT           DATE                 not null,
   DATE_FIN             DATE                 not null,
   constraint PK_RESERVATION primary key (ID_RESERVATION),
   constraint FK_RESERVATION_CHAMBRE foreign key (ID_CHAMBRE) references CHAMBRE(ID_CHAMBRE)
);


/*==============================================================*/
/* Index : PEUT_AVOIR_FK                                        */
/*==============================================================*/
create index PEUT_AVOIR_FK on RESERVATION (
   ID_CLIENT ASC
);

/*==============================================================*/
/* Table : UTILISATEUR                                          */
/*==============================================================*/
CREATE TABLE UTILISATEUR 
(
   ID_UTILISATEUR       NUMBER(9)            NOT NULL
      CONSTRAINT CKC_ID_UTILISATEUR_UTILISAT CHECK (ID_UTILISATEUR BETWEEN 0.01 AND 1000000),
   ROLE_UTILISATEUR     VARCHAR2(20)         NOT NULL
      CONSTRAINT CKC_ROLE_UTILISATEUR_UTILISAT CHECK (ROLE_UTILISATEUR IN ('Admin','Receptionniste','Gestionnaire')),
   MOT_DE_PASSE         VARCHAR2(100)        NOT NULL
      CONSTRAINT CKC_MOT_DE_PASSE_UTILISAT CHECK (LENGTH(MOT_DE_PASSE) >= 8),
   CONSTRAINT PK_UTILISATEUR PRIMARY KEY (ID_UTILISATEUR)
);


alter table PAIEMENT
   add constraint FK_PAIEMENT_PEUT_EFFE_CLIENT foreign key (ID_CLIENT)
      references CLIENT (ID_CLIENT);

alter table PAIEMENT
   add constraint FK_PAIEMENT_PEUT_ETRE_FACTURE foreign key (ID_FACTURE)
      references FACTURE (ID_FACTURE);

alter table PEUT_ETRE_RESERVE
   add constraint FK_PEUT_ETR_PEUT_ETRE_CHAMBRE foreign key (ID_CHAMBRE)
      references CHAMBRE (ID_CHAMBRE);

alter table PEUT_ETRE_RESERVE
   add constraint FK_PEUT_ETR_PEUT_ETRE_RESERVAT foreign key (ID_RESERVATION)
      references RESERVATION (ID_RESERVATION);

alter table RESERVATION
   add constraint FK_RESERVAT_PEUT_AVOI_CLIENT foreign key (ID_CLIENT)
      references CLIENT (ID_CLIENT);

alter table FACTURE
   add constraint FK_FACTURE_RESERVATION foreign key (ID_RESERVATION)
   references RESERVATION (ID_RESERVATION);