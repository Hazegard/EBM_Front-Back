function getArticles() {
    $.getJSON('/api/v1/articles/').done(function (data) {
        $(".dropdown-item").remove();
        for (let i in data) {
            $("#listeArticles").append('<a class="dropdown-item" onclick="">' + data[i].TITLE + '</a>');
        }
        console.log(data);
    })
}
