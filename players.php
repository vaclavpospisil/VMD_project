<!DOCTYPE html>
<html lang="cs">
<head>
<title>Players of CS:GO</title>
<meta charset="utf-8"></meta>
<link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>

<?php
  // připojení k databázi
  include('databaze.php');
?>

<?php

  # seznam skinů
  $sql = 'SELECT * FROM skins';
  $result = $dbconn->query($sql);
  if(!$result) {
    die('CHYBA DATABAZE: '.$dbconn->error);
  }
  $skins = $result->fetch_all(MYSQLI_ASSOC);
  # seznam zbraní
  $sql = 'SELECT * FROM weapons';
  $result = $dbconn->query($sql);
  if(!$result) {
    die('CHYBA DATABAZE: '.$dbconn->error);
  }
  $weapons = $result->fetch_all(MYSQLI_ASSOC);
  # seznam hráčů
  $sql = 'SELECT * FROM players';
  $result = $dbconn->query($sql);
  if(!$result) {
    die('CHYBA DATABAZE: '.$dbconn->error);
  }
  $players = $result->fetch_all(MYSQLI_ASSOC);

  # players_has_weapons
  $sql = 'SELECT * FROM players_has_weapons';
  $players_has_weapon = $dbconn->query($sql);
  if(!$players_has_weapon) {
 die('CHYBA DATABAZE: '.$dbconn->error);   
  }
  $players_has_weapons = $players_has_weapon->fetch_all(MYSQLI_ASSOC);

  # weapons_has_skins
  $sql = 'SELECT * FROM weapons_has_skins';
  $weapons_has_skin = $dbconn->query($sql);
  if(!$weapons_has_skin) {
 die('CHYBA DATABAZE: '.$dbconn->error);   
  }
  $weapons_has_skins = $weapons_has_skin->fetch_all(MYSQLI_ASSOC);
?>

<table border="1" align="center" style="width:50%" cellspacing="1">
  <tr><th>id</th><th>nickname</th><th>email</th></tr>
 <?php
  foreach($players as $player) {
    echo "<tr>\n";
    echo "     <td>".$player['id_p']."</td>";
    echo "     <td>".$player['nickname']."</td>";
    echo "     <td>".$player['email']."</td>";
    echo "</tr>\n";
   }
  ?>
</table>

<h4>Seznam hráčů a jejich vybrané zbraně.</h4>
<table border="1" align="center">
  <tr><th>nickname</th><th>zbraň</th></tr>

<?php
	  foreach($players_has_weapons as $player_has_weapon) {
		      foreach($players as $player) {
			       if($player['id_p'] === $player_has_weapon['players_id']) {

              echo "<tr><th>";
              echo $player['nickname'];
              echo "</th>";
              foreach($weapons as $weapon) {
                if($weapon['id_w'] === $player_has_weapon['weapons_id']) {
                echo "<th>";
                echo $weapon['name'];
                echo "</th></tr>";
				   }					   
			  }
    }
  }
}
  ?>
</table>

<h4>Seznam zbraní a k nim přiřazené skiny.</h4>
<table border="1" align="center">
  <tr><th>zbraň</th><th>skin</th><th>cena</th></tr>

<?php
	  foreach($weapons_has_skins as $weapon_has_skin) {
		      foreach($weapons as $weapon) {
			       if($weapon['id_w'] === $weapon_has_skin['weapons_id']) {

              echo "<tr><th>";
              echo $weapon['name'];
              echo "</th>";
              foreach($skins as $skin) {
                if($skin['id_s'] === $weapon_has_skin['skins_id']) {
                echo "<th>";
                echo $skin['name'];
                echo "</th>";
                echo "<th>";
                echo $skin['price'];
                echo "</th></tr>";
				   }					   
			  }
    }
  }
}
  ?>
</table>


</body>
</html>