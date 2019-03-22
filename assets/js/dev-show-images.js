window.addEventListener("load", function() {
    // for plugin Ajax Load More
    almComplete = function (alm) {
        dsi();
    };

    dsi();
});

function dsi() {
    var currentUrl = location.protocol + '//' + location.host;
    var prodUrl = productionServerUrl.url;

    var images = document.querySelectorAll('img');
    [].forEach.call(images, function(img) {
        if (img.src.includes(currentUrl)) {
            var checkImg = new Image();
            checkImg.src = img.src;
            if (checkImg.height === 0) {
                img.src = img.src.replace(currentUrl, prodUrl);
                if (img.srcset !== "") {
                    img.srcset = img.srcset.replace(currentUrl, prodUrl);
                }
            }
        }
    });
}