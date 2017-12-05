getArticles = () => {
    $.getJSON('/api/v1/articles/').done(function (data) {
        $(".dropdown-item").remove();
        for (let i in data) {
            let item = $('<a class="dropdown-item">' + data[i].TITLE + '</a>')
                .on("click", function () {
                    console.log($(this).data('article')); // TODO: À enlever quand on aura fini
                    displayParagraphs($(this).data('article').TITLE, $(this).data('article').CONTENT);
                })
                .data("article", data[i]);
            $("#listeArticles").append(item)
        }
    })
};

displayParagraphs = (title, paragraphs) => {
    let item = $('<div class="container"><h1 class="display-3">' + title + '</h1><hr class="my-2">');
    paragraphs.map(para => item.append('<p class="lead">' + para.CONTENT + '</p>'));
    $('#paragraphs').empty().append(item);
};
