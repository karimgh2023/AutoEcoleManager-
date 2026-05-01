<form method="post" class="grid">
    <div>
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars((string) ($userFormData['username'] ?? '')); ?>" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" value="<?php echo htmlspecialchars((string) ($userFormData['password'] ?? '')); ?>" required>
    </div>
    <div>
        <label for="adherent_id">Adherent (optionnel)</label>
        <select id="adherent_id" name="adherent_id">
            <option value="">Aucun</option>
            <?php foreach ($adherents as $a): ?>
                <option value="<?php echo $a['IdA']; ?>" <?php if ((string) ($userFormData['adherent_id'] ?? '') === (string) $a['IdA']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($a['IdA'] . ' - ' . $a['NomA'] . ' ' . $a['PrenomA']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="role">Role</label>
        <select id="role" name="role">
            <option value="user" <?php if (($userFormData['role'] ?? 'user') === 'user') echo 'selected'; ?>>Utilisateur</option>
            <option value="admin" <?php if (($userFormData['role'] ?? 'user') === 'admin') echo 'selected'; ?>>Administrateur</option>
        </select>
    </div>
    <div class="inline-actions">
        <input type="submit" value="<?php echo htmlspecialchars($submitLabel); ?>">
        <a href="/admin/manage_users.php">Retour</a>
    </div>
</form>
