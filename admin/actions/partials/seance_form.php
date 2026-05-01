<form method="post" class="grid">
    <div>
        <label for="idm">Moniteur</label>
        <select id="idm" name="idm" required>
            <?php foreach ($moniteurs as $m): ?>
                <option value="<?php echo $m['IdM']; ?>" <?php if ((string) ($seanceFormData['idm'] ?? '') === (string) $m['IdM']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($m['NomM'] . ' ' . $m['PrenomM']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="ida">Adherent</label>
        <select id="ida" name="ida" required>
            <?php foreach ($adherents as $a): ?>
                <option value="<?php echo $a['IdA']; ?>" <?php if ((string) ($seanceFormData['ida'] ?? '') === (string) $a['IdA']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($a['NomA'] . ' ' . $a['PrenomA']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars((string) ($seanceFormData['date'] ?? '')); ?>" required>
    </div>
    <div>
        <label for="heure">Heure</label>
        <input type="time" id="heure" name="heure" value="<?php echo htmlspecialchars((string) ($seanceFormData['heure'] ?? '')); ?>" required>
    </div>
    <div>
        <label for="nbheures">Nombre d'heures</label>
        <input type="number" id="nbheures" name="nbheures" min="1" value="<?php echo (int) ($seanceFormData['nbheures'] ?? 1); ?>" required>
    </div>
    <div class="inline-actions">
        <input type="submit" value="<?php echo htmlspecialchars($submitLabel); ?>">
        <a href="/admin/manage_seances.php">Retour</a>
    </div>
</form>
