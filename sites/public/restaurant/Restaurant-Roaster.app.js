/*!
 * (c) 2018 Cédric Clément.
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
        createResto: function (resto){
            var r = new Object();
            var newResto = wm.createResto(resto[0]);
            data.restaurants.push(newResto);
            this.clear();
        },
        clear: function(){
            this.name = '',
            this.type = '',
            this.url  = ''
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
            request.send('application=restaurant-roaster&action=create&'+'data='+d);
            request.onload = function(){
                var state = request.responseText;
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    var resto = response.payload;
                    self.createResto(resto);
                } else {
                    console.log('while trying to create resto');
                }
            };
        },
    },
    template: '#create-resto'
});

Vue.component('resto-chooser-component', {
   props:['data'],
   template: '#resto-chooser',
   data: function(){
    return {
        all:true,
        unrated:false,
        other:false,
    }
   },
   methods: {
    untoggle: function(){
        this.all = false;
        this.unrated = false;
    },
    toggleAll: function(){
        this.untoggle();
        this.all = !this.all;
        if(this.all){
            this.getAll();
        }
    },
    toggleUnrated: function(){
        this.untoggle();
        this.unrated = !this.unrated;
        if(this.unrated){
            this.getUnrated();
        }
    },
    getUnrated: function(){
        var request = new XMLHttpRequest()
        request.open("POST", '../dispatch/index.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('application=restaurant-roaster&action=get_unrated_restaurants&'+'data=null');
        var self = this;
        request.onload = function(){
            var response = JSON.parse(request.responseText);
            if (response.state == 'success') {
                wm.replaceRestaurants(response.payload);
            } else {
                console.log('an error occured');
            }
        };            
    },
    getAll: function(){
        var request = new XMLHttpRequest()
        request.open("POST", '../dispatch/index.php');
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send('application=restaurant-roaster&action=get_all_restaurants&'+'data=null');
        var self = this;
        request.onload = function(){
            var response = JSON.parse(request.responseText);
            if (response.state == 'success') {
                wm.replaceRestaurants(response.payload);
            } else {
                console.log('an error occured');
            }
        };            
        
    },
   },
});

Vue.component('resto-component', {
    props:['data'],
    template: '#resto',
    methods: {
        deleteResto: function (){
            this.$emit('remove-resto');
        },
        remove: function() {
            var request = new XMLHttpRequest()
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send('application=restaurant-roaster&action=delete&'+'data='+this.data.rid);
            var self = this;
            request.onload = function(){
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    self.deleteResto();
                } else {
                    console.log(response.message);
                }
            };
        },
        setMenu: function(m){
            for(var i in m){
                this.data.menu.push(m[i]);
            }
        },
        getMenu: function(){
            if(this.data.menu.length > 0){
                this.data.menu = [];
                return;
            }
            var request = new XMLHttpRequest()
            request.open("POST", '../dispatch/index.php');
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send('application=restaurant-roaster&action=list_menu&'+'data='+this.data.rid);
            var self = this;
            request.onload = function(){
                var response = JSON.parse(request.responseText);
                if (response.state == 'success') {
                    self.setMenu(response.payload);
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
        var r = this.injectProperties(parsed);
        data.restaurants = r;
    },
    methods: {
        addChild: function(child) {
            data.restaurants.push(child);
        },
        createResto: function(data){
            var resto       = new Object();
            resto.rid       = data.rid;
            resto.name      = data.name;
            resto.type      = data.type;
            resto.url       = data.url;
            resto.phone     = data.phone;
            resto.restopage = "/restaurant/id/index.php?id=" + resto.rid;
            resto.menu      = [];
            resto.ratings   = [];
            resto.locations = [];
            return resto;
            
        },
        injectProperties: function(restos) {
            var ret = [];
            for(var i in restos){
                var r = this.createResto(restos[i]);
                ret.push(r);
            }
            return ret;
        },
        clearRestaurants: function(){
            while (data.restaurants.length > 0){
                data.restaurants.pop();
            }
        },
        replaceRestaurants: function(restos) {
            this.clearRestaurants();
            for(var i in restos){
                var r = this.createResto(restos[i]);
                data.restaurants.push(r);
            }
        },
    }
    
});