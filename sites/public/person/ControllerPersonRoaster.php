<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerPersonRoaster extends Controller {

    const INSERT_USER = 'create_user';
    const DELETE_USER = 'delete_user';
    const GET_HIGHEST_RATERS_FOOD_AND_MOOD = 'highest_raters_food_and_mood';
    const GET_HIGHEST_RATERS_FOOD_OR_MOOD  = 'highest_raters_food_or_mood';

    /**
     * The location for all the app's files.
     */
    public function getAppDir(): string {
        return 'person';
    }
    
    /**
     * The print friendly version of the app name.
     */
    public function getAppName(): string {
        return 'Users';
    }
    
    /**
     * The name of the JS file.
     */
    public function getAppFileName(): string {
        return 'PersonRoaster';
    }
    
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        $model = new Person();
        // var_dump($model);
        try{
            
            if($action == self::INSERT_USER){
                // $model = new Person();
                $id = (int) $model->getNextId();
                $n = $data['name'];
                $e = $data['email'];
                $t = $data['type'];
                $r = $data['reputation'];
                $pw = '';
                $result = $model->insert($id, $n, $pw, $e, $t, $r);
                if($result == 1){
                    $user = $model->get($id);
                    Response::add('state', 'success');
                    Response::add('payload', $user);
                } else {
                    Response::add('state', 'error');
                    Response::add('message', 'could not create user');
                }
            } else if ($action == self::DELETE_USER) {
                Response::add('payload', $data);
                try{
                    $result = $model->delete($data);
                    Response::add('state', 'success');
                } catch (PDOException $pdo){
                    // Response::add('state', 'error');
                    Response::error($pdo);
                }
            } else if ($action == self::GET_HIGHEST_RATERS_FOOD_OR_MOOD) {
                $d = $model->getHighestFoodOrMood();
                Response::add('state', 'success');
                Response::add('payload', $d);
            } else if ($action == self::GET_HIGHEST_RATERS_FOOD_AND_MOOD) {
                $d = $model->getHighestFoodAndMood();
                Response::add('state', 'success');
                Response::add('payload', $d);
                
            } else {
                Response::add('message', 'Received unidentified action');
            }
        } catch(Exception $e){
            Response::error($e);
        }
        
        Response::send();
            
    }
    
}