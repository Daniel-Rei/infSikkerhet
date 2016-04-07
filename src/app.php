<?php
require_once __DIR__ . '/../vendor/autoload.php';
//error_reporting(0); // Skal være med før innlevering
$templatedir =  __DIR__.'/webapp/templates/';
$app = new \Slim\Slim([
    'debug' => true, //Skal være false
    'templates.path' => $templatedir,
    'view' => new \Slim\Views\Twig($templatedir
  )
]);
$view = $app->view();
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);
$view->parserOptions = array(
    'debug' => true
);


try {
    // Create (connect to) SQLite database in file
    $app->db = new PDO('sqlite:app.db');   //TODO update with location of your database
    // Set errormode to exceptions
    $app->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo $e->getMessage();
    exit();
}


$ns ='ttm4135\\webapp\\controllers\\';


/// app->(GET/POST) (URL, $ns . CONTROLLER);    // description..   <who has access>

$app->get('/',     $ns . 'HomeController:index');             //front page            <all site visitors>

$app->get('/admin', $ns . 'AdminController:index');        //admin overview        <staff and group members>

$app->get( '/login', $ns . 'LoginController:index');        //login form            <all site visitors>
$app->post('/login', $ns . 'LoginController:login');       //login action          <all site visitors>
$app->post('/logout',$ns . 'LoginController:logout');  //logs out    <all users>
$app->get('/logout', $ns . 'LoginController:logout');  //logs out    <all users>
$app->get('/restricted', $ns . 'UserController:index');
$app->post('/restricted', $ns . 'UserController:create');
$app->get('/admin',  $ns  .  'AdminController:index');

$app->get('/admin/delete/:userid', $ns . 'UserController:delete');     //delete user userid        <staff and group members>

$app->post('/admin/deleteMultiple', $ns . 'UserController:deleteMultiple');     //delete user userid        <staff and group members>
$app->get('/admin/edit/:userid',    $ns . 'UserController:show');       //add user userid          <staff and group members>
$app->post('/admin/edit/:userid',   $ns . 'UserController:edit');       //add user userid          <staff and group members>

$app->get('/admin/create',    $ns . 'AdminController:create');       //add user userid          <staff and group members>
$app->post('/admin/create',   $ns . 'UserController:newuser');       //add user userid          <staff and group members>  //TODO FIX


return $app;
