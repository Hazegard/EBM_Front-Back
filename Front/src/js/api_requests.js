function getArticles() {
    $.getJSON('/api/v1/articles/').done(function (data) {
        $(".dropdown-item").remove();
        for (let i in data) {
            let item = $('<a class="dropdown-item">' + data[i].TITLE + '</a>')
                .on("click", function () {
                console.log($(this).data('article'))
            })
                .data("article", data[i]);
            $("#listeArticles").append(item)
        }
        console.log(data);
    })
}
