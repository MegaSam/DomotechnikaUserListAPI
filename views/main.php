<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Пользовательские данные</title>
  <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>
<div class="conteiner">
  <?php if ($message != ''): ?>
  <div class="message">
    <div>
      <div><?=$message;?></div>
    </div>
  </div>
  <?php endif; ?>

  <h1>Пользовательские данные</h1>
  <table cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <?php if($auth != ''): ?>
      <td colspan="7">
          Вы авторизованы как <b><?=$auth;?></b> <a href="/logout" style="font-size: 10px;">Выход</a>
      </td>
      <?php else: ?>
      <td colspan="3" align="center">
        <a href="/login">Авторизация</a>
      </td>
      <td align="center"> - Выберите действие - </td>
      <td colspan="3" align="center">
          <a href="/register">Регистрация</a>
      </td>
      <?php endif; ?>
      </td>
    </tr>
    <?php if($auth != ''): ?>
    <tr>
      <th>Id</th>
      <th>Nick</th>
      <th>Login</th>
      <th>Email</th>
      <th>Инфо</th>
      <th>Редактировать</th>
      <th>Удалить</th>
    </tr>
    <?php if(!$users): ?>
      <tr>
        <td colspan="7" align="center"><b>Список пользователей пуст</b></td>
      </tr>
    <?php endif; ?>
    <?php foreach($users as $user): ?>
      <tr>
        <td align="center"><?=$user['id']?></td>
        <td><?=$user['nick']?></td>
        <td><?=$user['login']?></td>
        <td><?=$user['email']?></td>
        <td align="center"><a href="info/<?=$user['id']?>">инфо</a></td>
        <td align="center"><a href="edit/<?=$user['id']?>">редактировать</a></td>
        <td align="center"><a href="delete/<?=$user['id']?>">удалить</a></td>
      </tr>
    <?php endforeach; ?>
      <tr align="right">
        <td colspan="7">
          <input type="button" value="Создать пользователя" onclick="document.location.href='/add'"/>
        </td>
      </tr>
    <?php endif; ?>
  </table>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript">
  $(function(){
    $('.conteiner').on('click', 'a[href*="delete"]', function(){
      if (confirm("Вы уверены, что хотите удалить этого пользователя?"))
        return true;
      else
        return false;
    });
    $('.message').delay(800).fadeOut(400);
  });
</script>
</body>
</html>