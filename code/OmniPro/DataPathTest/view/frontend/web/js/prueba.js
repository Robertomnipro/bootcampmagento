requirejs([
    'jquery',
    'underscore',
    'ko',
    'uiComponent',
    'mage/storage',
    'mage/url',
], function ($,_,ko,Component, url, storage) {

    return Component.extend({
        defaults:{
            blogs:ko.observableArray([]),
            template: 'OmniPro_DataPathTest/blog',
            ignotreTmpls: {
                template: false
            }
           
        },
        initialize:function () {
            this._super();
            console.log(this);
            console.log(this.variable());
            this.variable.subscribe(function (value) {
                console.log(value);
            });
            let self = this;
            let blogs = "rest/V1/blogs?searchCriteria"
            storage.get(blogs)
            // $.ajax({
            //     url:blogs
            // })
            .done(function (response) {
                self.blogs(response.items);
                console.log(self.blogs());
            });
            return this;
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