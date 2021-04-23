console.log('testing');
define([
    'uiComponent',
    'mage/storage',
    'jquery',
    'ko',
], function(Component,storage, $,ko) {
    return Component.extend({
        defaults: {
            title:'',
            content:'',
            email:'',
            image:'', 
            blogItems: [],
            blogsUrl: 'rest/V1/blogs?searchCriteria',  
            blogPostUrl: 'rest/V1/blogs'  
        }, 
        initialize: function() {
            this._super();
            self=this;
            this.title.subscribe(function (value) {
                console.log(value );
            },this);
            // let blogs = "/rest/V1/blogs?searchCriteria"
            // storage.get(blogs)     
            // .done(function (response) {
            //     console.log(response.items);
            //     self.blogItems(response.items);
            //     console.log( self.blogItems); 
            // });
            return this;
        },
        initObservable: function() {
            this._super()
                .observe([
                    'title',
                    'content',
                    'email',
                    'image', 
                    'blogItems'
                ]);

            return this;
        },

        getBlogs: function () {
            storage.get(this.blogsUrl)     
            .then($.proxy(function(data) {
                this.blogItems(data.items);
            },this));
        },
    });
});