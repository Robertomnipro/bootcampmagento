console.log('log test');
requirejs([
    'jquery',
    'underscore'
], function ($,_) {
        return function (config) {
            console.log(config);
            let blog = "rest/v1/blog?searchCriteria"
            $.ajax({url:blogs}).done(function (response) {
                console.log(response);
            });
            
        }
        // $('body').addClass('pruebamagento');
})