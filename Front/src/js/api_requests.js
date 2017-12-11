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
            deleteArticle(article);
        });
    let viewButton = $('<input type="button" value="Mode vue" class="btn btn-outline-primary"/>')
        .on("click", () => {
            viewParagraphs(article);
        });
    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1>' +
        '<hr class="my-2"></div>').append('<p id="emptyP"><input type="button" value="+" class="btn btn-outline-secondary btn-sm" ' +
        'onclick="postParagraph($(this).parent())"/></p><br>');
    article.CONTENT.map((para) => {
        item.append('<p class="lead text-justify">' + para.CONTENT +
            '<input type="button" value="+" class="btn btn-outline-secondary btn-sm" onclick="postParagraph($(this).parent())"/></p>')
    });
    $('#paragraphs').empty().append(viewButton).append(deleteButton).append(item);
};

viewParagraphs = (article) => {
    let editButton = $('<input type="button" value="Mode édition" class="btn btn-outline-primary"/>')
        .on("click", () => {
            editParagraphs(article);
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
deleteArticle = (article) => {
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/articles/' + article.ID,
    }).done(() => {
        emptyParagraphs();
    });
};

postParagraph = (position) => {
    console.log('postParagraph appelé');
    let champ = $(' <div class="form-group">\n' +
        '<textarea class="form-control" rows="5" id="comment"></textarea>\n' +
        '</div> ');
    position.append(champ);
};
