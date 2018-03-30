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
    const GET_MANAGER_INFO      = 'get_manager_info';
    const NEW_MENU_ITEM         = 'new_menu_item';
    const DELETE_MENU_ITEM      = 'delete_menu_item';
    
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
        if($action == self::GET_LOCATION){
            $loc = new Location();
            try {
                $location = $loc->getKeyValue('rid',$data);
                Response::add('state','success');
                Response::add('payload', $location);
            } catch (PDOException $e){
                Response::error($e);
            }

        } else if ($action == self::GET_MENU) {
            $menuModel  = new MenuItem();
            $result     = $menuModel->getKeyValue('rid', $data);
            Response::add('payload', $result);
            Response::add('state', 'success');
        } else if ($action == self::DELETE_MENU_ITEM) {
            try{
                $model  = new MenuItem();
                $result = $model->delete($data);
                Response::add('payload', $data);
                Response::add('state', 'success');
            } catch (Exception $e){
                Response::error($e);
            }
        } else if ($action == self::GET_MANAGER_INFO) {
            try{
                $loc        = new Location();
                $location   = $loc->getKeyValue('rid', $data);
                $mid        = $location[0]['manager'];
                $mngr       = new Person();
                $manager    = $mngr->getKeyValue('uid', $mid);
                Response::add('payload', $manager);
                Response::add('state', 'success');
            } catch (Exception $e) {
                Response::error($e);
            }
            
        } else if ($action == self::NEW_MENU_ITEM) {
            try{
                $model = new MenuItem();
                $id = (int) $model->getNextId();
                $n  = $data['name'];
                $t  = $data['type'];
                $c  = $data['category'];
                $p  = $data['price'];
                $co = $data['comment'];
                $ri = (string) $data['rid'];
                $result = $model->insert($id, $n, $t, $c, $p, $co, $ri);
                if($result == 1){
                    $newMenuItem = $model->get($id);
                    // var_dump($newMenuItem);
                    Response::add('payload', $newMenuItem);
                    Response::add('state', 'success');
                } else {
                    Response::add('state', 'error');
                    Response::add('message', 'Could not create menu item');
                }
            } catch (Exception $e) {
                Response::error($e);
            }
        } else {
            Response::add('state', 'error');
            Response::add('message', 'Unknown command');
        }
        Response::send();
            
    }
    
}