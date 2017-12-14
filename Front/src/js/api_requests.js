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
            addTxtArea($(this).parent(), article.ID)
        });

    let emptyP = $('<p class="lead text-justify"></p><br>').append(input);

    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1>' +
        '<hr class="my-2"></div>').append(emptyP);

    article.CONTENT.map((para) => {
        let par = $('<p class="lead text-justify">' + para.CONTENT + '</p>');

        input.clone().on("click", function () {
            addTxtArea($(this).parent(), article.ID)
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

// TODO : ajouter un truc de confirmation avant de supprimer
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

addTxtArea = (paragraph, id) => {
    let champ = $(' <div class="form-group">' +
        '<textarea class="form-control" rows="5" id="comment"></textarea>' +
        '</div> ');
    champ.on("keypress", "textarea", function (contexte) {
        if (contexte.which === 13) {
            let contenu = $(this).val();
            if (contenu !== "") {
                $.ajax({
                    type: 'POST',
                    url: '/api/v1/articles/' + id + '/paragraphs',
                    data: JSON.stringify({
                        CONTENT: contenu,
                        //TODO : POSITION
                    }),
                    dataType: 'json',
                    contentType: 'application/json'
                }).done((data) => {
                    console.log(data);

                    let input = $('<input type="button" value="+" class="btn btn-outline-secondary btn-sm">')
                        .on("click", function () {
                            addTxtArea($(this).parent(), id)
                        });

                    let par = $('<p class="lead text-justify">' + data.CONTENT + '</p>').append(input);

                    $(this).replaceWith(par);
                });
            } //TODO : faire le else
        }
    });
    // TODO : à refaire, ne marche plus avec after. Il faut ne pas générer plus d'un textarea et gérer le 2e cas
    paragraph.children().length === 1 ? paragraph.after(champ) : 0;
};
