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
);

INSERT INTO ARTICLES (TITLE) VALUE ('Article 1');
INSERT INTO ARTICLES (TITLE) VALUE ('Article 2');
INSERT INTO ARTICLES (TITLE) VALUE ('Article 3');
INSERT INTO ARTICLES (TITLE) VALUE ('Article 4');
INSERT INTO ARTICLES (TITLE) VALUE ('Article 5');


INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 1 para 1',1,1);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 1 para 2',2,1);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 1 para 1',3,1);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 1 para 2',4,1);


INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 2 para 1',1,2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 2 para 2',2,2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 2 para 1',3,2);
INSERT INTO PARAGRAPHES (CONTENT, POSITION, ARTICLE_ID) VALUES ('Article 2 para 2',4,2);

SELECT *
FROM PARAGRAPHES;
SELECT *
FROM ARTICLES;

SELECT *
FROM PARAGRAPHES
WHERE ARTICLE_ID = 5;
