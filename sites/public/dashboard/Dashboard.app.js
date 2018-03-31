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
    exercise_e: null,
};


var wm = new Vue({
    el: '#app',
    data: data,
    mixins: [mixin],
    created: function() {
        var b64  = appData.getAttribute("data");
        var jsn  = atob(b64);
        var obj  = JSON.parse(jsn);
        this.exercise_e = obj['exercise_e'];

    },
    computed:{
        
    },
    methods: {

    }
    
});