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
    type: null,
    email: null,
    joined: null,
    name: null,
    reputation: null,
    uid: null,
};

Vue.component('lower-rated-item-component', {
    template:'#lower-rated-item',
    mixins:[mixin],
    props:['restaurant'],
});
Vue.component('lower-rated-list-component',{
    template:'#lower-rated-list',
    mixins:[mixin],
    data: function(){
        return {
            lowerRatings: [],
        }
    },
    created: function(){
        this.getPackage('person','lower_staff_rating',data.uid,this.setLowerRatings);
    },
    methods:{
        setLowerRatings: function(result){
            this.lowerRatings = result.payload;
            
        },
    },
});
Vue.component('user-info-component',{
    template:'#user-info',
    mixins:[mixin],
    data: function(){return data;},
});


var wm = new Vue({
    el: '#app',
    data: data,
    mixins: [mixin],
    created: function() {
        var b64  = appData.getAttribute("data");
        var jsn  = atob(b64);
        var obj  = JSON.parse(jsn)[0];
        this.type = obj.type;
        this.type =  obj.type;
        this.email =  obj.email;
        this.joined =  obj.joined;
        this.name =  obj.name;
        this.reputation =  obj.reputation;
        this.uid =  obj.uid;

    },
    computed:{
        
    },
    methods: {

    }
    
});