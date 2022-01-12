# Propar

Installation

Pour pouvoir utiliser votre première application symfony, il vous faut:
Avoir PHP 7.2.5 ou plus ainsi que ces extention (qui sont normalement installées par défaut avec PHP): Ctype, iconv, JSON, PCRE, Session, SimpleXML, et Tokenizer;
Avoir Composer, en sa version 2.1.12+, pour pouvoir installer des extensions. Pour vérifier votre version de composer:
      - composer -V

Avoir Symfony, en sa version 5.4+, pour utiliser le projet. Pour vérifier votre version de symfony, ouvrez votre projet et tapez:
      - php bin/console --version
      
Installation des packages
La prochaine étape est d'installer tous les packages de composer nécessaire au projet (liste disponible dans les fichiers composer.json et composer.lock présents dans le dossier racine du projet) :
      - composer install
      
      
      
Mise en place de la base de donnée
Pour une base de donnée (BDD) en ligne, insérez le lien vers votre BDD dans le fichier .env, présent dans la racine de votre projet:
      - DATABASE_URL=”MOTEUR_SERV://LOGIN:PASSWORD@IP/NOM_BDD?serverVersion=version8serv”
      
      
Pour une base de donnée (BDD) local, il vous faudra un logiciel tel que WAMP, et le lancer. Insérez le lien vers votre BDD dans le fichier .env, présent dans la racine de votre projet:
      - DATABASE_URL=”MOTEUR_SERV://LOGIN:PASSWORD@IP/NOM_BDD?serverVersion=version8serv”
      
      
Une fois la connexion à la BDD prête, il faut créer la base donnée. Pour ce faire, executez dans le projet:
      - php bin/console doctrine:migrations:migrate
      
Si vous utilisez une connexion locale, la seule chose qui vous reste à faire à présent est de lancer le serveur interne à partir du projet:
      - symfony server:start









Invité
Page d'accueil
Lorsque vous accédez pour la première fois au site, vous tombez sur la page d'accueil. 
Sur celle-ci, vous trouverez la liste des opérations en cours, ainsi que celles terminée / annulée. 
Il vous est également proposé de vous connecter à l'aide du bouton 'Se Connecter'.



Se Connecter
Lorsque vous cliquez sur le bouton 'Se Connecter', vous arrivez sur la page de connexion. 
Sur celle-ci, vous devez insiquer votre nom de compte ainsi que votre mot de passe, puis cliquer sur le bouton 'Se Connecter'. 
En cas d'erreur, elle sera indiqué.





Apprenti / Senior
Page d'accueil
Si vous êtes un apprenti ou un senior, la page d'accueil affichera votre état de connexion et présentera deux nouvelles fonctionnalités: 
      - modification
      - création
      - supression d'un client, et d'une opération. 
      
Vous pouvez alors cliquer sur une opération éxistante afin de la modifier ou de la supprimer. 
Vous pouvez également appuyer sur le bouton 'Clients' afin d'accéder à la page Clients.



Clients
La page Clients, comme la page Opérations, permet 
      - d'afficher
      - créer 
      - modifier un client 
      
Lorsque vous accédez aux informations d'un client, vous avez deux fonctionnalités web. 

      - La première est l'autocomplétion d'adresse. Losqur vous commencez à taper une adresse, une API externe vous propose d'auto-compléter cette adresse. 
      - La deuxième fonctionnalité est celle de la carte, qui vous montre instantanément la localisation de l'adresse.
      
      
Annulation d'une action
Si vous voulez revenir en arrière afin d'annuler une action en cours, vous pouvez: 
      - cliquer sur le bouton 'Retour'
      - soit cliquer sur le logo de l'entreprise, qui vous renverra à la page d'accueil.
      
      
Se Déconnecter
Si vous souhaiter vous déconnecter, vous pouvez cliquer sur le bouton 'Se déconnecter' en haut de la page.






Expert
Page d'accueil
Si vous êtes connecté en tant qu'expert, vous possédez toutes les fonctionnalités des apprentis / seniors, en plus de deux nouvelles: 
      - L'affichage du chiffre d'affaire, 
      - L'accès à la page 'Employés'
      
      
Chiffre d'affaire
Le chiffre d'affaire est affiché en haut de la page d'accueil. Il est calculé automatiquement en prenant en compte les opérations en cours, terminée et en attente.


Employés
L'expert à accès à la page 'Employés', qui fonctionne de la même manière que les pages 'Opérations' et 'Clients'. 
Vous pouvez accéder à cette page en cliquant sur le bouton 'Employés'. Sur cette page, vous pouvez:
      - afficher
      - modifier
      - supprimer un employé.




RGPD

Supression de données
Lors de la supression d'un client, d'une opération ou d'un employé, pour des raisons de fonctionnalités mais aussi de respect de la RGPD, 
les données ne sont pas réellement supprimées. Elles sont anonymisées en utilisant un algorithme de cryptage.
