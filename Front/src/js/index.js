/**
 * Affichage par défaut quand aucun article n'est sélectionné. Défini dans index.html
 * @type {*|jQuery}
 */
const defaultItem = $('#paragraphs').children();

/**
 * Récupère la liste des articles via une requête GET sur l'API. (cf apidoc)
 * Une fois le JSON correspondant récupéré, injecte le titre des articles dans le menu déroulant, avec la possibilité
 * de cliquer sur chaque titre pour récupérer ses paragraphes et les afficher (fonction getParagraphs)
 */
getArticles = () => {
    $.getJSON('/api/v1/articles').done(function (data) {
        $(".dropdown-item").remove();
        for (let i in data) {
            let item = $('<a class="dropdown-item">' + data[i].TITLE + '</a>')
                .on("click", function () {
                    getParagraphs($(this).data('article').ID);
                })
                .data("article", data[i]);
            $("#listeArticles").append(item).css('cursor', 'pointer');
        }
    })
};

/**
 * Retire l'affichage des paragraphes et affiche le defaultItem à la place
 */
emptyParagraphs = () => {
    $('#paragraphs').empty().append(defaultItem);
};

/**
 * Récupère l'article entier associé à l'id donné en paramètre, et utilise la fonction d'affichage
 * en mode vue ou en mode édition selon la valeur de edit en leur passant
 * @param {Number} id
 * @param {boolean} edit
 */
getParagraphs = (id, edit = false) => {
    $.getJSON('/api/v1/articles/' + id).done(function (data) {
        edit ? editParagraphs(data) : viewParagraphs(data);
    })
};

/**
 * Fonction d'affichage des paragraphes en mode édition
 * @param {Object} article
 */
editParagraphs = (article) => {
    let deleteButton = $('<input type="button" value="Supprimer l\'article" id="deleteArticleBtn" class="btn btn-outline-danger"/>')
        .on("click", () => {
            deleteArticle(article.ID);
        });

    let viewButton = $('<input type="button" value="Mode vue" class="btn btn-outline-primary"/>')
        .on("click", () => {
            getParagraphs(article.ID);
        });

    let addButton = $('<input type="button" value="+" class="btn btn-outline-secondary btn-sm">')
        .on("click", function () {
            addTxtArea($(this).parent(), article.ID, 1);
            switchValue($(this));
        });

    let deleteParaButton = $('<input type="button" value="X" class="btn btn-outline-danger btn-sm">');

    let emptyP = $('<p class="text-justify" id="immobile"><i>Ajoutez un premier paragraphe en cliquant sur le bouton "+" à droite ==></i></p>').append(addButton);

    let item = $('<div class="container" id="sort"><h1 class="display-4">' + article.TITLE + '</h1>' +
        '<hr class="my-2"></div>').append(emptyP);

    item.children("h1").css({'cursor': 'pointer'}).click(function () {
        editTitle(article.ID, $(this));
    });

    article.CONTENT.map((para) => {
        let par = $('<p class="lead text-justify"><span>' + para.CONTENT + '</span></p>').data('para',para)
            .on('mouseenter', $(this), function () {
            $(this).find("#del").show();
        }).on('mouseleave', $(this), function () {
            $(this).find("#del").hide();
        });

        par.children().css({'cursor': 'pointer'}).click(function () {
            editPara(para, $(this), article.ID)
        });

        addButton.clone().on("click", function () {
            addTxtArea($(this).parent(), article.ID, Number(para.POSITION) + 1);
            switchValue($(this));
        }).appendTo(par);

        deleteParaButton.clone().on("click", function () {
            deletePara(para.ID, article.ID);
        }).appendTo(par).hide().attr('id','del');

        item.append(par);
    });

    $('#paragraphs').empty().append(viewButton).append(deleteButton).append(item);
    /**
     * Rend la liste sortable:
     * Lors d'un drag&drop, si la position a été modifiée, une requête patch est envoyé au serveur pour modifier
     * la position du paragraph.
     * Etant donné que la gestion de la mise à jour des positions des autres paragraphes est gérée niveau serveur,
     * il est ensuite nécessaire de récupérer les nouveaux paragraphs depuis le serveur
     *
     * items: '>p:not(#immobile)' permet de rendre immuable le premier paragraphe (celui d'exemple)
     * helper : 'clone' permet d'empêcher le click event de se déclencher à la fin du drag&drop
     */
    $('.container').sortable({
        update: function (event, ui) {
            $.ajax({
                type: 'PATCH',
                url: '/api/v1/paragraphs/' + ui.item.data().para.ID,
                data: JSON.stringify({
                    POSITION: ui.item.index()-2,
                }),
                dataType: 'json',
                contentType: 'application/json'
            }).done(function(){
                getParagraphs(article.ID, true);
            }).fail(function (data) {
                console.log(data)
            });
        },
        items: '>p:not(#immobile)',
        helper : 'clone',
    });
};

/**
 * Fonction d'affichage des paragraphes en mode vue
 * @param {Object} article
 */
viewParagraphs = (article) => {
    let editButton = $('<input type="button" value="Mode édition" class="btn btn-outline-primary"/>')
        .on("click", () => {
            getParagraphs(article.ID, true);
        });

    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1><hr class="my-2"></div>');

    article.CONTENT.map(para => item.append('<p class="lead text-justify">' + para.CONTENT + '</p>'));

    $('#paragraphs').empty().append(editButton).append(item);
};

/**
 * Ajoute un article contenant seulement un titre (informé par l'utilisateur dans le champ prévu à cet effet) dans
 * la base de données via une requête POST. À la fin de la requête, affiche cet article en mode édition
 */
postArticle = () => {
    const title = $('#addArticleTxt').val();

    $.ajax({
        type: 'POST',
        url: "/api/v1/articles",
        data: JSON.stringify({TITLE: title}),
        dataType: 'json',
        contentType: "application/json"
    }).done(function (data) {
        getParagraphs(data.ID, true);
        $('#addArticleTxt').val('');
    });
};

/**
 * Supprimer un article défini par son id via une requête DELETE. Une fois cela fait, affiche le message par défaut.
 * @param {Number} id
 */
deleteArticle = (id) => {
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/articles/' + id,
    }).done(() => {
        emptyParagraphs();
    }).fail((err) => {
        console.error(err);
    });
};

/**
 * Ajoute un textarea en dessous du paragraph.
 *
 * S'il existe déjà un textarea en dessous du paragraph, supprime ce textarea plutôt que d'en ajouter un.
 *
 * Appuyer sur la touche ENTRÉE dans le textarea non vide ajoutera (requête POST) un nouveau paragraphe en dessous du
 * paragraph cité précedemment, dont le contenu sera ce qui a été entré dans le textarea. On recharge l'affichage en
 * édition de l'article une fois cela fait.
 *
 * Appuyer sur la touche ÉCHAP supprimera le textarea.
 * @param {jQuery} paragraph
 * @param {Number} id
 * @param {Number} paraPosition
 */
addTxtArea = (paragraph, id, paraPosition) => {
    let champ = $('<div class="form-group">' +
        '<textarea class="form-control" rows="5"></textarea>' +
        '</div>');

    champ.on("keypress", "textarea", function (context) {
        if (context.which === 13) {
            const content = $(this).val();

            if (content !== "") {
                $.ajax({
                    type: 'POST',
                    url: '/api/v1/articles/' + id + '/paragraphs',
                    data: JSON.stringify({
                        CONTENT: content,
                        POSITION: paraPosition,
                    }),
                    dataType: 'json',
                    contentType: 'application/json'
                }).done(() => {
                    getParagraphs(id, true);
                }).fail((err) => {
                    console.error(err);
                });
            } else {
                switchValue($(this).parent().prev().children("input"));
                $(this).parent().remove();
            }
        }
        if (context.which === 0) {
            switchValue($(this).parent().prev().children("input"));
            $(this).parent().remove();
        }
    });
    if (paragraph.next().is('div')) {
        paragraph.next().remove()
    } else {
        paragraph.after(champ);
        paragraph.next().children().focus();
    }
};

/**
 * Change la valeur du bouton d'ajout de paragraphe vers "+" (s'il vaut "-") ou "-" (s'il vaut "+")
 * @param {jQuery} button
 */
switchValue = (button) => {
    switch (button.val()) {
        case '+':
            button.val('-');
            break;
        case '-':
            button.val('+');
            break;
        default:
            console.log('Pas un bouton !');
    }
};

/**
 * Fonctionne de manière similaire à la fonction précédente, mais pour éditer le contenu d'un paragraphe (requête PATCH)
 * @param {Object} paragraph
 * @param {jQuery} paraHTML
 * @param {Number} id
 */
editPara = (paragraph, paraHTML, id) => {
    let champ = $('<textarea class="form-control" rows="5"></textarea>');
    paraHTML.replaceWith(champ);
    champ.on('keypress', function (context) {
        if (context.which === 13) {
            const content = $(this).val();

            if (content !== "") {
                $.ajax({
                    type: 'PATCH',
                    url: '/api/v1/paragraphs/' + paragraph.ID,
                    data: JSON.stringify({
                        CONTENT: content,
                    }),
                    dataType: 'json',
                    contentType: 'application/json'
                }).done(() => {
                    getParagraphs(id, true);
                });
            } else {
                deletePara(paragraph.ID, id);
            }
        }
        if (context.which === 0) {
            $(this).replaceWith(paraHTML.click(function () {
                editPara(paragraph, paraHTML)
            }));
        }
    }).focus().val(paragraph.CONTENT);
};

/**
 * Similaire à la fonction précédente mais s'applique au titre d'un article.
 * @param {Number} articleId
 * @param {jQuery} titleHTML
 */
editTitle = (articleId, titleHTML) => {
    let champ = $('<textarea class="form-control" rows="1">' + titleHTML.contents()['0'].data + '</textarea>');
    titleHTML.replaceWith(champ);
    champ.on('keypress', function (context) {
        if (context.which === 13) {
            const content = $(this).val();
            $.ajax({
                type: 'PATCH',
                url: '/api/v1/articles/' + articleId,
                data: JSON.stringify({
                    TITLE: content,
                }),
                dataType: 'json',
                contentType: 'application/json'
            }).done(() => {
                getParagraphs(articleId, true);
            });
        }
        if (context.which === 0) {
            getParagraphs(articleId, true)
        }
    })
};

/**
 * Supprime un paragraphe défini par son id (requête DELETE)
 * @param {Number} paraId
 * @param {Number} articleId
 */
deletePara = (paraId, articleId) => {
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/paragraphs/' + paraId,
    }).done(() => {
        getParagraphs(articleId, true);
    })
};

// TODO : rearrangePara
