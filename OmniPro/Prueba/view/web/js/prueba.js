requirejs([
    'jquery',
    'underscore',
    'uiComponent'
], function ($,_,Component) {

    return Component.extend({
        defaults:{
            'variables':'texto 1'
        },
        initialize:function () {
            console.log(this);
            this._super()
                let blog = "rest/V1/blogs?searchCriteria"
                $.ajax({url:blogs}).done(function (response) {
                    console.log(response);
                });
        }
    });

        // return function (config) {
        //     console.log(config{});
        //     let blog = "rest/v1/blog?searchCriteria"
        //     $.ajax({url:blogs}).done(function (response) {
        //         console.log(response);
        //     });
            
        // }

        // $('body').addClass('pruebamagento');
})