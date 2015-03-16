<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Регистрация</title>
  <link rel="stylesheet" href="../css/style.css"/>
</head>
<body>
<div class="conteiner">
  <h1>Регистрация</h1>
  <form action="" method="post">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
          <td>Логин</td>
          <td><input type="text" name="login" value=""/></td>
        </tr>
        <tr>
          <td>Пароль</td>
          <td><input type="password" name="password" value=""/></td>
        </tr>
      <tr align="right">
        <td colspan="2">
          <input type="submit" value="Сохранить"/>
          <input type="button" value="Отменить" onclick="document.location.href='/'"/>
        </td>
      </tr>
    </table>
  </form>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script language="javascript" type="text/javascript">
  $(function() {
    submit = $('form [type=submit]');
    submit.click(function(event) {
      event.preventDefault();
      form = $('form');
      $.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: '/ajax.php?func=register',
        data: form.serialize(),
        success: function(data)
        {
          if(data.success==1)
            form.submit();
          else
            alert(data.message);
        },
        error: function()
        {
          alert(data.message);
        }
      });
    });
  });
</script>
</body>
</html>