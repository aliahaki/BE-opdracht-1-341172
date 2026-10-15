<?php

namespace App\Repositories;

use PDO;

class LeverancierRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $config = config('database.connections.mysql');

        $dsn = 'mysql:host=' . $config['host']
            . ';port=' . $config['port']
            . ';dbname=' . $config['database']
            . ';charset=' . $config['charset'];

        $this->pdo = new PDO(
            $dsn,
            $config['username'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    // Alle leveranciers ophalen
    public function getLeveranciers(): array
    {
        $statement = $this->pdo->prepare(
            'CALL sp_OverzichtLeveranciers()'
        );

        $statement->execute();

        $leveranciers = $statement->fetchAll();

        $statement->closeCursor();

        return $leveranciers;
    }

    // Eén leverancier ophalen
    public function getLeverancier(int $leverancierId): ?object
    {
        $statement = $this->pdo->prepare(
            'CALL sp_LeverancierDetails(:leverancierId)'
        );

        $statement->bindValue(
            ':leverancierId',
            $leverancierId,
            PDO::PARAM_INT
        );

        $statement->execute();

        $leverancier = $statement->fetch();

        $statement->closeCursor();

        return $leverancier ?: null;
    }

    // Producten van één leverancier ophalen
    public function getGeleverdeProducten(int $leverancierId): array
    {
        $statement = $this->pdo->prepare(
            'CALL sp_GeleverdeProducten(:leverancierId)'
        );

        $statement->bindValue(
            ':leverancierId',
            $leverancierId,
            PDO::PARAM_INT
        );

        $statement->execute();

        $producten = $statement->fetchAll();

        $statement->closeCursor();

        return $producten;
    }
}
