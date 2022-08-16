<!DOCTYPE html>
<html lang="cs">
<head>
<title>SKINS for CS:GO Database</title>
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
  $sql = 'SELECT id_p, nickname FROM players';
  $result = $dbconn->query($sql);
  if(!$result) {
    die('CHYBA DATABAZE: '.$dbconn->error);
  }
  $players = $result->fetch_all(MYSQLI_ASSOC);

?>

<?php
  if($_SERVER['REQUEST_METHOD']=="POST") {

    $weapons_id = $_POST['id_w'];
    $players_id = $_POST['id_p'];
      if($weapons_id > 0 && $players_id > 0) {
        $sql_item_insert = safe_sql_string(
          'INSERT INTO `players_has_weapons` (players_id, weapons_id) VALUES (?id_p, ?id_w)',
          ['id_p'=>$players_id, 'id_w'=>$weapons_id], $dbconn);
        if ($dbconn->query($sql_item_insert) === TRUE) {
        } else {
          die('CHYBA DATABAZE: '.$dbconn->error);
        }
      }
    
    $dbconn->commit();

    $weapons_id = $_POST['id_w'];
    $skins_id = $_POST['id_s'];
      if($weapons_id > 0 && $skins_id > 0) {
        $sql_item_insert = safe_sql_string(
          'INSERT INTO `weapons_has_skins` (weapons_id, skins_id) VALUES (?id_w, ?id_s)',
          ['id_w'=>$weapons_id, 'id_s'=>$skins_id], $dbconn);
        if ($dbconn->query($sql_item_insert) === TRUE) {
        } else {
          die('CHYBA DATABAZE: '.$dbconn->error);
        }
      }
    }
    $dbconn->commit();
  ?>

<table border="1" align="center" style="width:50%">
  <tr><th>id</th><th>name</th><th>price</th><th>quality</th></tr>
 <?php
  foreach($skins as $skin) {
    echo "<tr>\n";
    echo "     <td>".$skin['id_s']."</td>";
    echo "     <td>".$skin['name']."</td>";
    echo "     <td>".$skin['price']."</td>";
    echo "     <td>".$skin['quality']."</td>";
    echo "</tr>\n";
   }
  ?>
</table>

<h3>Vyberte nové skiny pro jednotlivé hráče:</h3>
<form method="POST">
<table border="1" align="center" style="width:25%">
  <tr>
    <th>Jméno hráče</th>
    <td>
      <select name="id_p">
        <?php
        echo '<option value="0" selected>-</option>';
          foreach($players as $player) {
            echo '<option value="' . $player['id_p'] . '">' . $player['nickname'] . '</option>';
          }
        ?>
      </select>
    </td>
  </tr>
  
  <tr>
    <th>Název zbraně</th>
    <td>
      <select name="id_w">
        <?php
        echo '<option value="0" selected>-</option>';
          foreach($weapons as $weapon) {
            echo '<option value="' . $weapon['id_w'] . '">' . $weapon['name'] . '</option>';
          }
        ?>
      </select>
    </td>
  </tr>

  <tr>
    <th>Název skinu</th>
    <td>
      <select name="id_s">
        <?php
        echo '<option value="0" selected>-</option>';
          foreach($skins as $skin) {
            echo '<option value="' . $skin['id_s'] . '">' . $skin['name'] . '</option>';
          }
        ?>
      </select>
    </td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="Potvrdit výběr"></td>
  </tr>
</table>
</form>
<h4><?php
    if($_SERVER['REQUEST_METHOD']=="POST") {
	  echo "Skiny byly úspěšně vybrány a přiřazeny.";
    }
  ?></h4>

</body>
</html>