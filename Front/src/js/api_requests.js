// TODO : Commentaires !

const defaultItem = $('#paragraphs').children();

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

emptyParagraphs = () => {
    $('#paragraphs').empty().append(defaultItem);
};

getParagraphs = (id, edit = false) => {
    $.getJSON('/api/v1/articles/' + id).done(function (data) {
        edit ? editParagraphs(data) : viewParagraphs(data);
    })
};

editParagraphs = (article) => {
    let deleteButton = $('<input type="button" value="Supprimer l\'article" id="deleteArticleBtn" class="btn btn-outline-danger"/>')
        .on("click", () => {
            deleteArticle(article.ID);
        });

    let viewButton = $('<input type="button" value="Mode vue" class="btn btn-outline-primary"/>')
        .on("click", () => {
            getParagraphs(article.ID);
        });

    let input = $('<input type="button" value="+" class="btn btn-outline-secondary btn-sm">')
        .on("click", function () {
            addTxtArea($(this).parent(), article.ID, 1);
            switchValue($(this));
        });

    let emptyP = $('<p class="text-justify"><i>[Ajouter un premier paragraphe]</i></p>').append(input);

    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1>' +
        '<hr class="my-2"></div>').append(emptyP);

    article.CONTENT.map((para) => {
        let par = $('<p class="lead text-justify"><span>' + para.CONTENT + '</span></p>');

        par.children().css({'cursor': 'pointer'}).click(function () {
            editPara(para, $(this), article.ID)
        });

        input.clone().on("click", function () {
            addTxtArea($(this).parent(), article.ID, Number(para.POSITION) + 1);
            switchValue($(this));
        }).appendTo(par);

        item.append(par);
    });

    $('#paragraphs').empty().append(viewButton).append(deleteButton).append(item);
};

viewParagraphs = (article) => {
    let editButton = $('<input type="button" value="Mode édition" class="btn btn-outline-primary"/>')
        .on("click", () => {
            getParagraphs(article.ID, true);
        });

    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1><hr class="my-2"></div>');

    article.CONTENT.map(para => item.append('<p class="lead text-justify">' + para.CONTENT + '</p>'));

    $('#paragraphs').empty().append(editButton).append(item);
};


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

deleteArticle = (id) => {
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/articles/' + id,
    }).done(() => {
        emptyParagraphs();
    }).fail((err) => {
        console.log(err);
    });
};

addTxtArea = (paragraph, id, paraPosition) => {
    let champ = $('<div class="form-group">' +
        '<textarea class="form-control" rows="5"></textarea>' +
        '</div>');

    champ.on("keypress", "textarea", function (context) {
        if (context.which === 13) {
            let content = $(this).val();

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
                }).done((data) => {
                    console.log(data);

                    let input = $('<input type="button" value="+" class="btn btn-outline-secondary btn-sm">')
                        .on("click", function () {
                            addTxtArea($(this).parent(), id);
                            switchValue($(this));
                        });

                    let par = $('<p class="lead text-justify"><span>' + data.CONTENT + '</span></p>').append(input);

                    par.children().css({'cursor': 'pointer'})
                        .click(function () {
                            editPara(data, $(this))
                        });

                    switchValue($(this).parent().prev().children("input"));
                    $(this).parent().after(par);
                    $(this).parent().remove();
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

editPara = (paragraph, paraHTML, id) => {
    let champ = $('<textarea class="form-control" rows="5">' + paragraph.CONTENT + '</textarea>');
    paraHTML.replaceWith(champ);
    champ.on('keypress', function (context) {
        if (context.which === 13) {
            let content = $(this).val();

            if (content !== "") {
                $.ajax({
                    type: 'PATCH',
                    url: '/api/v1/paragraphs/' + paragraph.ID,
                    data: JSON.stringify({
                        CONTENT: content,
                    }),
                    dataType: 'json',
                    contentType: 'application/json'
                }).done((data) => {
                    let input = $('<input type="button" value="+" class="btn btn-outline-secondary btn-sm">')
                        .on("click", function () {
                            addTxtArea($(this).parent(), id);
                            switchValue($(this));
                        });

                    let newPara = $('<p class="lead text-justify"><span>' + data.CONTENT + '</span></p>').append(input);

                    newPara.children().css({'cursor': 'pointer'})
                        .click(function () {
                            editPara(data, $(this))
                        });

                    $(this).parent().replaceWith(newPara);
                });
            } else {
                $(this).remove();
                // TODO : deletePara
            }
        }
        if (context.which === 0) {
            $(this).replaceWith(paraHTML.click(function () {
                editPara(paragraph, paraHTML)
            }));
        }
    })
};

// TODO : editTitle

// TODO : deletePara

// TODO : rearrangePara
