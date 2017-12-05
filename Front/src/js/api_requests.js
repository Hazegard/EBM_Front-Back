getArticles = () => {
    $.getJSON('/api/v1/articles/').done(function (data) {
        $(".dropdown-item").remove();
        console.log(data); // TODO : À enlever plus tard
        for (let i in data) {
            let item = $('<a class="dropdown-item">' + data[i].TITLE + '</a>')
                .on("click", function () {
                    displayParagraphs($(this).data('article').TITLE, $(this).data('article').CONTENT);
                })
                .data("article", data[i]);
            $("#listeArticles").append(item)
        }
    })
};

emptyParagraphs = () => {
    let item = $('<p>Sélectionnez un article...</p>');
    $('#paragraphs').empty().append(item);
};

displayParagraphs = (title, paragraphs) => {
    let item = $('<div class="container"><h1 class="display-4">' + title + '</h1><hr class="my-2">');
    paragraphs.map(para => item.append('<p class="lead text-justify">' + para.CONTENT + '</p>'));
    $('#paragraphs').empty().append(item);
};