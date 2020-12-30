![Continuous Integration](https://github.com/ESEO-Projects/ESEOProjects/workflows/PHP%20Integration/badge.svg?branch=master)

# Installation

Il faut commencer par cloner localement le dépôt : `git clone https://github.com/ESEOProjects/ESEOProjects.git && cd ESEOProjects`
Ensuite, avec Composer, il faut installer les dépendances : `composer install --dev`

Après s'être assuré que votre serveur MySQL local fonctionne, il faut éditer le fichier .env.local en modifiant la ligne DATABASE_URL avec vos données locales.
Ces données vous sont propres et ne doivent pas être push sur le dépôt.
Il faut à présent dire à Doctrine de créer la base de données et les tables SQL du projet:
`php bin/console doctrine:database:create && php bin/console doctrine:schema:create`

Si une erreur est survenue, faites-nous signe.

## Data Fixtures
Pour faciliter le développement, des fixtures ont été créées : elles permettent de créer des données de test rapidement (et les mêmes partout).
Pour les charger, il faut toujours utiliser la console Symfony fournie : `php bin/console doctrine:fixtures:load`

A présent tout est bon !

Le serveur peut être démarré avec la commande `symfony serve`.

## Exécution des tests
Symfony repose nativement sur PHPUnit. Nous allons donc utiliser cet outil, suffisant pour le travail demandé.
Pour exécuter les tests : `php bin/phpunit`. De cette manière tous les tests seront exécutés.
Plus d'informations dans la documentation Symfony : [Consulter la documentation](https://symfony.com/doc/current/testing.html)

# Architecture

L'application respecte l'architecture MVC. L'architecure des fichiers est la suivante:
```
/bin => Console Symfony et PHPUnit
/config => Dossier de configuration (fichiers au format YAML)
/migrations => Migrations Doctrine. A vérifier avant chaque migration !
/public => Dossier d'entrée de l'application. Y mettre toutes les ressources (JS, CSS, images ...)
/src =>
    /Controller => ControlLers de l'application.
    /Entity => Entités doctrine.
    /Form => Formulaires Symfony.
    /Repository => Accès aux données de la BDD.
    /Security => Comme son nom l'indique.
    /DataFixtures => Données factices de l'app pour le développement.
/templates => Templates Twig. Chaque sous-dossier correspond à un controller.
/tests => Contient les tests PHPUnit à exécuter.
```
