<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset ($_SESSION)) session_start ();
if(!isset($_SESSION['status']) or $_SESSION['status']<8)die('Nemate ovlasti');
include_once 'db.php';
$result = $db->query('select id from godine where aktivan = 1');
$row= $result->fetch(PDO::FETCH_ASSOC);
$id_godina=$row['id'];

if(!isset ($_POST['submit'])){
    $result = $db->query("select id, pravo_ime from nastavnici order by pravo_ime");
    echo 'Odaberi nastavnika:<br />
        <form method="POST" action="">
        <select name="nastavnik">';
    while ($row= $result->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='$row[id]'>$row[pravo_ime]</option>\n";
    }
    echo "</select><br />
        <input type='Submit' name='submit' value='Dalje' />
        </form>";
} else {
    if($_POST['submit']=='Dalje'){
        $query = "SELECT * FROM radi_u LEFT JOIN predmeti ON predmeti.id=id_predmet 
            WHERE id_godina=$id_godina AND id_nastavnik=".(int)$_POST['nastavnik'];

$result = $db->query($query);
if($result->rowCount()==0) {
    die('<h1>Nastavnik nema upisana zaduženja!</h1>');
}
echo '<form method="POST" action="">Odaberi razred i predmet: <br /><select name="razred">
    ';
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $value = $row['razred'].','.$row['odjel'].','.$row['id_predmet'];
    $text = $row['razred'].'. '.$row['odjel'].' - '.$row['naziv'];
    echo "<option value='$value'>$text</option>";
}
echo '</select><br />';
echo "<input type='hidden' value='$_POST[nastavnik]' name='nastavnik' />";

    echo 'Odaberi dan:<br />

    <select name="datum">';
    $result = $db->query("SELECT id, dan from datumi WHERE dan>NOW() AND id_godina=$id_godina ORDER BY dan");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $dan = date('d.m.Y.',  strtotime($row['dan']));
            echo "<option value='$row[id]'>$dan</option>\br";
    }
    echo "</select><br />
        Kratka provjera<input type='radio' name='kratka' value='2' />
        <input type='radio' name='kratka' value='1' checked='checked' />
        Duga provjera<br /><input type='Submit' name='submit' value='Zapamti' />
        </form><br/>";;
    }
    if($_POST['submit']=='Zapamti'){
        $nastavnik = $_POST['nastavnik'];
        list ($razred, $odjel, $predmet1) = explode(',', $_POST['razred']);
        $dan = $_POST['datum'];
        $tip = isset ($_POST['kratka']) ? $_POST['kratka'] : 1;
        $sql = "INSERT INTO vremenik (id_dan, id_predmet, id_nastavnik, razred, odjel, tip, potvrda) VALUE
                ($dan, $predmet1, $nastavnik, $razred, '$odjel', $tip, 1)";
        $db->query($sql) or die('Podaci nisu upisani');
        header('Location: index.php');
    }
}
?>