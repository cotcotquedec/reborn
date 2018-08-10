// IMDB
(function (d, s, id) {
    var js, stags = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "/rating.min.js";
    stags.parentNode.insertBefore(js, stags);
})(document, 'script', 'imdb-rating-api');

