# Battleship - Bataille Navale
## Introduction
Une bataille navale classique  
Avec un espace de connexion par joueur

**C**reate : générer un plateau de jeu  
**R**ead : afficher le plateau d’après la table générée  
**U**pdate : insérer des modifications sur l’état des cellules au tir de missile  
**D**elete : suppression/annulation d’une partie = relancer un plateau de jeu  
 
Je me concentre d'abord sur cette partie, pas sur l’algorithme du jeu.

---

## Les étapes
### Ėtape 1
- [x] Concevoir la DB (MLD) 
- [x] Créer la DB
- [x] Récupérer le script SQL
- [x] Jeu de données test

### Étape 2
- [x] Concevoir et créer l'architecture du site
- [x] Créer les /parts et les routes

### Étape 3
- [x] Cohérence et nettoyage des tables
- [x] Rajout de ``strike_history`` dans la table board et suppression de la table ``strike``
- [x] Corriger les commandes SQL et séparer les fichiers des requêtes d'insertion des jeux de données test
- [x] Modifier password dans la table user par mot_de_passe
- [x] Rajouter la colonne ``role`` dans la table ``user``

### étape 4
- [x] Construction du tableau des cellules (~~version brouillon~~)
- [x] Relancer une partie
- [x] Placement des bateaux

### étape 5
- [x] La création d'un compte utilisateur doit génèrer automatiquement la création d'une partie (game) et d'un plateau (board)
- [x] Installation de la logique du jeu jusqu'à la victoire (mini algorithme)
- [x] Affichage et évolution de la vie des bateaux
- [ ] Correction du bug de chevauchement des bateaux
- [ ] Optimisation des tables ``cell`` et ``boat``
- [ ] Rendu d'affichage de ``strike_history``

### étape 6
- [ ] Cacher les bateaux
- [ ] Mise en route des scores
- [ ] Un peu de stylisation dynamique
- [ ] Historique des tirs affiche seulement les 10 derniers tirs
- [ ] Répartitions des blocs en class

---

## Notes diverses :
* **Réfléchir au fonctionnement du score :**
Nombre minimal de tirs de missiles pour détruire tous les bâteaux.
> 17 cases occupées par des bateaux / 100 cases.
*Ce score se cumule avec toutes les parties.*

* Optimiser la table ``cell``

---

## Pour aller plus loin :
* Des sessions pour deux joueur•euses
* Un historique de score
* Une fonction radar bonus


## Documentation
- Markdown cheat sheet : [Markdown cheat sheet](https://www.markdownguide.org/cheat-sheet/)


## Inspirations
- Battleship <https://dosgames.com/game/battleship/>
- Battle Fleet <https://dosgames.com/game/battle-fleet/># bataille_navale
