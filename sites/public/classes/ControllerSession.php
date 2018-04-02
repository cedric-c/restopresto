<?php declare(strict_types=1);
/**
 * @author Cédric Clément <cclem054@uottawa.ca>
 * @version 1.0
 * @since 1.0
 * (c) Copyright 2018 Cédric Clément.
 */
class ControllerSession extends Controller {

    const REGISTER      = 'register';
    const LOGIN         = 'login';
    const LOGOUT        = 'logout';
    const IS_ACTIVE     = 'active';
    /**
     * The location for all the app's files.
     */
    public function getAppDir(): string {
        return '';
    }
    
    /**
     * The print friendly version of the app name.
     */
    public function getAppName(): string {
        return '';
    }
    
    /**
     * The name of the JS file.
     */
    public function getAppFileName(): string {
        return '';
    }
    
    public static function startSession(int $userId): void {
        session_start();
        $_SESSION['uid'] = $userId;
    }
    
    public static function getSession(): array {
        session_start();
        return $_SESSION;
    }
    
    public static function getUserId(): int {
        if(!self::isActive())
            return -1;
        
        $s = self::getSession();
        return $s['uid'];
    }
    
    public static function isActive(): bool {
        session_start();
        return $_SESSION != [];
    }
    
    public static function killSession(): void {
        session_start();
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        
    }
    
    public function processPost(array $post): void {
        $data = json_decode($post['data'], true);
        $action = $post['action'];
        $model = new Person();
        
        if($action == self::LOGIN){
            $email        = $data['email'];
            $userRecord   = $model->getKeyValue('email', $email)[0];
            $uid          = $userRecord['uid'];
            $recordedPW   = $userRecord['password'];
            $pw           = $data['password'];
            $userPW = Person::getHashed($pw);
            $samePw = hash_equals($recordedPW, $userPW);
            if(($uid != null) && ($samePw)){// and email is valid
                self::startSession($uid);
                Response::add('state', 'success');
                
            } else {
                Response::add('state', 'error');
                Response::add('message', 'could not locate user with that email');
            }
            
        } else if($action == self::REGISTER){
            // currently an issue w.r.t logins as emails should be unique, but there is no constraint for them to be so
            // also, should check that email DNE
            $newId = (int) $model->getNextId();
            $pw    = $data['password'];
            $email = $data['email'];
            $name  = $data['name'];
            $type  = $data['type'];
            $rep   = '1';
            // this is buggy, can cause problems, place in try-catch
            $result = $model->insert($newId, $name, $pw, $email, $type, $rep);
            if($result == 1){
                $user = $model->get($newId);
                self::startSession($newId);
                Response::add('state', 'success');
                Response::add('message', 'creating session');
            } else {
                Response::add('state', 'error');
                Response::add('message', 'could not register user');
            }
            
            Response::add('state', 'success');

        } else if ($action == self::LOGOUT){

            $this->killSession();
            Response::add('state', 'success');
            Response::add('message', 'Successfully logged out');

        } else if ($action == self::IS_ACTIVE){
            $s = self::isActive();
            Response::add('state', 'success');
            Response::add('payload', $s);
        } else {
            Response::add('state', 'error');
            Response::add('message', 'Unknown command');
        }
        Response::send();
    }
    
}