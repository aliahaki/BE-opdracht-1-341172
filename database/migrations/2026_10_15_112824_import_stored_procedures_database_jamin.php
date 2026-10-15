<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Oude procedures verwijderen
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_OverzichtLeveranciers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_LeverancierDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GeleverdeProducten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_ProductLeveringDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_NieuweLeveringToevoegen');


        // ============================================================
        // PROCEDURE 01 - OVERZICHT LEVERANCIERS
        // ============================================================

        DB::unprepared("
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
            END
        ");


        // ============================================================
        // PROCEDURE 02 - LEVERANCIER DETAILS
        // ============================================================

        DB::unprepared("
            CREATE PROCEDURE sp_LeverancierDetails(
                IN p_LeverancierId INT
            )
            BEGIN  
                -- Dit is een test
                SELECT
                    Id AS LeverancierId,
                    Naam,
                    ContactPersoon,
                    LeverancierNummer,
                    Mobiel
                FROM Leverancier
                WHERE Id = p_LeverancierId;
            END
        ");


        // ============================================================
        // PROCEDURE 03 - GELEVERDE PRODUCTEN
        // ============================================================

        DB::unprepared("
            CREATE PROCEDURE sp_GeleverdeProducten(
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
            END
        ");


        // ============================================================
        // PROCEDURE 04 - PRODUCT LEVERING DETAILS
        // ============================================================

        DB::unprepared("
            CREATE PROCEDURE sp_ProductLeveringDetails(
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
            END
        ");


        // ============================================================
        // PROCEDURE 05 - NIEUWE LEVERING TOEVOEGEN
        // ============================================================

        DB::unprepared("
            CREATE PROCEDURE sp_NieuweLeveringToevoegen(
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

                    UPDATE Magazijn
                    SET
                        AantalAanwezig = COALESCE(AantalAanwezig, 0) + p_Aantal,
                        DatumGewijzigd = NOW(6)
                    WHERE ProductId = p_ProductId;

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

                    SELECT
                        1 AS Succes,
                        'De levering is succesvol toegevoegd' AS Melding;

                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_OverzichtLeveranciers');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_LeverancierDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GeleverdeProducten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_ProductLeveringDetails');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_NieuweLeveringToevoegen');
    }
};