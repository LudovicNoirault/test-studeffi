# Test de recrutement Développeur Web

Contexte : Test post-entretien de recrutement pour l'entreprise Studeffi.

Sujet : réalisation d’une application CRUD (Create, Read, Update, Delete) permettant la gestion de compteurs d’énergie.

## Étapes de conceptions :

1. Installation et configuration du framework PHP Symfony 3.4 dans un serveur web local + Base de données MySql.
2. Mise en place d’un système de connexion via un login + mot de passe
3. Réalisation CRUD pour Compteurs d’énergie utilisant les champs fournis dans le cahier des charges.
4. Implémentation d’une fonction déterminant automatiquement le code Insee d’une ville en fonction du nom de celle-ci et de son code postal, cela en utilisant une API externe.

## Accéder au projet :

### Logiciel requis :

Votre machine doit posséder les logiciels suivants :

- Git ( Téléchargeable [ici](https://git-scm.com/downloads) )
- Wamp ( Téléchargeable [ici](http://www.wampserver.com/en/download-wampserver-64bits/) )
- Composer ( Téléchargeable [ici](https://getcomposer.org/download/) )

### Étapes à exécuter :

- Ouvrir un terminal à l'endroit où l'on souhaite travailler
- Cloner le projet depuis git via la commande suivante
- si machine paramétrée avec shh
  ```cmd
  git clone git@github.com:LudovicNoirault/test-studeffi.git
  ```
- sinon
  ```cmd
  git clone https://github.com/LudovicNoirault/test-studeffi.git
  ```

- Ce déplacé jusqu’à la racine du projet
  ```cmd
  cd test-studeffi
  ```
- Lancer la commande suivante pour initialiser le projet
  ```cmd
  composer install
  ```

- Le terminal va vous demander d'entrer des informations suivantes, les paramètres sont à modifier en fonctions de votre système:
- database_host : 127.0.0.1
- database_port : 3306
- database_name : test-studeffi
- database_user : {{ votre utilisateur mysql }}
- database_password : {{ votre mot de passe mysql }}
- mailer_transport : smtp
- mailer_user : notImplemented
- mailer_password : notImplented
- secret : {{ Clé secrete a votre convenance, niveau de sécurisation non démandé dans le cahier des charges }}

- Lancer la création de la base de donner via la commande
  ```cmd
  php bin/console doctrine:database:create
  ```

- Effectuer la mise à jour du schéma de base de données en tappant :
  ```cmd
  php bin/console doctrine:schema:update --force
  ```

- Puis enfin lancer le serveur de l'application et rendez vous a l'adresse indiquer (localhost:8000 de base)
  ```cmd
  php bin/console server:run
  ```

## Fonctionnalitées

Un utilisateur se connectant sur la plateforme ne pourra accéder qu'aux pages suivantes si celui-ci n'est pas connecté :

- localhost:8000
- localhost:8000/login
- localhost:8000/register

En arrivant sur la page d'accueil, l'utilisateur est prié créer un compte après avoir cliqué sur le bouton connexion situé dans le header de la page ou bien sur le bouton central de cette page.

Une fois le compte créé sur la page /register, un message de confirmation est afficher puis l'utilisateur est autoriser à naviguer sur le reste du site grâce aux boutons "ajouter un compteur" ou bien "liste des compteurs".

Lorsque l'utilisateur souhaite ajouter un compteur, après s'être rendu sur la page /ajout,un formulaire est présenter contenant les champs de création d'un compteur.

Au moment ou l'utilisateur entre le code postal de la ville, un appel a l'API geo (https://api.gouv.fr/api/api-geo.html) vas venir analyser le code postal puis renvoyer le code insee correspondant. Dans le cas ou plusieurs villes partagent le même code postal, la valeur rentrée dans le champ ville par l'utilisateur est utilisé pour sélectionner le bon code Insee a ajouter au compteur.

L'utilisateur peut se rendre sur la page /liste afin de voir les compteurs enregistrés, il peut alors grâce aux boutons d'actions proposés consulter un compteur, en modifier un ou encore en supprimer un.

Une fois ces actions effectuées, l'utilisateur est libre de se déconnecter de l'application.

## Technologies utilisés

### Back-end

- Langage de développement : PHP 7.2
- Framework associé : Symfony 3.4
- Libraries externes utilisés : FosUserBundle (intégration d'un module de connexion sécurisé et reconnus)
- Base de données : MySql 5.7.2

### Front-end

- Framework javascript : Jquery
- Librairies utilisées : FontAwesome

## Copyright
Ludovic Noirault
Concepteur développeur informatique
IMIE, Angers