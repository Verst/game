<html>
    <head>
        <title>Моя игра</title>
        <link rel="stylesheet" href="css/style.css">
        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/regform.js"></script>
    </head>
    <body>
        <?= validation_errors(); ?>
        <?
        echo form_open('reg');
        $data = array(
            'name' => 'nik',
            'id' => 'nik'
        );
        echo 'Логин: ' . form_input($data, set_value('nik')) . '<span id="loginchek"></span><br />';
        echo 'Пароль: ' . form_password('pass') . '<br />';
        echo 'Повторите пароль: ' . form_password('passconf') . '<br />';
        echo 'E-mail: ' . form_input('email', set_value('email')) . '<br />';
        echo 'Пол: <input type="radio" name="sex" value="1"'.set_radio('sex', '1', TRUE).' /> Мужской
                    <input type="radio" name="sex" value="2" '.set_radio('sex', '2').' /> Женский<br /> ';
        echo form_submit('submit', 'Регистрация');
        echo form_close();
        ?>
    </body>
</html>