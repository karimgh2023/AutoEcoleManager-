<form method="post" class="grid">
    <div>
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars((string) ($adherentFormData['nom'] ?? '')); ?>" required>
    </div>
    <div>
        <label for="prenom">Prenom</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars((string) ($adherentFormData['prenom'] ?? '')); ?>" required>
    </div>
    <div>
        <label for="ville">Ville</label>
        <input type="text" id="ville" name="ville" value="<?php echo htmlspecialchars((string) ($adherentFormData['ville'] ?? '')); ?>" required>
    </div>
    <div class="inline-actions">
        <input type="submit" value="<?php echo htmlspecialchars($submitLabel); ?>">
        <a href="/admin/manage_adherents.php">Retour</a>
    </div>
</form>
