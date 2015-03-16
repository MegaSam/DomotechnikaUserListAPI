<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Информация о пользователе</title>
  <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>
<div class="conteiner">
  <h1>Информация о пользователе <?=$data['login']?></h1>
    <table cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td><b>Login:</b></td>
        <td><?=$data['login']?></td>
      </tr>
      <tr>
        <td><b>Nick:</b></td>
        <td><?=$data['nick']?>
      </tr>
      <tr>
        <td><b>Email:</b></td>
        <td><?=$data['email']?></td>
      </tr>
      <tr align="right">
        <td colspan="2">
          <input type="button" value="Назад" onclick="document.location.href='/'"/>
        </td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>