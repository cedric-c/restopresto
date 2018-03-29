<?php 
    /**
     * @author Cédric Clément <cclem054@uottawa.ca>
     * @version 1.0
     * @since 1.0
     * (c) Copyright 2018 Cédric Clément.
     */
    $appName = $this->getController()->getAppName();
    $data    = base64_encode($this->getModel()->jsonSerialize());
    $n       = $this->getController()->getAppDir();
    $m       = $this->getController()->getAppFileName();
    $path    =  $n . '/' . $m . '.app.js' ;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="/static/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/static/css/styles.css">
        <link rel="stylesheet" type="text/css" href="/static/css/bootstrap.css">

        <meta charset = "UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $appName ;?></title>
    </head>
    <body>
        <div class="masthead">
            <div class="container">
                <h1><?php echo $appName ;?></h1>
            </div>
        </div>
        <div id="app" class="container">
            <header>
            <div id="app-data" style="display: none;" data="<?php echo $data;?>"></div>
            </header>
            <div id="main_content">
              <div class="row">
                <div class="container">
                  <div v-cloak class="container pdb15 restoinfo">
                    <div class="row">
                      <div class="col-xs-6"><h2>{{name}}</h2></div>
                    </div>
                    <div class="row">
                      <div class="col-xs-6"><a class="actionButton" :href="url"><i class="fa fa-link fa-3x"></i></a></div>
                      <div class="col-xs-12 restoinfo">
                        <p><b>Type</b>: {{type}}</p>
                        <p><b>Url</b>: {{url}}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-4">
                        <h3>Managers</h3>
                        <ul><transition-group name="list">
                        <div class="row menuObject" v-for="(o, index) in managers" :key="o.uid">
                          <div>
                            <b>Name</b>: {{o.name}}<br> 
                            <b>Email</b>: {{o.email}}<br> 
                            <b>Joined</b>: {{o.joined}}<br> 
                            <b>Rep</b>: {{o.reputation}}<br>
                            <b>Type</b>: {{o.type}}<br>
                            <br>
                          </div>
                        </div>
                      </transition-group></ul></div>
                      <div class="col-xs-4">
                        <h3>Locations</h3>
                        <ul><transition-group name="list">
                        <div class="row menuObject" v-for="(o, index) in locations" :key="o.lid">
                          <div>
                            <b>Open</b>: {{o.hour_start}}<br> 
                            <b>Close</b>: {{o.hour_end}}<br> 
                            <b>Address</b>: {{o.address}}<br> 
                            <b>Opened</b>: {{o.opened}}<br>
                            <b>Phone</b>: {{o.phone}}<br>
                            <br>
                          </div>
                        </div>
                      </transition-group></ul></div>
                      <div class="col-xs-4">
                        <h3>Menu</h3>                        
                        <ul><transition-group name="list">
                        <div class="row menuObject" v-for="(o, index) in menu" :key="o.mid">
                          <div>
                            <b>Name</b>: {{o.name}}<br> 
                            <b>Category</b>: {{o.category}}<br> 
                            <b>Type</b>: {{o.type}}<br> 
                            <b>Price</b>: {{o.price}}<br>
                            <b>Description</b>: {{o.description}}<br>
                          </div>
                        </div>
                      </transition-group></ul></div>
                    </div>
                  </div>
              </div>
              </div>
            </div>
        </div>

    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
