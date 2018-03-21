/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 *
 * NOTE: PLACE ALL COMPONENTS ABOVE THE VUE DECLARATION.
 *
 */
var appData = document.getElementById("app-data");

var data = {
    restaurants: [],
    name: '',
    type: '',
    url: '',
};

Vue.component('create-resto-component', {
    data: function(){
        return data;
    },
    methods: {
        print:function(v){
            console.log(v);
        },
        post: function(){
            var request = new XMLHttpRequest()
            var self = this;
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var n = data.name;
            var t = data.type;
            var u = data.url;
            var o = new Object();
            o.name = data.name;
            o.type = data.type;
            o.url  = data.url;
            var d = JSON.stringify(o);
            request.send('application=restaurant&action=create&'+'data='+d);
            request.onload = function(){
                var state = request.responseText;
                if (state == 'success') {
                    console.log('created item');
                } else {
                    console.log('an error occured');
                }
            };
        },
    },
    template: '#create-resto'
});

Vue.component('resto-component', {
    props:['data'],
    template: '#resto',
    methods: {
        deleteResto: function (){
            console.log('dete resto from resto component');
            this.$emit('remove-resto');
        },
        remove: function() {
            var request = new XMLHttpRequest()
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send('application=restaurant&action=delete&'+'data='+this.data.rid);
            var self = this;
            request.onload = function(){
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    console.log('deleted item');
                    self.deleteResto();
                } else {
                    console.log('an error occured');
                }
            };
        },
    },
});

Vue.component('main-restaurant-component',{
    data: function(){
        return data;
    },
    template: '#resto-list',
    methods: {
        removeChild: function(index) {
            console.log('removing child ' + index);
            data.restaurants.splice(index, 1);
        },
    }
});

var wm = new Vue({
    el: '#app',
    data: data,
    created: function() {
        var b64     = appData.getAttribute("data");
        var jsn     = atob(b64);
        var parsed  = JSON.parse(jsn);
        data.restaurants = parsed;
    },
});