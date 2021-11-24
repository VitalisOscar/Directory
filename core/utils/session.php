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
        redirect(ROUTE_SIGNIN);
    }

    /**
     * Start a new user session
     * @param User $user
     */
    static function mustBeLoggedIn(){
        if(!self::loggedIn()){
            redirect(ROUTE_SIGNIN);
        }
    }

    static function loggedIn(){
        return self::getUser() != null;
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
