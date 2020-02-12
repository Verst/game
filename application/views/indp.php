<html>
    <head>
        <title>Моя игра</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <form method="post" action="enter/login">
            <label for="nik">Ник:</label><input type="text" name="nik" value="" /><br />
            <label for="pass">Пароль:</label><input type="password" name="pass" value="" /><br />
            <input type="submit" value="Войти" />
        </form>
        <? echo anchor('reg','Регистрация')?>
		<br><br>
		В игре: <?=$online;?>
    </body>
</html>