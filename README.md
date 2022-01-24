<h1>Cahier des charges</h1>

A.	Présentation du client
Optimum est une salle de sport qui propose diverses activités dont le yoga, le cross-training, le cardio-training, le renforcement musculaire, sous forme de cours particuliers et collectifs.
B.	Définition du besoin
Afin d’améliorer l’expérience utilisateur, OPTIMUM souhaite refaire son site internet. Le directeur Monsieur Ga souhaite moderniser son site en ajoutant un module de réservation pour les différents cours de sport et autres services comme les séances de yoga.
Le site permettra la réservation des services suivants :
•	Accès à la salle de musculation (9000/m - 110000/a)
•	Cours particuliers
o	Renforcement musculaire (6000/s)
o	Préparation physique (6000/s)
•	Cours collectifs
o	Cardio training (3000/s)
o	Cross training (4000/s)
•	Séance de yoga (5000/s)
Le directeur souhaite aussi rendre ce nouveau site internet accessible sur mobile car beaucoup de clients réservent des cours pendant leur journée de travail ou sur le trajet de la salle de sport. Une tablette sera aussi mise à disposition à l’entrée de la salle de sport pour confirmer la présence des inscrits aux séances réservées. Monsieur Ga souhaite conserver le rôle premier du site qui est d’informer et de présenter la salle de sport au travers de photos et textes pouvant être vus sur les moteurs de recherche et réseaux sociaux.

C.	Spécifications fonctionnelles (User stories)
Entant qu’administrateur :
-	Je veux pouvoir accéder aux back-office du site afin de le manipuler entièrement.
-	Je veux pouvoir répondre aux messages des clients intéressés par nos services afin de ne pas les faire attendre et d’avoir un contact direct avec les clients.
-	Je veux pouvoir modifier les informations disponibles sur les pages du site (photos, articles, texte,..) afin de publier et renseigner ce que je souhaite.
-	Je veux pouvoir renseigner les informations sur les services proposés de la salle de sport afin qu’ils apparaissent sur le site.
Entant que client :
-	Je veux pouvoir accéder au site partout où je me déplace afin de voir les dernières offres proposées par OPTIMUM.
-	Je veux pouvoir envoyer un message à la salle de sport afin d’être renseigné si j’ai des questions (sur les offres par exemple).
-	Je veux pouvoir réserver un cours ou une séance en ligne afin d’y participer.
-	Je veux pouvoir les contacter dans le cas où je décide d’annuler une réservation.

D.	Spécifications techniques
Le site est réalisé sur Wordpress.
E.	Structure du site et maquettage
Plan de site :
•	Accueil
•	Les cours
•	Les offres
•	Réservation
•	Contact
Les maquettes fil de fer du site sont renseignées dans le dossier « maquettes ».

Accéder au site ici : 
A améliorer :
Il faut savoir que j’utilise deux API de Google dans ce projet :
-	Gmail API (utilisé avec WP Mail SMTP, un plugin Wordpress, pour l’envoie de mail)
-	Google Maps API (utilisé pour la localisation de l’entreprise et l’intégration de la map sur la page « Contact » du site)
Sur l’URL renseigné ci-dessus, l’envoie d’email est impossible car le site est lancé depuis le serveur SSH de mon établissement de formation et ne m’autorise pas les accès actuellement. L’envoie de mail est donc impossible mais, si vous souahitez tester l’API Gmail, vous pouvez le faire depuis votre environnement local (lancement de Wordpress sous htdocs et test à partir de xampp avec l’URL « localhost :8080/path/… » (selon vos configuration).
