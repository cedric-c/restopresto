<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerRestaurantRoaster extends Controller {

    const INSERT                = 'create';
    const DELETE                = 'delete';
    const GET_MENU              = 'list_menu';
    const GET_LOCATION          = 'get_location';
    const GET_HIGHEST_RATERS    = 'get_high_raters';
    const GET_ALL_RESTAURANTS   = 'get_all_restaurants';
    const GET_UNRATED           = 'get_unrated_restaurants';


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
        return 'Restaurant List';
    }
    
    /**
     * The name of the JS file.
     */
    public function getAppFileName(): string {
        return 'restaurant-roaster';
    }
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        $model = new Restaurant();
        
        if($action == self::DELETE){
            Response::add('payload', $data);
            try {
                $result = $model->delete($data);
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