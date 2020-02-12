<html>
<head>
	<title><?=$login;?></title>
	<meta charset="utf-8">
		<link rel="stylesheet" href="/css/style.css">
</head>
<body>

<?
$this->perslib->show_pers($login);
$this->perslib->show_modif($login,'false');
?>
</body>
</html>