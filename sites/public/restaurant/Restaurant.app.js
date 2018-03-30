/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var mixin = {
    methods: {
        getPackage: function(application, action, data, callback){
            var r = new XMLHttpRequest();
            r.open('POST', '../../dispatch/index.php');
            r.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            r.send('application='+application+'&action='+action+'&data='+data);
            // var self = this;
            r.onload = function(){
                var response = JSON.parse(r.responseText);
                if(response.state == 'success') {
                    callback(response);
                } else {
                    console.error(response);
                }
            };
        },
        getIndex: function(array, attr, value) {
            for(var i = 0; i < array.length; i += 1) {
                if(array[i][attr] === value) {
                    return i;
                }
            }
            return -1;
        },
        printResult(result){
            console.log(result);
        },                
    }
}

var data = {
    name: null,
    type: null,
    url: null,
    phone: null, 
    open_hours: null,
    end_hours: null,
    most_expensive: null,
    rid: null,
    managers: [],
    ratings: [],
    locations: [],
    menu: [],
};

Vue.component('create-menu-item-component', {
    template: '#create-menu-item',
    mixins: [mixin],
    data: function(){
        return {
            name: null,
            type: null,
            category: null,
            price: null,
            comment: null,
        }
    },
    methods: {
        clear: function(){
            this.name       = null,
            this.type       = null,
            this.category   = null,
            this.price      = null,
            this.comment    = null
        },
        newMenuItem: function(){
            var ob      = new Object();
            ob.name     = this.name;
            ob.type     = this.type;
            ob.category = this.category;
            ob.price    = this.price;
            ob.comment  = this.comment;
            ob.rid      = data.rid;
            var package = JSON.stringify(ob);
            wm.getPackage('restaurant', 'new_menu_item', package, wm.addMenuItem);
            this.clear();
        },
    }
});

var wm = new Vue({
    el: '#app',
    data: data,
    mixins: [mixin],
    created: function() {
        var b64  = appData.getAttribute("data");
        var jsn  = atob(b64);
        var r    = JSON.parse(jsn)[0];
        data.name = r.name;
        data.type = r.type;
        data.url  = r.url;
        data.rid  = r.rid;
        
        // get locations
        this.getPackage('restaurant','get_location',data.rid,this.setLocation);
        
        // get manager
        this.getPackage('restaurant','get_manager_info',data.rid,this.setManager);
        
        // get menu
        this.getPackage('restaurant','get_menu',data.rid,this.setMenu);

    },
    methods: {
        printResult(result){
            console.log(result);
        },
        setLocation(response){
            var loc = response.payload;
            for(var i in loc){data.locations.push(loc[i]);}
        },
        setManager(response){
            var m = response.payload;
            for(var i in m){data.managers.push(m[i]);}
        },
        setMenu(response){
            var m = response.payload;
            for(var i in m){data.menu.push(m[i]);}
        },
        addMenuItem(response){
            var m = response.payload;
            data.menu.push(m[0]);
        },
        removeMenuItem: function(mid){
            var i = this.getIndex(data.menu, 'mid', mid.payload);
            data.menu.splice(i, 1);
        },
        deleteMenuItem: function(mid){
            this.getPackage('restaurant', 'delete_menu_item', mid, this.removeMenuItem);
        },

    }
    
});