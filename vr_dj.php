<?php

if(isset ($_POST['submit'])and $_POST['submit']=='Pokaži'){
    include_once 'db.php';
    $result = $db->query('select id from godine where aktivan = 1') or die(mysql_error());
    $id_godina=$result->fetchColumn();

    if(isset($_POST['razred'])and in_array($_POST['razred'], range(1, 4))) $razred=$_POST['razred'];else        die ('Odaberi razred');
    if(isset($_POST['odjel'])and in_array($_POST['odjel'], range('A', 'G'))) $odjel=$_POST['odjel'];else        die ('Odaberi odjel');
    if(!isset ($_POST['sve'])) {$join = ' RIGHT '; $w='datumi.dan > NOW()';} else {$join = ' LEFT '; $w='datumi.dan>"2012-01-01"';}
    $query = "SELECT datumi.dan as dan,
        predmeti.naziv aS predmet,
        nastavnici.pravo_ime as ime,
        vremenik.tip as tip
        FROM datumi
        $join JOIN vremenik ON datumi.id=id_dan and razred=$razred and odjel='$odjel' and potvrda=1
        LEFT JOIN nastavnici ON nastavnici.id=id_nastavnik
        left JOIN predmeti ON predmeti.id=id_predmet
        where $w AND id_godina=$id_godina AND datumi.aktivan=1 ORDER BY datumi.dan";
    $result = $db->query($query) or die (mysql_error());
    $d=array(1=>'Pon','Uto','Srije','Čet','Pet');
    $t = array(1=>'Duga provjera', 'Kratka provjera');
    $data=array();
    echo '<table border="3"><tr><td>Datum</td><td>Predmet</td><td>Tip</td><td>Nastavnik</td></tr>';
    while ($row =  $result->fetch(PDO::FETCH_ASSOC)) {
        $dan = date('d.m.Y',  strtotime($row['dan']));
        $dan1 = $d[date('N',strtotime($row['dan']))];
        $pre=$row['predmet']?$row['predmet']:'&nbsp;';
        $nas = $row['ime']?$row['ime']:'&nbsp;';
       // $tip = $t[$row['tip']]?$t[$row['tip']]:'&nbsp;';
        $tip = $row['tip']>0?$t[$row['tip']]:'&nbsp;';
        echo "<tr><td>$dan $dan1</td><td>$pre</td><td>$tip</td><td>$nas</td></tr>\n";
        $data[] = array("$dan $dan1",$pre,$nas);
    }
    echo '</table>';
    echo "<br /><a href='getVre1.php?r=$razred&o=$odjel". (isset ($_POST['sve']) ? '&j=1' : '') .'\' target="_blank">Ispiši</a>';
    echo '<br /><a href="index.php">Doma</a>';
} else if(isset($_SESSION['prijavljen']) and $_SESSION['prijavljen']) {
    echo 'Odaberi posao<br /><hr />';
}

?>
<form method="POST" action="">
    Odaberi razred:<br />
    <select name="razred">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <select name="odjel">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        <option value="E">E</option>
        <option value="F">F</option>
        <option value="G">G</option>
    </select>
    <input type="checkbox" name="sve" value="1" /> Pokaži sve datume<br />
    <input type="Submit" name="submit" value="Pokaži">
</form>

