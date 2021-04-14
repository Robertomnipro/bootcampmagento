console.log('testing');
define([
    'uiComponent',
    'mage/storage',
    'jquery',
    'ko',
], function(Component,storage, $,ko) {
    return Component.extend({
        defaults: {
            textoPrueba: "Texto Prueba",
            variable1: 25,
            blogItems: []
            // blogItems: ko.observableArray([]),
        },
        initialize: function() {
            this._super();
            self=this;
            setTimeout($.proxy(function() {
                this.textoPrueba("Prueba 2");
                console.log(this);
            }, this), 1000);
            let blogs = "/rest/V1/blogs?searchCriteria"
            storage.get(blogs)     
            .done(function (response) {
                console.log(response.items);
                self.blogItems(response.items);
                console.log( self.blogItems);
            });
            return this;
        },
        initObservable: function() {
            this._super()
                .observe([
                    'variable1',
                    'textoPrueba',
                    'blogItems'
                ]);

            return this;
        },
        cambiarVariable: function() {
            this.variable1(0);
        }
    });
});