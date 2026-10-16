# Database Specificatie Tabel - Jamin

## 1. Tabel: Product

| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van het product |
| Naam | VARCHAR(100) | Nee | | Naam van het snoep/product |
| Barcode | VARCHAR(13) | Nee | | Unieke streepjescode van het product |
| IsActief | BIT | Nee | | Systeemveld: status van het record (1 = actief) |
| Opmerking | VARCHAR(255) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging, standaard NOW(6) |

---

## 2. Tabel: Allergeen

| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van het allergeen |
| Naam | VARCHAR(100) | Nee | | Naam van het allergeen, bijvoorbeeld Gluten of Lactose |
| Omschrijving | VARCHAR(255) | Nee | | Beschrijving van het allergeen |
| IsActief | BIT | Nee | | Systeemveld: status van het record |
| Opmerking | VARCHAR(255) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging, standaard NOW(6) |

---

## 3. Tabel: Leverancier

| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van de leverancier |
| Naam | VARCHAR(100) | Nee | | Bedrijfsnaam van de leverancier |
| ContactPersoon | VARCHAR(100) | Nee | | Naam van de contactpersoon |
| LeverancierNummer | VARCHAR(20) | Nee | | Uniek leveranciersnummer |
| Mobiel | VARCHAR(15) | Nee | | Telefoonnummer van de leverancier |
| IsActief | BIT | Nee | | Systeemveld: status van het record |
| Opmerking | VARCHAR(255) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging, standaard NOW(6) |

---

## 4. Tabel: Magazijn

| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van het magazijnrecord |
| ProductId | INT UNSIGNED | Nee | FK | Verwijzing naar Product(Id) |
| VerpakkingsEenheid | DECIMAL(5,2) | Nee | | Verpakkingseenheid in kilogram |
| AantalAanwezig | INT | Ja | | Huidig aantal producten in het magazijn |
| IsActief | BIT | Nee | | Systeemveld: status van het record |
| Opmerking | VARCHAR(255) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging, standaard NOW(6) |

---

## 5. Tabel: ProductPerAllergeen

| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van de koppeling |
| ProductId | INT UNSIGNED | Nee | FK | Verwijzing naar Product(Id) |
| AllergeenId | INT UNSIGNED | Nee | FK | Verwijzing naar Allergeen(Id) |
| IsActief | BIT | Nee | | Systeemveld: status van het record |
| Opmerking | VARCHAR(255) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging, standaard NOW(6) |

---

## 6. Tabel: ProductPerLeverancier

| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van de levering |
| LeverancierId | INT UNSIGNED | Nee | FK | Verwijzing naar Leverancier(Id) |
| ProductId | INT UNSIGNED | Nee | FK | Verwijzing naar Product(Id) |
| DatumLevering | DATE | Nee | | Datum waarop het product is geleverd |
| Aantal | INT | Nee | | Aantal geleverde producteenheden |
| DatumEerstVolgendeLevering | DATE | Ja | | Verwachte datum van de eerstvolgende levering |
| IsActief | BIT | Nee | | Systeemveld: status van het record |
| Opmerking | VARCHAR(255) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging, standaard NOW(6) |