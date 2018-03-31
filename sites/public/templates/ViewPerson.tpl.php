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
              
              
            </div>
        </div>

    </body>
    <footer>
        <script src="/static/js/vue.js" type="text/javascript"></script>
        <script src="/static/js/bootstrap-native.min.js" type="text/javascript"></script>
        <script src="/<?php echo $path;?>" type="text/javascript"></script>
    </footer>
</html>
