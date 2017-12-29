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

```regex
~^/articles/(\d+)/paragraphs/(\d+)/?$~
```

Ainsi, le Framework se compose de 3 classes :

> * Route.php
> * Router.php
> * RouterUtils.php

#### Route.php

La classe Route est un objet qui contient:

* L'expression régulière qui doit correspondre
* La méthode HTTP qui doit correspondre
* La fonction de callback utilisé lorsque la Route est apelée

#### Router.php

La classe Router.php se charge de lister l'ensemble des routes de l'application.
Elle est également appelée lors d'une nouvelle requête afin d'essayer de trouver une route qui correspond à la requête.

#### RouterUtils.php

Cette classe permet de réaliser divers traitements sur la requete:

* Récupérer la partie intéressante de la route (retirer la partie `/api/v1`)
* Récupérer leBody de la requête
* Executer le callback de la route
* Emettre la réponse au client

#### Utilisation

La manière dont sont transmis les paramètres s'effectue de la manière suivante:

La classe Router récupére les paramètres issues des parenthèses capturantes de l'expression régulière.

Ils sont transmis dans un tableau et dans l'ordre d'apparition au sein de l'expression régulière.

La fonction match() renvoie ainsi un tbleau contenant comme premier argument le callback de la route, et comme deuxième argument, un tableau des identifiants récupérés par la regex.

AU seins de executeRoute() de RouterUtils,
Le tableau [callback, params] et les données du Body sont transformé pour donner un tableau associatif contenant les paramètres et les données du Body. 

En résumé, le callback reçoit un unique paramètre qui est un tableau associatif et qui contient;

* Dans 'URL_PARAMS', un tableau contenant les paramètres récupérés dans l'url de la requete
* Dans 'BODY_DATA', un tableau associatif correspondant au json envoyé dans la requête

Le callback se charge ainsi simplement d'extraire les valeurs des paramètres et des données du Body, et au besoin, d'affecter des valeurs par défaut dans le cas d'arguments facultatifs.

Elle appelle ensuite la bonne fonction du contrôleur, qui, lui v

1.Le Callback extrait les valeurs des paramètres des données du Body, et assigne des valeurs par défaut si besoin.
2. Le controlleur, appelé par le callback, vérifie la validité des arguments extraits par le callback.
3. Le modèle, appelé par le controlleur, construit la requête SQL adapté, avec la éventuels paramètres.
4. DBAccess, appelé par le modèle, se charge d'executer la requête.
5. Le controlleur reçoit la réponse de DBAccess, vérifie sa validité, et transforme le résultat en json.
6. Le callback apelle la fonction response() de RouterUtils avec comme paramètre le résultat du contrôlleur pour l'émmettre au client.

## Perspectives d'amélioration

## Bilan du module

## APIDOC

### /api/v1/articles

#### GET

Renvoie la liste des articles sous forme :

``` json
[
    {
        ID: 1,
        TITLE: 'Article 1'
    },
...
]
```

#### POST

Ajoute un nouvel article dans la base de donnée.

Le Body de la requête doit contenir une json de type:

```json
{
    "TITLE": "Article 42"
}
```

### /api/v1/articles/{id}

#### GET

Renvoie l'article sous la forme

```json
{
    "ID": 5,
    "TITLE": "Article 5",
    "CONTENT": [
        {
            "ID": 1,
            "ARTICLE_ID": 5,
            "CONTENT": "Para1, article5"
        },
        ...
    ]
}
```

#### PATCH

//TODO

Modifie l'article avec l'id {id}
```json
{
    "TITLE": "Article 5.1"
}
```

La réponse du serveur, si la modification a été réussie, est le paragraph modifié:

```json
{
    "ID": 5,
    "TITLE": "Article 5.1"
}
```

#### DELETE

Supprime l'article avec l'id associé.

Rénvoie true si réussite, false sinon

### /api/v1/articles?paragraphs=true

#### GET

Renvoie la liste des articles avec leurs paragraphes, ordonné selon leur position, sous la forme:

```json
[
    {
        "ID": 5,
        "TITLE": "Article 5",
        "CONTENT": [
            {
                "ID": 1,
                "ARTICLE_ID": 5,
                "POSITION": 1,
                "CONTENT": "Paragraphe 1 de l'article 5"
            },
            ...
        ]
    },
...
]
```

### /api/v1/articles/{id}/paragraphs

#### GET

Renvoie l'ensemble des paragraphs associé à l'article ayant pour ID {id}

```json
[
    {
        "ID": 1,
        "ARTICLE_ID": 4,
        "POSITION": 1,
        "CONTENT": "Paragraphe 1 de l'article 4"
    },
    ...
]
```

#### POST

Ajoute un paragraph dans l'article.

Le Body de la requête doit contenir une json de type:

```json
{
    "CONTENT": "Paragraphe 42 de l'article 3",
    "POSITION": 5
}
```

La position est facultative, le paragraphe sera ajouté à la fin si la position n'est pas précisée.

### /api/v1/articles/{idA}/paragraphs/{pos}


#### GET

Renvoie la pos-ième paragraphe de l'article idA, sous la forme:

```json
{
    "ID": 5,
    "CONTENT": "Para pos article idA",
    "ARTICLE_ID": idA,
    "POSITION": pos
}
```

### /api/v1/paragraphs

#### GET

Renvoie la liste des paragraphs sous la forme:

```json
[
    {
        "ID": 1,
        "ARTICLE_ID": 5,
        "POSITION": 1,
        "CONTENT": "Paragraphe 1 de l'article 5"
    },
    ...
]
```

### /api/v1/paragraphs/{id}

#### GET

Renvoie l'article ayant pour id {id} sous la forme:

```json
{
    "ID": 1,
    "ARTICLE_ID": 5,
    "CONTENT": "Para1, article5"
}
```

#### DELETE

Supprime l'article avec l'id {id}.

Renvoie true ou false si la suppression a été réussi ou non.

#### PATCH

Modifie l'article.

le json doit être envoyé sous la forme:

```json
{
     "ARTICLE_ID": 4,
     "POSITION": 1,
     "CONTENT": "Paragraphe 1 de l'article 4"
}
```

Les éléments sont facultatifs: seules les valeurs dans le json seront modifiées dans la base de donnée.

La réponse est un json contenant le paragraphe mis à jour:

```json
{
     "ID" : {id}
     "ARTICLE_ID": 4,
     "POSITION": 1,
     "CONTENT": "Paragraphe 1 de l'article 4"
}
```