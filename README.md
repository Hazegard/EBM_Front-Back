# Compte-rendu du devoir final Frontend-Backend

## Bilan du travail

* Mise en place d'un repository sur Gitlab
* Mise en place de Bootstrap et jQuery
* Mise en place d'une base de données MySQL contenant les articles et les paragraphes
* Mise en place d'une API REST permettant de gérer les articles et leurs paragraphes
* Mise en place d'un front-office fournissant une interface à l'utilisateur et requêtant l'API

## Choix effectués

### Structure générale

Nous avons décidé de nous diriger vers l'utilisation d'une API RestFull afin d'une part, de découpler le développement du Back-End et celui du Front-End.

Ainsi, cela nous a permis de travailler dans deux dossiers complétements séparés, nous permettant d'éviter les régression de l'un lorsque l'on modifie la structure de l'autre.

Nous avons ainsi choisi de de réaliser notre Back-End en pHp, en utilisant le typage des arguments de fonctions, ainsi que le typage de retour de fonction, afin d'augmenter la robustesse de notre coed produit.

Concernant le Front-End, nous utilisont la librairie jQuery pour réaliser les interactions avec l'utilisateur, ainsi que la librairie Bootstrap, permettant un meilleur rendu.

Le serveur sur lequel notre projet s'execute est apache, avec une configuration que nous détaillerons ultérieurement.

## Présentation du Back-End

### Le Framework

Nous avons décidé d'écrire notre propre Framework afin de réaliser notre API. En effet, cela nous permettait d'avoir une bone compréhension de son fonctionement, tout en étant léger car adapté à nos besoins.

Ainsi le routage s'effectue à l'aide de regex, qui nous permet de facilement faire évoluer nos routes, mais également de facilement récupérer les paramétres éventuels nécessaire au bon fonctionnement de l'API, par exemple, dans le cas de la route:

```url
/api/v1/articles/5/paragraphs/1
```

Nous voulons récupérer le ```5``` associé à un ID d'article, ainsi que le `5`, associé à un paragraph dans l'article `1`.

Cela est, grâce à l'utilisation re regex, facilement réalisable, par exemple en utilisant cette regex:
```
~^/articles/(\d+)/paragraphs/(\d+)/?$~
```

Ainsi, le Framework se compose de 3 classes :

> * Route.php
> * Router.php
> * RouterUtils.php



## Perspectives d'amélioration

## Bilan du module
