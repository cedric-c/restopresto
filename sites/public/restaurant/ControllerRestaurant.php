<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerRestaurant extends Controller {

    const GET_LOCATION          = 'get_location';  // a2
    const GET_MENU              = 'get_menu';      // c1 d2
    const GET_MOST_EXPENSIVE    = 'get_expensive'; // d1
    
    const INSERT_REVIEW         = 'create_review';
    const DELETE                = 'delete';
    const GET_HIGHEST_RATERS    = 'get_high_raters';
    

    /**
     * The location for all the app's files.
     */
    public function getAppDir(): string {
        return 'restaurant';
    }
    
    /**
     * The print friendly version of the app name.
     */
    public function getAppName(): string {
        return 'Restaurant Details';
    }
    
    /**
     * The name of the JS file.
     */
    public function getAppFileName(): string {
        return 'restaurant';
    }
    
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        $model = new Restaurant();
        Response::add('from','restaurant');
        if($action == self::GET_LOCATION){
            Response::add('payload', $data);
            Response::add('thiswasaction','action');
            try {
                Response::add('state','success');
            } catch (PDOException $e){
                Response::add('state','error');
                Response::add('message', $e->getMessage());
            }
        } else if ($action == self::INSERT) {
            $id = (int) $model->getNextId();
            $name = $data['name'];
            $type = $data['type'];
            $url  = $data['url'];
            // echo 'nextid: ',$id;
            $result = $model->insert($id, $name, $type, $url);
            if ($result == 1){
                $newResto = $model->get($id);
                Response::add('payload', $newResto);
                Response::add('state', 'success');
            } else {
                Response::add('state', 'error');
                Response::add('message', 'Could not create restaurant');
            }
        } else if ($action == self::GET_MENU) {
            $menuModel  = new MenuItem();
            $result     = $menuModel->getKeyValue('rid', $data);
            Response::add('payload', $result);
            Response::add('state', 'success');
        
        } else if ($action == self::GET_ALL_RESTAURANTS) {
            $data       = $model->getAll();
            Response::add('payload', $data);
            Response::add('state', 'success');
        
        // } else if ($action == self::GET_LOCATION) {
            // Response::add('state', 'success');
            // Response::add('message','UNIMPLEMENTED');
        
        // } else if ($action == self::GET_LOCATION) {
            // Response::add('state', 'success');
            // Response::add('message','UNIMPLEMENTED');
        
        } else if ($action == self::GET_UNRATED) {
            $result         = $model->getUnrated();
            Response::add('payload',$result);
            Response::add('state', 'success');
        } else {
            Response::add('state', 'error');
            Response::add('message', 'Unknown command');
        }
        Response::send();
    }
    
}