# Instructions pour corriger l'erreur de migration sur le serveur

## Option 1 : Marquer la migration comme exécutée (RECOMMANDÉ)

Puisque la colonne `ville` existe déjà dans la table, on peut simplement marquer la migration comme exécutée :

```bash
php artisan tinker
```

Puis dans tinker, exécutez :

```php
// Vérifier si la migration est déjà dans la table
$migration = DB::table('migrations')->where('migration', '2025_10_06_151927_add_ville_to_beneficiaires_table')->first();

if (!$migration) {
    // Si elle n'est pas dans la table, l'ajouter
    $maxBatch = DB::table('migrations')->max('batch') ?? 0;
    DB::table('migrations')->insert([
        'migration' => '2025_10_06_151927_add_ville_to_beneficiaires_table',
        'batch' => $maxBatch + 1
    ]);
    echo "Migration marquée comme exécutée\n";
} else {
    echo "Migration déjà dans la table\n";
}
exit
```

Ensuite, faites un `git pull` pour récupérer la version corrigée :

```bash
git pull origin main
```

Puis relancez les migrations :

```bash
php artisan migrate --force
```

## Option 2 : Récupérer la correction et relancer

```bash
# 1. Récupérer la dernière version
git pull origin main

# 2. Vérifier que le fichier est bien mis à jour
cat database/migrations/2025_10_06_151927_add_ville_to_beneficiaires_table.php

# 3. Si la migration est dans la table migrations mais a échoué, la supprimer
php artisan tinker
```

Dans tinker :

```php
// Supprimer la migration de la table si elle y est
DB::table('migrations')->where('migration', '2025_10_06_151927_add_ville_to_beneficiaires_table')->delete();
echo "Migration supprimée de la table\n";
exit
```

Puis relancer :

```bash
php artisan migrate --force
```

