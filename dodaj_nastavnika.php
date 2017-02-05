<?php
if(!isset($_SESSION))session_start();
include 'db.php';
if(isset ($_POST['submit'])and $_POST['submit']=='Dodaj' and $_POST['loz']==$_POST['loz1'] and $_POST['loz']!=""){
    
    $sql = "INSERT INTO nastavnici (ime, pravo_ime, lozinka, email, status) VALUES (". $db->quote($_POST['ime']).", "
            .  $db->quote($_POST['pravo_ime']).", "
            . $db->quote(md5($_POST['loz'])).", "
            .  $db->quote($_POST['email']).",2)";
   $db->query($sql);
    
}
if(isset ($_POST['submit']) and $_POST['submit']=='Brisi'){
	
    $brisi = '('.  implode(',', $_POST['brisi']).')';
    $db->query("DELETE from nastavnici Where id IN $brisi");
}

If($_SESSION['status']<10 )die ('nema ovlasti');
$result = $db->query('select * from nastavnici ORDER BY pravo_ime');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Vremenik</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body>
<form method="POST" action="">
    <table>
    <?php
    while ($row = $result->fetch()) {
        echo "<tr><td>$row[pravo_ime]</td><td><input type='checkbox' name='brisi[]' value='$row[id]'></td></tr>\n";
    }
    ?>
    </table>
	ime:<input type="text" name="ime" /><br />
	pravo ime:<input type="text" name="pravo_ime" /><br />
	lozinka: <input type="password" name="loz" /><br />
	ponovno lozinka: <input type="password" name="loz1" /><br />
	e-mail: <input type="text" name="email" /><br />
        <input type="submit" name="submit" value="Dodaj" />
        <input type="submit" name="submit" value="Brisi" />
</form>

  </body></html>