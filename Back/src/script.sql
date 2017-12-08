DROP TABLE IF EXISTS PARAGRAPHES;
DROP TABLE IF EXISTS ARTICLES;

CREATE TABLE ARTICLES (
  ID    INT PRIMARY KEY AUTO_INCREMENT,
  TITLE VARCHAR(255)
);

CREATE TABLE PARAGRAPHES (
  ID         INT PRIMARY KEY AUTO_INCREMENT,
  CONTENT    TEXT,
  POSITION   INT,
  ARTICLE_ID INT,
  FOREIGN KEY (ARTICLE_ID) REFERENCES ARTICLES (ID)
    ON DELETE CASCADE
);

INSERT INTO ARTICLES (TITLE) VALUE ('Lorem Ipsum');
INSERT INTO ARTICLES (TITLE) VALUE ('Les 20 meilleures répliques de Perceval');
INSERT INTO ARTICLES (TITLE) VALUE ('The Game');


INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
  1, 1);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
  2, 1);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.',
  3, 1);


INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '1- "Une fois, à une exécution, je m''approche d''une fille. Pour rigoler, je lui fais : « Vous êtes de la famille du pendu ? »... C''était sa sœur. Bonjour l''approche !"',
  1, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '2- "Faut arrêter ces conneries de nord et de sud ! Une fois pour toutes, le nord, suivant comment on est tourné, ça change tout !"',
  2, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '3- "Faut faire comme avec les scorpions qui se suicident quand ils sont entourés par le feu, faut faire un feu en forme de cercle, autour d’eux, comme ça ils se suicident, pendant que nous on fait le tour et on lance de la caillasse de l’autre côté pour brouiller... Non ?"',
  3, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '4- "Là, vous faites sirop de vingt-et-un et vous dites : beau sirop, mi-sirop, siroté, gagne-sirop, sirop-grelot, passe-montagne, sirop au bon goût."',
  4, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '5- "J''le dis pas (en parlant de la date de son anniversaire). [...] A l''époque quand je le disais, tout le monde oubliait de me le souhaiter. Ça me faisait pleurer. Ça m''a gonflé, j''ai arrêté."',
  5, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '6- "Ben j''en ai marre. Ça revient à chaque fois sur le tapis ça. [Arthur: Quoi ça ?] Fédéré! D''habitude j''dis rien mais là zut! J''sais pas c''que ça veut dire. Moi j''veux bien faire des efforts pour comprendre les réunions mais faut que chacun y mette du sien aussi. Là on est partis pour une heure avec des fédérés par-ci des fédérés par-là, j''vais encore rien biter et ça me gonfle."',
  6, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '7- "Sans blague on pourrait pas fêter la mort des mecs que je connais pour une fois ? (Comment ça ?) C''est toujours la mort de vos potes à vous que l''on fête, moi dans quatre jours c''est l''anniversaire de la mort d''un oncle à moi, sans faire exprès il s''est tiré dessus avec un arc."',
  7, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '8- "C''est moi qui remporte le tour. Quand on remporte le tour à Sloubi, on a quatorze solutions possibles : soit on annule le tour ; soit on passe ; soit on change de sens ; soit on recalcule les points ; soit on compte ; soit on divise par six ; soit on jette les bouts de bois de quinze pouces, ça c''est quand on joue avec les bouts de bois ; soit on se couche ; soit on joue sans atouts. Et après y''a les appels : plus un ; plus deux ; attrape oiseaux ; régoudon ; ou chante Sloubi. [...] Comme vous êtes second, vous avez plus que dix-neuf solutions possibles : soit vous passez ; soit vous sciez en deux les cinquante poutrelles de trente pieds, mais ça c''est quand on joue avec les bouts de bois. Sinon c''est les relances : doublette ; jeu carré ; jeu de piste ; jeu gagnant ; jeu moulin ; jeu-jeu ; joue-jeu ; joue-joue ; joue-jié ; joue-ganou ; gagnar ; catakt ; tacat ; cacatac ; cagat-cata et ratacat-mic. Ou : chante Sloubi. Nous, on va faire que chante Sloubi." ',
  8, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '9- "Dans le Languedoc, ils m''appellent Provençal. Mais c''est moi qui m''suis gouré en disant mon nom. Sinon, en Bretagne, c''est le Gros Faisan au sud, et au nord, c''est juste Ducon .."',
  9, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('10- "On en a gros!"', 10, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '11- "Sur une échelle de 2 à 76, et là je préfère prendre large, de 2 à 71 on ne nous écoute pas, de 72 à 75, on nous écoute toujours pas, et seulement à 76 on nous laisse parler sans nous engueuler"',
  11, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID)
VALUES ('12- "Mais cherchez pas à faire des phrases pourries... On en a gros, c''est tout !"', 12, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '13- "Moi, la canne, ça m’aide. Je visualise le caillou dans l’eau, j’ai l’impression de faire partie d’un tout, moi, le caillou, le fil, le lac, le ciel, c’est entier, vous comprenez ? C’est bien fini. C’est pour ça, moi je me dis, c’est dans ces moments-là qu’on peut bien comprendre des trucs. Vous me prenez pour un con, non ?"',
  13, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '14- (À Mevanwi) "Elle a compris la vilaine frisée ? On a dans l''projet de fonder un clan autonome pour partir à l''aventure et ramener du pognon pour entretenir vos grosses miches !! Alors le cageot il dit merci et il ferme sa boîte à caca !!!"',
  14, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '15- "Je vais vous poser une série de questions. Vous répondez par oui, non, ou Zbradaraldjan. Ok c''est parti : où se trouve l''oiseau ?... Allez c''est facile ça. Trouve pas ? Bon tant pis. C''était "sur la branche". Eh oui, y a des pièges."',
  15, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '16- "Ma tante me demande de trouver un endroit pour y entreposer 667 noix. A la cave il y a de la place pour 595, à la remise il y a la place pour 337. Qu''est-ce que je fais ? Je les ?... Allez on cherche bon dieu ! Je les... Zbradaraldjan le grenier!... Allez il dégage le bourrin !"',
  16, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '17- "Votre femme, si j''avais pas la flemme de descendre de là, elle aurait pris mon pied dans son cul depuis un moment. Parce y''a un truc qu''on oublie quand on parle de retirer Excalibur : c''est le respect au Roi Arthur! Et le respect au Roi Arthur je remarque que Madame en avait un peu plus quand elle était dans son PLUMARD !!"',
  17, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '18- "Allez, y''a plein de bruit, là ! Si ça se trouve c''est bourré d''oiseaux venimeux. Y''en a des rouges, des jaunes, des re-rouges et des pourpres ! Y bouffent que des noisettes et des escalopes de veau. Et quand ils vous donnent un coup de bec vous voyez une grande lumière et ça vous donne la diarrhée !"',
  18, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('19- "C''est pas faux !" ', 19, 2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES (
  '20- "Mais moi, j’m’en fous des honneurs, rien à péter, le Graal aussi, rien à péter. Moi, c’est Arthur qui compte. Moi je suis pas un as de la stratégie ou du tir à l’arc, mais je peux me vanter de savoir ce que c’est que d’aimer quelqu’un. "',
  20, 2);

INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Perdu !', 1, 3);


