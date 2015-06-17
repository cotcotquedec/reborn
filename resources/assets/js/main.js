/**
 *
 * Remplie un select a partir d'un requete json
 *
 */
jQuery.fn.loadSelect = function (url, data, callback) {
    var e = this;
    jQuery.post(url,data,
        function(d){
            if (typeof(d) !== 'object') {
                d = jQuery.parseJSON(d);
            }
            e.empty();
            jQuery.each(d, function(i,o){e.append(new Option(o,i));});

            if (typeof(callback) === "function") {
                (callback)();
            }
        }
    );
};