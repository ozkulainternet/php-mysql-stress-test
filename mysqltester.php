<!DOCTYPE HTML>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta charset="utf-8" />
	<title>Özkula Mysql Stress test</title>
	<style>
		input {font-size:19px;}
		body {text-align:center; font-family: "roboto",Helvetica,Arial,Verdana;	font-size:20px;}
		h6 {color:red;} h5 {color:green;}
	</style>
</head>
<body>
<form method="post">
	<h1>Özkula MYSQL Stress Test</h1>
<h4>SERVER</h4>
<input type="text" name="host" value="<?php if (isset($_POST['host'])) { echo $_POST['host']; }else{ echo 'localhost';} ?>" /><hr>
<h4>Kullanici (user)</h4>
<input type="text" name="user" value="<?php if (isset($_POST['user'])) echo $_POST['user']; ?>" /><hr>
<h4>Sifre (password)</h4>
<input type="text" name="pass" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" /><hr>
<h4>Sure (saniye )</h4>
<input type="text" name="sure" value="<?php if (isset($_POST['sure'])) { echo $_POST['sure']; }else{ echo '60';} ?>" /><hr>
<input type="submit" value="Baslat" /><hr>

<?php
if (isset($_POST['host'])) {
	$bag=true;
	try {
		$pdo=new PDO('mysql:host=' . $_POST['host'] . ';charset=utf8',$_POST['user'],$_POST['pass']);
	}catch (PDOException $e) {
		$bag=false;
		echo "<h6>Baglanti kurulamadi: </h6>";
		print '<pre>'.$e->getMessage().'</pre>';
	}

	if ($bag!=true) {

		echo '<h4>Sonuc</h4><h5>baglanamadim ki nasil calisayim</h5>';
	}else{
		echo '<h4>Sonuc</h4>';


		$sure=(int)$_POST['sure']; if ($sure<2) $sure=2;
		set_time_limit($sure+5); // 2 minutes

		$bas=time();
		$snc=array();
		$don=true;
		while($don) {
			$pdo->query("SELECT BENCHMARK(1000000, AES_ENCRYPT('hello', UNHEX('F3229A0B371ED2D9441B830D21A390C3')));");
			if (time()-$bas>$sure) $don=false;
		}
		$pdo=null;
		echo '<h5>agam ben tamamim</h5>';
	}
}
?>
</body></html>
