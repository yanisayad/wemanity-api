# wemanity-api
Wemanity Project

## Prérequis

- PHP (v.7.1)
- MYSQL
- ElasticSearch (v.1.7) -> `localhost:9200`

## Installation

- Création des bases de données
```
CREATE DATABASE wemanity;
CREATE DATABASE test_wemanity;
```

- Importer le fichier .sql à la racine du projet
```
mysql wemanity < wemanity.sql
mysql test_wemanity < wemanity.sql
```

-Modifier le fichier `.env`

```
DATABASE_URL=mysql://[MYSQL_USERNAME]:[MYSQL_PASSWORD]@127.0.0.1:3306/wemanity
```

-Modifier le fichier `.env.test`

```
DATABASE_URL=mysql://[MYSQL_USERNAME]:[MYSQL_PASSWORD]@127.0.0.1:3306/test_wemanity

```

## Initialisation du projet

- Installation des dépendances
```
composer install
```

- Création des index et indexation des données (Après installation d'ElasticSearch)
```
composer create-index
composer index
```

## Lancement

- Attention à bien respecter le port
```
php -S localhost:7979 public/index.php
```

## Tests

- Lancement des tests sans Elasticsearch
```
composer test
```

- Lancement des tests avec Elasticsearch
```
composer test-es
```
