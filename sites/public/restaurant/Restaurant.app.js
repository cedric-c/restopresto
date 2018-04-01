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
    rater_counts: [],
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

Vue.component('create-rating-item-component', {
    template: '#create-rating-item',
    mixins: [mixin],
    data: function(){
        return {
            price: null,
            food: null,
            mood: null,
            staff: null,
            comment: null
        }
    },
    methods: {
        clear: function(){
            this.price  = null,
            this.food   = null,
            this.mood   = null,
            this.staff  = null,
            this.comment    = null            
        },
        newRatingItem: function(){
            var ob = new Object();
            ob.price   = this.price;
            ob.food    = this.food;
            ob.mood    = this.mood;
            ob.staff   = this.staff;
            ob.comment = this.comment;
            ob.rid     = data.rid;
            var package = JSON.stringify(ob);
            wm.getPackage('restaurant', 'create_review', package, wm.addRatingItem);
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
        
        // most expensive
        this.getPackage('restaurant', 'get_most_expensive', data.rid, this.setMostExpensive);
        
        // get ratings
        this.getPackage('restaurant', 'get_ratings', data.rid, this.setRatings);
        
        // get rating counts
        this.getPackage('restaurant', 'get_rating_counts', data.rid, this.setRaterCounts);

    },
    computed:{
        // the query is implemented in PHP/SQL but also in Javascript (because we don't want to have to reload the page)
        mostExpensive(){
            if (this.menu.length == 0) return;
            var pricy = this.menu.reduce((a,b) => Number(a.price) > Number(b.price) ? a : b);
            return pricy.name;
        },
    },
    methods: {
        printResult(result){
            console.log(result);
        },
        setLocation(response){
            var loc = response.payload;
            for(var i in loc){data.locations.push(loc[i]);}
        },
        setMostExpensive(response){
            var me = response.payload[0];
            this.most_expensive = me;
        },
        setManager(response){
            var m = response.payload;
            for(var i in m){data.managers.push(m[i]);}
        },
        setMenu(response){
            var m = response.payload;
            for(var i in m){data.menu.push(m[i]);}
        },
        setRatings(response){
            var m = response.payload;
            for(var i in m){
                var o = m[i];
                var i = this.createRatingItem(o);
                data.ratings.push(i);
            }
        },
        setRaterCounts(response){
            var m = response.payload;
            for(var i in m){data.rater_counts.push(m[i]);}
        },
        addMenuItem(response){
            var m = response.payload;
            data.menu.push(m[0]);
        },
        addRatingItem(response){
            var m = response.payload;
            data.ratings.push(this.createRatingItem(m[0]));
        },
        createRatingItem(item){
            var o = item;
            o.comment = item.comment;
            o.date_rated = item.date_rated;
            o.food = item.food;
            o.mood = item.mood;
            o.name = item.name;
            o.price = item.price;
            o.rid = item.rid;
            o.staff = item.staff;
            o.uid = item.uid;
            o.key = item.date_rated + '_' + item.uid;
            return o;
            
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