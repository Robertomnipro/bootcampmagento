define([
    'jquery', 'slick'
], function ($) {
    "use strict";
    return function (config, element) {
        let defaultConfig = {
            infinite: true,
            slidesToShow: 4,
            speed: 300,
            autoplay: true,
            arrows: false,
            dots: false,
            responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
        };
        $(element).slick($.extend({}, defaultConfig, config));
    };
});
