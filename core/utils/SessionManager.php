<?php

class SessionManager{

    const USER_SESSION_KEY = 'user';

    /**
     * Start a new user session
     * @param User $user
     */
    static function start($user){
        $_SESSION[self::USER_SESSION_KEY] = $user->getId();
    }

    /**
     * End a user session
     */
    static function signOut(){
        unset($_SESSION[self::USER_SESSION_KEY]);

        $route = ROUTE_SIGNIN;

        if(isAdminContext()){
            $route = ROUTE_ADMIN_SIGNIN;
        }

        redirect($route);
    }

    /**
     * Start a new user session
     */
    static function mustBeLoggedIn(){
        $route = ROUTE_SIGNIN;
        if(isAdminContext()){
            $route = ROUTE_ADMIN_SIGNIN;
        }

        $as_admin = false;
        if(isAdminContext()){
            $as_admin = true;
        }

        if(!self::loggedIn($as_admin)){
            redirect(url($route, ['return' => currentUrl()]));
        }
    }

    static function loggedIn($as_admin = false){
        $user = self::getUser();

        if($user == null){
            return false;
        }

        if($as_admin){
            return $user->isAdmin();
        }

        return true;
    }

    /**
     * Get currently authenticated user
     * @return User|null
     */
    static function getUser(){
        $user_id = $_SESSION[self::USER_SESSION_KEY] ?? null;

        if($user_id == null) return null;

        $sql = "SELECT * FROM `users` WHERE `id` = $user_id LIMIT 1";
        $result = db()->query($sql);
        $user_data = $result->fetch_assoc();

        return $user_data == null ? null : User::fromArray($user_data);
    }

}
