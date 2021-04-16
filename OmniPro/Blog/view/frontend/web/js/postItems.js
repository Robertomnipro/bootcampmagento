console.log('testing');
define([
    'uiComponent',
    'mage/storage',
    'jquery',
    'mage/url',
    'mage/validation'
], function(Component,storage, $,url) {
    url.setBaseUrl(window.BASE_URL);
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
        clearForm: function () {
            this.image('');
            this.title('');
            this.content('');
            this.email('');
        },
        isFormValid: function (form) {
            return $(form).validation() && $(form).validation('isValid');
        },
        sendBlog: function() {
            if(!this.isFormValid('.form_post')){
                return
            }
          
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
                this.clearForm();
            }, this));
        },
    });
});