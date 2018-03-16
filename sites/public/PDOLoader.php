<?php
class PDOLoader extends PDO {
    public function __construct($file) {
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('Unable to open ' . $file . '.');

        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['db_name'];
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}