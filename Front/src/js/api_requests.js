function getArticles() {
    $.getJSON('/api/v1/articles/').done(function (data) {
        let titles = [];
        $(".dropdown-item").remove();
        for (let i in data) {
            titles.push(data[i].TITLE);
            $(".dropdown-menu").append('<a class="dropdown-item" href="#">' + titles[i] + '</a>');
        }
    })
}