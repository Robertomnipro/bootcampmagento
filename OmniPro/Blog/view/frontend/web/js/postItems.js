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
            this.getBlogs();
            this.title.subscribe(function (value) {
                console.log(value );
            },this);
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
        sendBlog: function() {
            var blog = {
                'blog': {
                    "title": this.title(),
                    "email": this.email(),
                    "content": this.content(),
                    "img": this.image()
                }
            };
            storage.post(this.blogPostUrl, JSON.stringify(blog))
            .then($.proxy(function() {
                this.getBlogs();
            }, this));
        },
    });
});