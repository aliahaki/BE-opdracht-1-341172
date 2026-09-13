# Database Specificatie Tabel - Jamin

## 1. Tabel: Product
| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van het product |
| Naam | VARCHAR(100) | Nee | | Naam van het snoep/product |
| Barcode | VARCHAR(13) | Nee | | Unieke streepjescode van het product |
| IsActief | BIT | Nee | | Systeemveld: Status van het record (1 = Actief) |
| Opmerking | VARCHAR(250) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging |

---

## 2. Tabel: Allergeen
| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van het allergeen |
| Naam | VARCHAR(100) | Nee | | Naam van het allergeen (bijv. Gluten, Lactose) |
| Omschrijving | VARCHAR(255) | Nee | | Beschrijving van het allergeen |
| IsActief | BIT | Nee | | Systeemveld: Status van het record |
| Opmerking | VARCHAR(250) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging |

---

## 3. Tabel: Leverancier
| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van de leverancier |
| Naam | VARCHAR(100) | Nee | | Bedrijfsnaam van de leverancier |
| ContactPersoon | VARCHAR(100) | Nee | | Naam van de contactpersoon |
| LeverancierNummer| VARCHAR(20) | Nee | | Uniek leveranciersnummer |
| Mobiel | VARCHAR(15) | Nee | | Telefoonnummer van de leverancier |
| IsActief | BIT | Nee | | Systeemveld: Status van het record |
| Opmerking | VARCHAR(250) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging |

---

## 4. Tabel: Magazijn
| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van het magazijnrecord |
| ProductId | INT UNSIGNED | Nee | FK | Verwijzing naar Product(Id) |
| VerpakkingsEenheid| DECIMAL(5,2)| Nee | | Verpakkingseenheid in kg |
| AantalAanwezig | INT | Ja | | Huidig aantal op voorraad |
| IsActief | BIT | Nee | | Systeemveld: Status van het record |
| Opmerking | VARCHAR(250) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging |

---

## 5. Tabel: ProductPerAllergeen
| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van de koppeling |
| ProductId | INT UNSIGNED | Nee | FK | Verwijzing naar Product(Id) |
| AllergeenId | INT UNSIGNED | Nee | FK | Verwijzing naar Allergeen(Id) |
| IsActief | BIT | Nee | | Systeemveld: Status van het record |
| Opmerking | VARCHAR(250) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging |

---

## 6. Tabel: ProductPerLeverancier
| Veldnaam | Datatype | Nullable | Sleutel | Omschrijving |
| :--- | :--- | :--- | :--- | :--- |
| Id | INT UNSIGNED | Nee | PK | Unieke identificatie van de levering |
| LeverancierId | INT UNSIGNED | Nee | FK | Verwijzing naar Leverancier(Id) |
| ProductId | INT UNSIGNED | Nee | FK | Verwijzing naar Product(Id) |
| DatumLevering | DATE | Nee | | Datum van de levering |
| Aantal | INT | Nee | | Aantal geleverde eenheden |
| DatumEerstVolgendeLevering | DATE | Ja | | Verwachte datum van volgende levering |
| IsActief | BIT | Nee | | Systeemveld: Status van het record |
| Opmerking | VARCHAR(250) | Ja | | Eventuele opmerkingen |
| DatumAangemaakt | DATETIME(6) | Nee | | Datum en tijdstip van aanmaken |
| DatumGewijzigd | DATETIME(6) | Nee | | Datum en tijdstip van laatste wijziging |