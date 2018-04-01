/*!
 * (c) 2018 Cédric Clément.
 */
var appData = document.getElementById("app-data");

var mixin = {
    methods: {
        getPackage: function(application, action, data, callback){
            var r = new XMLHttpRequest();
            r.open('POST', '../dispatch/index.php');
            r.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var q = 'application='+application+'&action='+action+'&data='+data;
            // console.log(q);
            r.send(q);
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


Vue.component('highest-rated-component', {
    template:'#highest-rated-list',
    props:['types'],
    mixins:[mixin],
    data:function(){
        return {
            restaurants: [],
            type: this.types[0],
        }
    },
    created: function(){
        this.getPackage('dashboard', 'highest_rated_food', this.type, this.setHighestRated);
    },
    methods: {
        setHighestRated: function(response){
            // console.log(response);
            this.restaurants = response.payload;
        },
        getHighestRated: function(){
            this.getPackage('dashboard', 'highest_rated_food', this.type, this.setHighestRated);
        }
    },
});

var data = {
    rtypes: null,
    ex_e: null,
};

var wm = new Vue({
    el: '#app',
    data: data,
    mixins: [mixin],
    created: function() {
        var b64  = appData.getAttribute("data");
        var jsn  = atob(b64);
        var obj  = JSON.parse(jsn);
        this.rtypes = obj['types'];
        this.ex_e = obj['exercise_e'];
        

    },
    computed:{
        
    },
    methods: {

    }
    
});