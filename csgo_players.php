<!DOCTYPE html>
 <html lang="cs">
<head>
<title> CS:GO - SKINS </title>
<meta charset='utf-8'></meta>
<link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>

<div id='id_nadpis'> <h2> CS:GO - SKINS DATABASE </h2></div>

<div id='id_menu'> 
<div class='menu-nadpis'> CS:GO SKINS </div> 
<a href="csgo_skins.php"> <h3>SKINS</h3> </a>
<a href="csgo_1.html"> <h3>CREATE SKINS</h3> </a>
<a href="csgo_players.php"> <h3>PLAYERS</h3> </a>
<a href="readme.html"> <h3>ABOUT</h3> </a>
</div>

<div id='id_obsah'> <h3> PLAYERS </h3>
<p> <h4>Následující tabulka obsahuje informace o všech hráčích na serveru.</h4> </p>
<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  include('players.php');
?>
</div>

<div id='id_zahlavi'> <h3>© 193241 - Pospíšil Václav</h3></div>

</body>
</html>