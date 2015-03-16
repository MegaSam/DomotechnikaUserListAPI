<?php
require 'config.php';

$app = new \Slim\Slim();
$app->config(array(
  'debug' => true,
  'templates.path' => 'views'
));
$db = new PDO('mysql:host=localhost;dbname=domotechnika;charset=utf8','root','');

$app->notFound(function () use ($app) {
  $app->render('404.html');
});

$app->get('/', function () use($app, $db) {
  $data['message'] = '';
  $message = '';
  if ($app->request->get('message') == 'auth')
    $message = 'Вы успешно авторизованы на сайте!';
  elseif ($app->request->get('message') == 'register')
    $message = 'Вы успешно зарегистрированы на сайте!';
  elseif ($app->request->get('message') == 'add')
    $message = 'Новый пользователь успешно создан!';
  elseif ($app->request->get('message') == 'edit')
    $message = 'Данные успешно сохранены!';
  elseif ($app->request->get('message') == 'delete')
    $message = 'Пользователь был удален!';

  if ($app->request->get('message') != '')
    $data['message'] = $message;

  $get_users = $db->prepare("SELECT * FROM `users`");
  $get_users->execute();
  $data['users'] = $get_users->fetchAll(PDO::FETCH_ASSOC);
  if($app->getCookie('login') != '')
    $data['auth'] = $app->getCookie('login');
  else
    $data['auth'] = '';

  $app->render('main.php', $data);
})->name('main');

$app->get('/register', function() use($app) {
  $app->render('register.php');
});

$app->post('/register', function() use($app, $db) {
  $request = $app->request;
  $login = $request->post('login');
  $password = md5($request->post('password'));

  $dblogin = $db->prepare("SELECT `login` FROM `admin` WHERE `login`='{$login}'");
  $dblogin->execute();
  $nlogin = $dblogin->fetch(PDO::FETCH_ASSOC);

  if (empty($nlogin)) {
    $dbquery = $db->prepare("INSERT INTO `admin` (`login`, `password`) VALUES (:login, :password)");
    $dbquery->execute(array(':login' => $login, ':password' => $password));
  }

  $app->redirect('/?message=register');
});

$app->get('/login', function() use($app) {
  $app->render('login.php');
});

$app->post('/login', function() use($app, $db) {
  $request = $app->request;
  $login = $request->post('login');
  $password = md5($request->post('password'));

  $dbquery = $db->prepare("SELECT * FROM `admin` WHERE `login`='{$login}' && `password`='{$password}' LIMIT 1");
  $dbquery->execute();
  $nlogin = $dbquery->fetch(PDO::FETCH_ASSOC);
  if (!empty($nlogin)) {
    $app->setCookie('login',$login);
  }

  $app->redirect('/?message=auth');
});

$app->get('/logout', function() use($app) {
  $app->setCookie('login','');
  $app->redirect('/');
});

$app->get('/info/:id', function($id) use($app, $db) {
  $get_user = $db->prepare("SELECT * FROM `users` WHERE `id`='{$id}'");
  $get_user->execute();
  $data = $get_user->fetch(PDO::FETCH_ASSOC);

  $app->render('info.php', $data);
})->conditions(array('id' => '[0-9]'))->name('info');

$app->get('/edit/:id', function($id) use($app, $db) {
  $get_user = $db->prepare("SELECT * FROM `users` WHERE `id`='{$id}'");
  $get_user->execute();
  $data = $get_user->fetch(PDO::FETCH_ASSOC);

  $app->render('edit.php', $data);
})->conditions(array('id' => '[0-9]'))->name('edit');

$app->post('/edit/:id', function($id) use($app, $db) {
  $request = $app->request;
  $nick = $request->post('nick');
  $login = $request->post('login');
  $email = $request->post('email');

  $dbquery = $db->prepare("UPDATE `users` SET `nick`=:nick, `login`=:login, `email`=:email WHERE `id`=:id");
  $dbquery->execute(array(':id' => $id, ':nick' => $nick, ':login' => $login, ':email' => $email));


  $app->redirect('/?message=edit');
});

$app->get('/delete/:id', function($id) use($app, $db) {
  $dbquery = $db->prepare("DELETE FROM `users` WHERE `id`='{$id}'");
  $dbquery->execute();
  $app->redirect('/?message=delete');
});

$app->get('/add', function() use($app) {
  $app->render('add.php');
});

$app->post('/add', function() use($app, $db) {
  $request = $app->request;
  $nick = $request->post('nick');
  $login = $request->post('login');
  $email = $request->post('email');

  $dbquery = $db->prepare("INSERT INTO `users` (`nick`, `login`, `email`) VALUES (:nick, :login, :email)");
  $dbquery->execute(array(':nick' => $nick, ':login' => $login, ':email' => $email));


  $app->redirect('/?message=add');
});

$app->run();