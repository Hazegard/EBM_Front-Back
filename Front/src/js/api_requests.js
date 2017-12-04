function getArticlesJSON() {
    return $.getJSON('/api/v1/articles/')
}

function getArticles() {
    getArticlesJSON().done(function (data) {
        let titles = [];
        for (let i in data) {
            titles.push(data[i].TITLE);
        }
        console.log(titles);
        console.log(data);
    })
}