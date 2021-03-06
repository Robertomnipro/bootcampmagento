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
            imageBase64: '',
            blogItems: [],
            blogsUrl: 'rest/V1/blogs?searchCriteria',  
            blogPostUrl: 'rest/V1/blogs'  
        }, 
        initialize: function() {
            this._super();
            this.getBlogs();
            this.clearForm();
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
                    'blogItems',
                    'imageBase64'
                ]);

            return this;
        },
        getBlogs: function () {
            storage.get(this.blogsUrl)     
            .then($.proxy(function(data) {
                this.blogItems(data.items);
                console.log(data.items);
            },this));
        },
        clearForm: function () {
            this.image('');
            this.title('');
            this.content('');
            this.email('');
            this.imageBase64('');
        },
        changeImage: function (data, event) {
            var image = event.target.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(image);
            reader.onload = $.proxy(function(e) {
                var base64 = reader.result
                                .replace("data:", "")
                                .replace(/^.+,/, "")
                this.imageBase64(base64);
            },this);
        },
        removeImage: function () {
            $.proxy(function () {
                this.imageBase64('');
                this.image('');
                
            })
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
                    "img": "",
                    "extension_attributes": {
                        "image": {
                                "base64EncodedData": this.imageBase64(),
                                "type": "image/jpeg",
                                "name": "new_image.jpg"
                        }
                    }
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