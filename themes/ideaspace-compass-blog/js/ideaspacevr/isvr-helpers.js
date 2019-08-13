function ready (callback) {

    if (document.readyState !== 'loading') {

        // in case the document is already rendered
        callback();

    } else if (document.addEventListener) {

        // modern browsers
        document.addEventListener('DOMContentLoaded', callback);

    } else document.attachEvent('onreadystatechange', function() {

        // IE <= 8
        if (document.readyState == 'complete') {
						callback();
				}
    });
}


