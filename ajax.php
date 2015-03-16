<?php
require 'config.php';

function valid_email($str)
{
  $pcre_email = "/\w+@[a-zA-Z_0-9]+?\.[a-zA-Z]{2,6}/i";

  if (preg_match($pcre_email, $str))
  {
    return true;
  }
  return false;
}

try
{
  if ($_GET['func'] == 'register')
  {
    $dblogin = $db->prepare("SELECT `login` FROM `admin` WHERE `login`='{$_POST['login']}'");
    $dblogin->execute();
    $nlogin = $dblogin->fetch(PDO::FETCH_ASSOC);

    if ($_POST['login'] == '')
      throw new Exception("Пожалуйста, введите логин!");
    if (!empty($nlogin))
      throw new Exception("Пользователь с таким логином уже существует!");
    if (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 10)
      throw new Exception("Длина логина должна составлять от 3 до 10 символов!");
    if ($_POST['password'] == '')
      throw new Exception("Пожалуйста, введите пароль!");
    if (strlen($_POST['password']) < 4 || strlen($_POST['password']) > 10)
      throw new Exception("Длина пароля должна составлять от 4 до 10 символов!");
  }
  elseif ($_GET['func'] == 'login')
  {
    $login = $_POST['login'];
    $password = md5($_POST['password']);

    $dbquery = $db->prepare("SELECT * FROM `admin` WHERE `login`='{$login}' && `password`='{$password}' LIMIT 1");
    $dbquery->execute();
    $nlogin = $dbquery->fetch(PDO::FETCH_ASSOC);

    if ($_POST['login'] == '')
      throw new Exception("Пожалуйста, введите логин!");
    if ($_POST['password'] == '')
      throw new Exception("Пожалуйста, введите пароль!");
    if (empty($nlogin))
      throw new Exception("Логин и пароль не совпадают!");
  }
  elseif ($_GET['func'] == 'edit')
  {
    if ($_POST['nick'] == '')
      throw new Exception("Пожалуйста, введите ник!");
    if (strlen($_POST['nick']) < 3 || strlen($_POST['nick']) > 10)
      throw new Exception("Длина ника должна составлять от 3 до 10 символов!");
    if ($_POST['email']=='')
      throw new Exception("Пожалуйста, введите e-mail");
    if (valid_email($_POST['email'])!=true)
      throw new Exception("Пожалуйста, корректно введите e-mail");
  }
  elseif ($_GET['func'] == 'add')
  {
    $dbemail = $db->prepare("SELECT `email` FROM `users` WHERE `email`='{$_POST['email']}'");
    $dbemail->execute();
    $nemail = $dbemail->fetch(PDO::FETCH_ASSOC);

    if ($_POST['login'] == '')
      throw new Exception("Пожалуйста, введите логин!");
    if (strlen($_POST['login']) < 3 || strlen($_POST['login']) > 10)
      throw new Exception("Длина логина должна составлять от 3 до 10 символов!");
    if ($_POST['nick'] == '')
      throw new Exception("Пожалуйста, введите ник!");
    if (strlen($_POST['nick']) < 3 || strlen($_POST['login']) > 10)
      throw new Exception("Длина ника должна составлять от 3 до 10 символов!");
    if ($_POST['email']=='')
      throw new Exception("Пожалуйста, введите e-mail");
    if (valid_email($_POST['email'])!=true)
      throw new Exception("Пожалуйста, корректно введите e-mail");
    if (!empty($nemail))
      throw new Exception("Пользователь с таким email уже существует!");
  }

    $json['success'] = 1;
    $json['message'] = 'Ок';
}
catch(Exception $e)
{
  $json['success'] = 0;
  $json['message'] = $e->getMessage();
}
echo json_encode($json);
die();
?>