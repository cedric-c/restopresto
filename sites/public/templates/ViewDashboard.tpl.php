<?php 
    /**
     * @author Cédric Clément <cclem054@uottawa.ca>
     * @version 1.0
     * @since 1.0
     * (c) Copyright 2018 Cédric Clément.
     */
    $appName = $this->getApp()->getName();
    $render  = $this->getApp()->render();
    $data    = base64_encode(json_encode($this->getApp()->getData()));
    $n       = $this->getApp()->getDir();
    $path    =  $n . '/' . $n . '.app.js' ;
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
              
              
              
              
              <!-- EXERCISE E START -->
              <div class="row">
                <div class="col-xs-12">
                  <div class="panel panel-default">
                    <div class="panel-heading"><h2 class="panel-title">Average Menu Items by Categories and Restaurant Types</h2></div>
                    <div class="panel-body">
                    <ul>
                      <transition-group name="list">
                        <div class="row menuObject reviews" v-for="(o, index) in exercise_e.data" :key="index">
                          <div v-cloak>
                              <b>Category</b>: {{o.category}}<br> 
                              <b>Type</b>: {{o.type}}<br> 
                              <b>Average</b>: {{o.average}}<br>                           
                          </div>
                        </div>
                      </transition-group>
                    </ul>
                  </div>
                  </div>
                </div>
              </div>
              <!-- EXERCISE E END -->              
              
              <div class="row"></div>
            
            </div>
        </div>

    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
