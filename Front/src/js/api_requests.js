const defaultItem = $('#paragraphs').children();

getArticles = () => {
    $.getJSON('/api/v1/articles').done(function (data) {
        $(".dropdown-item").remove();
        console.log(data); // TODO : À enlever plus tard
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

displayParagraphs = (article) => {
    let deleteButton = $('<input type="button" value="Supprimer" id="deleteArticleBtn" class="btn btn-outline-danger"/>')
        .on("click", () => {
            deleteArticle(article);
        });
    let item = $('<div class="container"><h1 class="display-4">' + article.TITLE + '</h1>' +
        '<hr class="my-2"></div>');
    article.CONTENT.map(para => item.append('<p class="lead text-justify">' + para.CONTENT + '</p>'));
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

deleteArticle = (article) => {
    $.ajax({
        type: 'DELETE',
        url: '/api/v1/articles/' + article.ID,
    }).done(() => {
        emptyParagraphs();
    });
};
