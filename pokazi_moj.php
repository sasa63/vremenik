<?php
if(!isset($_SESSION)) session_start();
if(!isset ($_SESSION['status']) or $_SESSION['status']<2)    die ('Krive ovlast<br /><a href="index.php">Nazad</a>');
include_once 'db.php';
$result = $db->query('select id from godine where aktivan = 1') or die(mysql_error());
$id_godina=$result->fetchColumn();
$query = "SELECT datumi.dan as dan,
        predmeti.naziv aS predmet,
        nastavnici.pravo_ime as ime,
        vremenik.tip as tip,
        vremenik.razred as razred,
        vremenik.odjel as odjel,
        vremenik.potvrda as potvrda
        FROM datumi
        RIGHT JOIN vremenik ON datumi.id=id_dan and id_nastavnik=$_SESSION[uid]
        LEFT JOIN nastavnici ON nastavnici.id=id_nastavnik
        left JOIN predmeti ON predmeti.id=id_predmet
        where id_godina=$id_godina AND datumi.aktivan=1  
        ORDER BY vremenik.razred, vremenik.odjel, vremenik.id_predmet, datumi.dan";
$result=$db->query($query) or die (mysql_error());
if($result->rowCount()>0){
    $d=array(1=>'Pon','Uto','Srije','Čet','Pet');
    echo "<table border='3'><tr><td>Razred</td><td>Predmet</td><td>Datum</td><td>Tip</td></tr>\n";
    while ($row=  $result->fetch(PDO::FETCH_ASSOC)){
        $dan = date('d.m.Y.', strtotime($row['dan']));
        $dan1 = $d[date('N',strtotime($row['dan']))];
        $tip = ($row['tip'] == 1 ? 'Duga ' : 'Kratka ').'provjera - '.($row['potvrda'] ? '': 'ne').'objavljena';
        echo "<tr><td>$row[razred].$row[odjel]</td><td>$row[predmet] </td><td>$dan $dan1</td><td>$tip</td></tr>\n";
    }
    echo "</table>";
    echo '<br /><a href="GetMoj.php" target="_blank">Ispiši</a>';
    echo '<br /><a href="index.php">Nazad</a>';
}
?>
