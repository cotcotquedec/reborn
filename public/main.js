(function (d, s, id) {
    var js, stags = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://ia.media-imdb.com/images/G/01/imdb/plugins/rating/js/rating.js";
    stags.parentNode.insertBefore(js, stags);
})(document, 'script', 'imdb-rating-api');