<?php


namespace utils;


use http\Cookie;

class SessionHelpers
{
    public function __construct()
    {
        SessionHelpers::init();
    }

    static function init(): void
    {
        session_start();
    }

    static function login(mixed $user): void
    {
        $_SESSION['LOGIN'] = $user;
    }

    static function logout(): void
    {
        unset($_SESSION['LOGIN']);
    }

    static function getConnected(): mixed
    {
        if (SessionHelpers::isLogin()) {
            return $_SESSION['LOGIN'];
        } else {
            return false;
        }
    }

    static function isLogin(): bool
    {
        return isset($_SESSION['LOGIN']);
    }

    static function setLogin($newName,$newPname,$newDateN,$newEmail,$newTel): void
    {
        $_SESSION['LOGIN']->nomemprunteur=$newName;
        $_SESSION['LOGIN']->prenomemprunteur=$newPname;
        $_SESSION['LOGIN']->datenaissance=$newDateN;
        $_SESSION['LOGIN']->emailemprunteur=$newEmail;
        $_SESSION['LOGIN']->telportable=$newTel;
    }


    public static function isConnected(): bool
    {
        return SessionHelpers::isLogin();
    }

    static function NBRETARD( int $nb): void
    {
        $_SESSION['NBRETARD'] = $nb;
    }

}