<?php
declare(strict_types=1);

require_once __DIR__ . '/connector.php';

try {
    $idcon->beginTransaction();

    // Ensure one adherent test record exists.
    $checkAdherent = $idcon->prepare("SELECT IdA FROM Adherent WHERE NomA = ? AND PrenomA = ? LIMIT 1");
    $checkAdherent->execute(['Test', 'User']);
    $adherentId = $checkAdherent->fetchColumn();

    if (!$adherentId) {
        $insertAdherent = $idcon->prepare("INSERT INTO Adherent (NomA, PrenomA, Ville) VALUES (?, ?, ?)");
        $insertAdherent->execute(['Test', 'User', 'Biarritz']);
        $adherentId = (int) $idcon->lastInsertId();
    } else {
        $adherentId = (int) $adherentId;
    }

    // Ensure one moniteur test record exists.
    $checkMoniteur = $idcon->prepare("SELECT IdM FROM Moniteur WHERE NomM = ? AND PrenomM = ? LIMIT 1");
    $checkMoniteur->execute(['Demo', 'Coach']);
    $moniteurId = $checkMoniteur->fetchColumn();

    if (!$moniteurId) {
        $insertMoniteur = $idcon->prepare("INSERT INTO Moniteur (NomM, PrenomM) VALUES (?, ?)");
        $insertMoniteur->execute(['Demo', 'Coach']);
        $moniteurId = (int) $idcon->lastInsertId();
    } else {
        $moniteurId = (int) $moniteurId;
    }

    // Ensure one user account linked to adherent exists.
    $checkUser = $idcon->prepare("SELECT id FROM utilisateurs WHERE username = ? LIMIT 1");
    $checkUser->execute(['userdemo']);
    $userId = $checkUser->fetchColumn();

    if (!$userId) {
        $insertUser = $idcon->prepare(
            "INSERT INTO utilisateurs (username, password, role, adherent_id) VALUES (?, ?, 'user', ?)"
        );
        $insertUser->execute(['userdemo', 'user123', $adherentId]);
    } else {
        $updateUser = $idcon->prepare(
            "UPDATE utilisateurs SET password = ?, role = 'user', adherent_id = ? WHERE id = ?"
        );
        $updateUser->execute(['user123', $adherentId, $userId]);
    }

    // Upsert 1 future and 1 past seance for this adherent/moniteur.
    $futureDate = (new DateTimeImmutable('+3 days'))->format('Y-m-d');
    $pastDate = (new DateTimeImmutable('-3 days'))->format('Y-m-d');

    $upsertSeance = $idcon->prepare(
        "INSERT INTO Seance (IdM, IdA, DateS, HeureS, NbHeures)
         VALUES (?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE HeureS = VALUES(HeureS), NbHeures = VALUES(NbHeures)"
    );

    $upsertSeance->execute([$moniteurId, $adherentId, $futureDate, '10:00:00', 2]);
    $upsertSeance->execute([$moniteurId, $adherentId, $pastDate, '14:00:00', 1]);

    $idcon->commit();

    echo "Seed complete." . PHP_EOL;
    echo "User login: userdemo / user123" . PHP_EOL;
    echo "Linked adherent ID: " . $adherentId . PHP_EOL;
    echo "Moniteur ID: " . $moniteurId . PHP_EOL;
    echo "Seances created/updated on: " . $pastDate . " and " . $futureDate . PHP_EOL;
} catch (Throwable $e) {
    if ($idcon->inTransaction()) {
        $idcon->rollBack();
    }
    echo "Seed error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
