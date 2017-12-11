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

getParagraphs = (id) => {
    $.getJSON('/api/v1/articles/' + id).done(function (data) {
        displayParagraphs(data);
    })
};

// TODO : ajouter un "mode vue" sans bouton intrusif, et juste un bouton "mode édition" qui affiche tous les boutons
displayParagraphs = (article) => {
    let deleteButton = $('<input type="button" value="Supprimer" id="deleteArticleBtn" class="btn btn-outline-danger"/>')
        .on("click", () => {
            deleteArticle(article);
        });
    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1>' +
        '<hr class="my-2"></div>').append('<p><input type="submit" value="+" id="addArticleBtn" class="btn btn-outline-secondary btn-sm"/></p><br>');
    article.CONTENT.map((para) => {
        item.append('<p class="lead text-justify">' + para.CONTENT +
            '<input type="submit" value="+" id="addArticleBtn" class="btn btn-outline-secondary btn-sm"/></p>')
    });
    $('#paragraphs').empty().append(deleteButton).append(item);
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
        getParagraphs(data.ID);
        $('#addArticleTxt').val('');
    });
};

// TODO : ajouter un truc de confirmation avant de supprimer
deleteArticle = (article) => {
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/articles/' + article.ID,
    }).done(() => {
        emptyParagraphs();
    });
};

postParagraph = () => {
    // ...
};
