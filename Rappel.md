===============================
       INTERFACE CLIENTE
===============================
URL : /  ou /reservation
Accès : Toutes les clientes
Actions :
  - Voir la homepage (services et catégories)
  - Voir les avis des clientes
  - Sélectionner un ou plusieurs services
  - Remplir prénom, email, téléphone
  - Réserver un créneau
Technologies :
  - Symfony Twig
  - TailwindCSS pour le style
Notes :
  - Les clientes **ne peuvent pas modifier la base**
  - Affichage dynamique via les entités Service, Category, Avis

-------------------------------
       INTERFACE ADMIN
-------------------------------
URL : /service, /category, /order, /avis
Accès : Compte ROLE_ADMIN (ta copine)
Actions :
  - CRUD Service : Ajouter / Modifier / Supprimer
  - CRUD Category : Ajouter / Modifier / Supprimer
  - CRUD Order : Voir toutes les commandes (lecture seule possible)
  - CRUD Avis : Modérer / Supprimer commentaires
Technologies :
  - Symfony Controllers / Forms / Twig
  - TailwindCSS pour le style des CRUD

===============================
        RELATIONS
===============================
- Service ↔ Category : un service appartient à une catégorie
- Order ↔ OrderService ↔ Service : une commande contient plusieurs services
- Service ↔ Avis : un service peut avoir plusieurs avis



===============================
       PLAN DE NAVIGATION
===============================

--- INTERFACE CLIENTE ---
Page d’accueil / Réservation
URL : /
Contenu :
  - Header avec logo et menu : Prestations | Avis | Contact | Réserver
  - Hero : texte d’accroche + formulaire de recherche rapide
  - Section Prestations : liste des services avec prix et durée
  - Section Avis : retours des clientes précédentes
  - Section Réservation : formulaire prénom, email, téléphone + sélection service
Actions :
  - Sélectionner un service
  - Remplir ses infos
  - Cliquer sur "Réserver" pour créer une commande
Note :
  - Les clientes **ne peuvent pas accéder aux pages admin**
  - Les services et avis sont récupérés via Twig avec notation pointée

--- INTERFACE ADMIN (ROLE_ADMIN) ---
Page Services
URL : /service
Actions :
  - Ajouter / Modifier / Supprimer un service
  - Voir liste des services
Page Catégories
URL : /category
Actions :
  - Ajouter / Modifier / Supprimer une catégorie
Page Commandes
URL : /order
Actions :
  - Voir toutes les commandes (lecture seule)
  - Voir détails d’une commande (services, client, date, statut)
Page Avis
URL : /avis
Actions :
  - Modérer / Supprimer des avis

===============================
       LIENS ENTRE ENTITÉS
===============================
- Service ↔ Category : un service appartient à une catégorie
- Order ↔ OrderService ↔ Service : une commande contient plusieurs services
- Service ↔ Avis : un service peut avoir plusieurs avis

===============================
       NOTES TECHNIQUES
===============================
- Symfony Controllers / Forms / Twig pour toutes les pages
- TailwindCSS pour le style et les layouts
- Les pages clientes utilisent la notation pointée pour accéder aux données
- Les CRUD admin gèrent les entités et sont sécurisés via ROLE_ADMIN


Une entité Days
Une entité horaires
Ajouter des jours, et des horaires à afficher
si un horaire est affiché dans la commande et validé alors il disparait du twig et il faut le reactiver