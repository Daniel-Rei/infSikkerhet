<?php

namespace ttm4135\webapp\controllers;
use ttm4135\webapp\Auth;
use ttm4135\webapp\models\User;


class LoginController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if (Auth::check()) {
            $username = Auth::user()->getUserName();
            $this->app->flash('info', 'You are already logged in as ' . $username);
            $this->app->redirect('/');
        } else {
            $this->render('login.twig', ['title'=>"Login"]);
        }
    }

    function login()
    {
        $request = $this->app->request;
        $username = $request->post('username');
        $password = $request->post('password');
        if ( Auth::checkCredentials($username, $password) ) {
            $user = User::findByUser($username);
            $_SESSION['userid'] = $user->getId();
            $this->app->flash('info', "You are now successfully logged in as " . $user->getUsername() . ".");
            $rand = rand(40 , 55);
            $randString = $this->generateRandomString($rand);
            $_SESSION["randStr"] = $randString;
            $this->app->redirect('/');
        } else {
            $this->app->flashNow('error', 'Incorrect username/password combination.');
            $this->render('login.twig', []);
        }
    }

    function logout()
    {   
        Auth::logout();
        $this->app->flashNow('info', 'Logged out successfully!!');
        $this->render('base.twig', []);
        return;
       
    }
    
   function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
}
