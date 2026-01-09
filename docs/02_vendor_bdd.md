# Routine d'initialisation du projet

Ce document recense les commandes nécessaires pour initialiser le projet sur un nouvel environnement de développement (après un `git clone`), en supposant que **Docker** est utilisé.

## 1. Démarrer les conteneurs

```bash
docker compose up -d
```

## 2. Installer les dépendances PHP

```bash
docker compose exec php composer install
```

## 3. Initialiser la base de données

Ces commandes doivent être exécutées dans le conteneur `php`.

### Créer la base de données
Cette commande crée la base de données configurée dans le `.env` (ou `.env.local`) si elle n'existe pas déjà.

```bash
docker compose exec php bin/console doctrine:database:create
```

### Jouer les migrations
Cette commande crée les tables en exécutant les fichiers de migration présents dans le dossier `migrations`.

```bash
docker compose exec php bin/console doctrine:migrations:migrate
```
*Note : Répondez `yes` si on vous demande confirmation.*

### Charger les fixtures (Jeux de données de test)
Cette commande vide la base de données et la remplit avec les données factices définies dans `src/DataFixtures`. 
**À utiliser uniquement en dev/test car cela supprime les données existantes.**

```bash
docker compose exec php bin/console doctrine:fixtures:load
```
*Note : Répondez `yes` si on vous demande confirmation pour vider la base.*

## Résumé one-liner (pour les pressés)

Une fois les conteneurs lancés :

```bash
docker compose exec php composer install && \
docker compose exec php bin/console doctrine:database:create --if-not-exists && \
docker compose exec php bin/console doctrine:migrations:migrate --no-interaction && \
docker compose exec php bin/console doctrine:fixtures:load --no-interaction
```

## Troubleshooting (Problèmes courants via Docker sur Windows)

### Erreur `env: 'php\r': No such file or directory`

Si vous rencontrez cette erreur en lançant une commande `bin/console`, c'est que le fichier a des retours à la ligne Windows (CRLF) au lieu de Unix (LF). Le conteneur Linux ne peut pas interpréter le "shebang" correctement.

**Solution :** Convertir les fins de ligne du fichier `bin/console`.

```bash
docker compose exec php sed -i 's/\r$//' bin/console
```
