# COURS Frontend-Backend

## EBM 2017/2018 - Devoir final

__Objectif :__ produire une page permettant l'édition d'articles, avec une ergonomie 2.0 et en
JQUERY/Jquery UI.

**Organisation :**

* Vous pouvez réaliser ce travail en binôme (pas de trinômes, pas de groupes plus grands). On suggère de vous regrouper de manière qu’un étudiant plus aguerri puisse accompagner un étudiant qui débute ;
* Vous rendrez votre travail sur moodle, au plus tard le 31 décembre, à minuit, en me souhaitant une bonne année 2018

**Critères d'évaluation :**

* Expérience utilisateur
* Respect des contraintes fonctionnelles
* Qualité du code (emploi de structures / algorithmes adaptés, performance, sécurité/robustesse)
* Lisibilité du code (commentaires, indentation, tests)
* Qualité du rapport, qui devra présenter un bilan du travail, les choix effectués, les questions qui se posent et perspectives d'améliorations, ainsi qu'un bilan du module (FrontEnd+ BackEnd)
* Qualité de la livraison (fichier expliquant comment installer/utiliser votre code)
* Originalité du code (si vous utilisez des codes tiers, citez vos sources)

**Cahier des charges :**

**NB :** cette description est volontairement non directive de manière à laisser place à des interprétations, des possibilités de design et d’UX variées, pour que chaque binôme produise un travail original.

Une partie de la partie backend de cet exercice est fournie sur moodle, elle permet de gérer des paragraphes par une fonction data.php offrant les interactions CRUD classiques. Il faut revoir le système d'information et le code associé pour gérer des articles, auxquels sont reliés plusieurs paragraphes. Une architecture de type API REST apportera un BONUS, mais vous pouvez garder la solution proposée en TP et l’améliorer.

* Lors du chargement initial de la page, un menu déroulant vide s'affiche
* Une première requête AJAX permet de récupérer la liste des articles disponibles de manière à compléter le menu déroulant
* Lorsque l'utilisateur sélectionne un des articles dans le menu déroulant, une seconde requête est envoyée pour récupérer l'ensemble des paragraphes associés à cet article, qui s'affichent par ordre croissant d'ordre en dessous du menu déroulant, en dessous du titre de l’article
* Il doit être possible d’ajouter un nouvel article au menu déroulant, ce qui qui affiche le nouvel article, directement en mode édition pour pouvoir y insérer de nouveaux paragraphes
* Un bouton « passer en mode édition » permet de rendre les paragraphes éditables, et d’afficher un bouton d’ajout de paragraphe. Il laisse place à un bouton « revenir au mode normal », qui permet de repasser en mode lecture et de cache le bouton d’ajout de paragraphes.
* L'utilisateur pourra éditer un nombre quelconque de paragraphes à la fois, en cliquant sur chacun d'eux
* A chaque fois qu'un paragraphe est cliqué pour être édité, un textarea remplace le paragraphe pour permettre l'édition
* Lorsque l'utilisateur appuie sur 'ESC', il faut annuler tous les paragraphes en cours d'édition, i.e. les faire revenir dans leur état initial d'avant que ne débute l'édition et ce même si des changements étaient déjà intervenus au cours de l'édition. Il faudra donc sauvegarder leurs valeurs au moment de passer en mode édition.
* Lorsque l'utilisateur appuie sur "ENTREE" à l'intérieur d'un textarea, cela valide la modification du paragraphe concerné pour que son nouveau contenu soit envoyé au serveur, et replace le paragraphe initial en enlevant le textarea.
* Un bouton permettra d'ajouter un nouveau paragraphe à l'article en cours. A côté du bouton se trouvera un champ de saisie de texte permettant de préciser le contenu initial du paragraphe. Si ce champ est vide, le contenu initial devra être « Nouveau paragraphe ».
* Lors de l’appui sur le bouton d’ajout, le paragraphe ajouté devra être en mode édition, et le focus du navigateur devra être placé à l’intérieur de ce paragraphe.
* Des interactions de type glisser-déposer permettent de changer l'ordre des paragraphes au sein d'un article. On suggère de les réaliser en utilisant jQuery UI.
* Lors du survol d’un paragraphe, une icône de croix s’affichera, permettant de supprimer ce paragraphe. On suggère de réaliser cette interaction à l’aide de Jquery UI.