<?php

namespace ttm4135\webapp\controllers;

use ttm4135\webapp\models\User;
use ttm4135\webapp\Auth;

class AdminController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

   function index()     
    {
        if (Auth::isAdmin()) {
            $users = User::all();
            $this->render('users.twig', ['users' => $users]);
        } elseif (Auth::check()) {
            $username = Auth::user()->getUserName();
            $this->app->flash('info', 'You do not have access this resource. You are logged in as ' . $username);
            $this->app->redirect('/');
        } 
        else {
            $this->app->flash('info', 'You need to be logged in as admin');
            $this->app->redirect('/');
        }
    }

    function create()
    {
        if (Auth::isAdmin()) {
          $user = User::makeEmpty();
          $this->render('showuser.twig', [
            'user' => $user
          ]);
        } elseif (Auth::check()) {
            $username = Auth::user()->getUserName();
            $this->app->flash('info', 'You do not have access this resource. You are logged in as ' . $username);
            $this->app->redirect('/');
        } 
        else {
            $this->app->flash('info', 'You need to be logged in as admin');
            $this->app->redirect('/');
        }
    }


}
