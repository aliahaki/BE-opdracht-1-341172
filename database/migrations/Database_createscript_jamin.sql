-- ==================================================================================
-- BE-OPDRACHT 2 - JAMIN
-- DATABASE CREATE SCRIPT
-- ==================================================================================

-- Foreign keys tijdelijk uitschakelen zodat bestaande tabellen verwijderd kunnen worden
SET FOREIGN_KEY_CHECKS = 0;

-- ==================================================================================
-- BESTAANDE STORED PROCEDURES VERWIJDEREN
-- ==================================================================================

DROP PROCEDURE IF EXISTS sp_OverzichtLeveranciers;
DROP PROCEDURE IF EXISTS sp_LeverancierDetails;
DROP PROCEDURE IF EXISTS sp_GeleverdeProducten;
DROP PROCEDURE IF EXISTS sp_ProductLeveringDetails;
DROP PROCEDURE IF EXISTS sp_NieuweLeveringToevoegen;

-- ==================================================================================
-- BESTAANDE TABELLEN VERWIJDEREN
-- ==================================================================================

DROP TABLE IF EXISTS ProductPerAllergeen;
DROP TABLE IF EXISTS ProductPerLeverancier;
DROP TABLE IF EXISTS Magazijn;
DROP TABLE IF EXISTS Allergeen;
DROP TABLE IF EXISTS Leverancier;
DROP TABLE IF EXISTS Product;

SET FOREIGN_KEY_CHECKS = 1;


-- ==================================================================================
-- STEP 01
-- TABEL PRODUCT
-- ==================================================================================

CREATE TABLE Product
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Naam                VARCHAR(100) NOT NULL,
    Barcode             VARCHAR(13) NOT NULL,

    IsActief            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
                        ON UPDATE CURRENT_TIMESTAMP(6),

    CONSTRAINT PK_Product_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;


-- ==================================================================================
-- STEP 02
-- TABEL ALLERGEEN
-- ==================================================================================

CREATE TABLE Allergeen
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Naam                VARCHAR(50) NOT NULL,
    Omschrijving        VARCHAR(255) NOT NULL,

    IsActief            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
                        ON UPDATE CURRENT_TIMESTAMP(6),

    CONSTRAINT PK_Allergeen_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;


-- ==================================================================================
-- STEP 03
-- TABEL LEVERANCIER
-- ==================================================================================

CREATE TABLE Leverancier
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Naam                VARCHAR(100) NOT NULL,
    ContactPersoon      VARCHAR(100) NOT NULL,
    LeverancierNummer   VARCHAR(20) NOT NULL,
    Mobiel              VARCHAR(15) NOT NULL,

    IsActief            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
                        ON UPDATE CURRENT_TIMESTAMP(6),

    CONSTRAINT PK_Leverancier_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;


-- ==================================================================================
-- STEP 04
-- TABEL MAGAZIJN
-- ==================================================================================

CREATE TABLE Magazijn
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ProductId           INT UNSIGNED NOT NULL,
    VerpakkingsEenheid  DECIMAL(5,2) NOT NULL,
    AantalAanwezig      INT UNSIGNED NULL DEFAULT NULL,

    IsActief            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
                        ON UPDATE CURRENT_TIMESTAMP(6),

    CONSTRAINT PK_Magazijn_Id PRIMARY KEY (Id),

    CONSTRAINT FK_Magazijn_ProductId_Product_Id
        FOREIGN KEY (ProductId)
        REFERENCES Product(Id)
        ON DELETE CASCADE
) ENGINE=InnoDB;


-- ==================================================================================
-- STEP 05
-- TABEL PRODUCTPERALLERGEEN
-- ==================================================================================

CREATE TABLE ProductPerAllergeen
(
    Id                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
    ProductId           INT UNSIGNED NOT NULL,
    AllergeenId         INT UNSIGNED NOT NULL,

    IsActief            BIT NOT NULL DEFAULT 1,
    Opmerking           VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt     DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd      DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
                        ON UPDATE CURRENT_TIMESTAMP(6),

    CONSTRAINT PK_ProductPerAllergeen_Id PRIMARY KEY (Id),

    CONSTRAINT FK_ProductPerAllergeen_ProductId_Product_Id
        FOREIGN KEY (ProductId)
        REFERENCES Product(Id)
        ON DELETE CASCADE,

    CONSTRAINT FK_ProductPerAllergeen_AllergeenId_Allergeen_Id
        FOREIGN KEY (AllergeenId)
        REFERENCES Allergeen(Id)
        ON DELETE CASCADE
) ENGINE=InnoDB;


-- ==================================================================================
-- STEP 06
-- TABEL PRODUCTPERLEVERANCIER
-- ==================================================================================

CREATE TABLE ProductPerLeverancier
(
    Id                              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    LeverancierId                   INT UNSIGNED NOT NULL,
    ProductId                       INT UNSIGNED NOT NULL,
    DatumLevering                   DATE NOT NULL,
    Aantal                          INT UNSIGNED NOT NULL,
    DatumEerstVolgendeLevering      DATE NULL DEFAULT NULL,

    IsActief                        BIT NOT NULL DEFAULT 1,
    Opmerking                       VARCHAR(255) NULL DEFAULT NULL,
    DatumAangemaakt                 DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    DatumGewijzigd                  DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
                                    ON UPDATE CURRENT_TIMESTAMP(6),

    CONSTRAINT PK_ProductPerLeverancier_Id PRIMARY KEY (Id),

    CONSTRAINT FK_ProductPerLeverancier_LeverancierId_Leverancier_Id
        FOREIGN KEY (LeverancierId)
        REFERENCES Leverancier(Id)
        ON DELETE CASCADE,

    CONSTRAINT FK_ProductPerLeverancier_ProductId_Product_Id
        FOREIGN KEY (ProductId)
        REFERENCES Product(Id)
        ON DELETE CASCADE
) ENGINE=InnoDB;


-- ==================================================================================
-- DATA PRODUCT
-- Winegums heeft IsActief = 0 voor het unhappy scenario van User Story 2
-- ==================================================================================

INSERT INTO Product
(
    Id,
    Naam,
    Barcode,
    IsActief,
    Opmerking
)
VALUES
(1, 'Mintnopjes', '8719587231278', 1, NULL),
(2, 'Schoolkrijt', '8719587326713', 1, NULL),
(3, 'Honingdrop', '8719587327836', 1, NULL),
(4, 'Zure Beren', '8719587321441', 1, NULL),
(5, 'Cola Flesjes', '8719587321237', 1, NULL),
(6, 'Turtles', '8719587322245', 1, NULL),
(7, 'Witte Muizen', '8719587328256', 1, NULL),
(8, 'Reuzen Slangen', '8719587325641', 1, NULL),
(9, 'Zoute Rijen', '8719587322739', 1, NULL),
(10, 'Winegums', '8719587327527', 0, NULL),
(11, 'Drop Munten', '8719587322345', 1, NULL),
(12, 'Kruis Drop', '8719587322265', 1, NULL),
(13, 'Zoute Ruitjes', '8719587323256', 1, NULL);


-- ==================================================================================
-- DATA ALLERGEEN
-- ==================================================================================

INSERT INTO Allergeen
(
    Id,
    Naam,
    Omschrijving,
    IsActief,
    Opmerking
)
VALUES
(1, 'Gluten', 'Dit product bevat gluten', 1, NULL),
(2, 'Gelatine', 'Dit product bevat gelatine', 1, NULL),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen', 1, NULL),
(4, 'Lactose', 'Dit product bevat lactose', 1, NULL),
(5, 'Soja', 'Dit product bevat soja', 1, NULL);


-- ==================================================================================
-- DATA LEVERANCIER
-- Quality Street is nieuw voor opdracht 2
-- ==================================================================================

INSERT INTO Leverancier
(
    Id,
    Naam,
    ContactPersoon,
    LeverancierNummer,
    Mobiel,
    IsActief,
    Opmerking
)
VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1, NULL),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 1, NULL),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 1, NULL),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 1, NULL),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 1, NULL),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 1, NULL);


-- ==================================================================================
-- DATA MAGAZIJN
-- ==================================================================================

INSERT INTO Magazijn
(
    Id,
    ProductId,
    VerpakkingsEenheid,
    AantalAanwezig,
    IsActief,
    Opmerking
)
VALUES
(1, 1, 5, 453, 1, NULL),
(2, 2, 2.5, 400, 1, NULL),
(3, 3, 5, 1, 1, NULL),
(4, 4, 1, 800, 1, NULL),
(5, 5, 3, 234, 1, NULL),
(6, 6, 2, 345, 1, NULL),
(7, 7, 1, 795, 1, NULL),
(8, 8, 10, 233, 1, NULL),
(9, 9, 2.5, 123, 1, NULL),
(10, 10, 3, NULL, 1, NULL),
(11, 11, 2, 367, 1, NULL),
(12, 12, 1, 467, 1, NULL),
(13, 13, 5, 20, 1, NULL);


-- ==================================================================================
-- DATA PRODUCT PER ALLERGEEN
-- ==================================================================================

INSERT INTO ProductPerAllergeen
(
    Id,
    ProductId,
    AllergeenId,
    IsActief,
    Opmerking
)
VALUES
(1, 1, 2, 1, NULL),
(2, 1, 1, 1, NULL),
(3, 1, 3, 1, NULL),
(4, 3, 4, 1, NULL),
(5, 6, 5, 1, NULL),
(6, 9, 2, 1, NULL),
(7, 9, 5, 1, NULL),
(8, 10, 2, 1, NULL),
(9, 12, 4, 1, NULL),
(10, 13, 1, 1, NULL),
(11, 13, 4, 1, NULL),
(12, 13, 5, 1, NULL);


-- ==================================================================================
-- DATA PRODUCT PER LEVERANCIER
-- Data volgens opdracht 2
-- Quality Street heeft bewust geen producten geleverd
-- ==================================================================================

INSERT INTO ProductPerLeverancier
(
    Id,
    LeverancierId,
    ProductId,
    DatumLevering,
    Aantal,
    DatumEerstVolgendeLevering,
    IsActief,
    Opmerking
)
VALUES
(1, 1, 1, '2024-11-09', 23, '2024-11-16', 1, NULL),
(2, 1, 1, '2024-11-18', 21, '2024-11-25', 1, NULL),
(3, 1, 2, '2024-11-09', 12, '2024-11-16', 1, NULL),
(4, 1, 3, '2024-11-10', 11, '2024-11-17', 1, NULL),
(5, 2, 4, '2024-11-14', 16, '2024-11-21', 1, NULL),
(6, 2, 4, '2024-11-21', 23, '2024-11-28', 1, NULL),
(7, 2, 5, '2024-11-14', 45, '2024-11-21', 1, NULL),
(8, 2, 6, '2024-11-14', 30, '2024-11-21', 1, NULL),
(9, 3, 7, '2024-11-12', 12, '2024-11-19', 1, NULL),
(10, 3, 7, '2024-11-19', 23, '2024-11-26', 1, NULL),
(11, 3, 8, '2024-11-10', 12, '2024-11-17', 1, NULL),
(12, 3, 9, '2024-11-11', 1, '2024-11-18', 1, NULL),
(13, 4, 10, '2024-11-16', 24, '2024-11-30', 1, NULL),
(14, 5, 11, '2024-11-10', 47, '2024-11-17', 1, NULL),
(15, 5, 11, '2024-11-19', 60, '2024-11-26', 1, NULL),
(16, 5, 12, '2024-11-11', 45, NULL, 1, NULL),
(17, 5, 13, '2024-11-12', 23, NULL, 1, NULL);


-- ==================================================================================
-- STORED PROCEDURE 01
-- OVERZICHT LEVERANCIERS
-- Sorteert aantal verschillende producten aflopend
-- ==================================================================================

DELIMITER $$

CREATE PROCEDURE sp_OverzichtLeveranciers()
BEGIN
    SELECT
        l.Id AS LeverancierId,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel,
        COUNT(DISTINCT ppl.ProductId) AS AantalVerschillendeProducten
    FROM Leverancier AS l
    LEFT JOIN ProductPerLeverancier AS ppl
        ON l.Id = ppl.LeverancierId
        AND ppl.IsActief = 1
    WHERE l.IsActief = 1
    GROUP BY
        l.Id,
        l.Naam,
        l.ContactPersoon,
        l.LeverancierNummer,
        l.Mobiel
    ORDER BY
        AantalVerschillendeProducten DESC,
        l.Naam ASC;
END$$


-- ==================================================================================
-- STORED PROCEDURE 02
-- GEGEVENS VAN EEN LEVERANCIER
-- ==================================================================================

CREATE PROCEDURE sp_LeverancierDetails
(
    IN p_LeverancierId INT
)
BEGIN
    SELECT
        Id AS LeverancierId,
        Naam,
        ContactPersoon,
        LeverancierNummer,
        Mobiel
    FROM Leverancier
    WHERE Id = p_LeverancierId;
END$$


-- ==================================================================================
-- STORED PROCEDURE 03
-- GELEVERDE PRODUCTEN VAN EEN LEVERANCIER
-- Producten worden gesorteerd op aantal in magazijn aflopend
-- ==================================================================================

CREATE PROCEDURE sp_GeleverdeProducten
(
    IN p_LeverancierId INT
)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        m.AantalAanwezig,
        m.VerpakkingsEenheid,
        MAX(ppl.DatumLevering) AS LaatsteLevering,
        p.IsActief
    FROM ProductPerLeverancier AS ppl
    INNER JOIN Product AS p
        ON ppl.ProductId = p.Id
    INNER JOIN Magazijn AS m
        ON p.Id = m.ProductId
    WHERE ppl.LeverancierId = p_LeverancierId
      AND ppl.IsActief = 1
    GROUP BY
        p.Id,
        p.Naam,
        m.AantalAanwezig,
        m.VerpakkingsEenheid,
        p.IsActief
    ORDER BY
        COALESCE(m.AantalAanwezig, 0) DESC,
        p.Naam ASC;
END$$


-- ==================================================================================
-- STORED PROCEDURE 04
-- GEGEVENS VOOR SCHERM LEVERING PRODUCT
-- ==================================================================================

CREATE PROCEDURE sp_ProductLeveringDetails
(
    IN p_LeverancierId INT,
    IN p_ProductId INT
)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.IsActief AS ProductIsActief,

        l.Id AS LeverancierId,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.Mobiel

    FROM Product AS p
    INNER JOIN ProductPerLeverancier AS ppl
        ON p.Id = ppl.ProductId
    INNER JOIN Leverancier AS l
        ON ppl.LeverancierId = l.Id

    WHERE p.Id = p_ProductId
      AND l.Id = p_LeverancierId

    LIMIT 1;
END$$


-- ==================================================================================
-- STORED PROCEDURE 05
-- NIEUWE LEVERING TOEVOEGEN
-- ==================================================================================

CREATE PROCEDURE sp_NieuweLeveringToevoegen
(
    IN p_LeverancierId INT,
    IN p_ProductId INT,
    IN p_Aantal INT,
    IN p_DatumEerstVolgendeLevering DATE
)
BEGIN
    DECLARE v_IsActief BIT;
    DECLARE v_ProductNaam VARCHAR(100);
    DECLARE v_LeverancierNaam VARCHAR(100);

    SELECT
        IsActief,
        Naam
    INTO
        v_IsActief,
        v_ProductNaam
    FROM Product
    WHERE Id = p_ProductId;

    SELECT Naam
    INTO v_LeverancierNaam
    FROM Leverancier
    WHERE Id = p_LeverancierId;


    -- Product wordt niet meer gemaakt
    IF v_IsActief = 0 THEN

        SELECT
            0 AS Succes,
            CONCAT(
                'Het product ',
                v_ProductNaam,
                ' van de leverancier ',
                v_LeverancierNaam,
                ' wordt niet meer geproduceerd'
            ) AS Melding;

    ELSE

        START TRANSACTION;

        -- Voorraad verhogen
        UPDATE Magazijn
        SET
            AantalAanwezig = COALESCE(AantalAanwezig, 0) + p_Aantal,
            DatumGewijzigd = NOW(6)
        WHERE ProductId = p_ProductId;


        -- Nieuwe levering registreren
        INSERT INTO ProductPerLeverancier
        (
            LeverancierId,
            ProductId,
            DatumLevering,
            Aantal,
            DatumEerstVolgendeLevering,
            IsActief,
            Opmerking
        )
        VALUES
        (
            p_LeverancierId,
            p_ProductId,
            CURDATE(),
            p_Aantal,
            p_DatumEerstVolgendeLevering,
            1,
            NULL
        );

        COMMIT;

        SELECT
            1 AS Succes,
            'De levering is succesvol toegevoegd' AS Melding;

    END IF;
END$$

DELIMITER ;