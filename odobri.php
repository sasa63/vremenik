<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset ($_SESSION))session_start();
if(!isset($_SESSION['status']) or ($_SESSION['status']<8) ) die('Nemate ovlasti');
    include_once 'db.php';
    if(isset ($_POST['submit']) and $_POST['submit']=='Potvrdi'){
        $in='';
        if(isset ($_POST['potvrdi']) and is_array($_POST['potvrdi']))$in='('.implode (',', $_POST['potvrdi']).')';
        if($in) {$up = $db->query("UPDATE vremenik set potvrda=1, zapravo_obrisan=obrisan Where id IN $in");
        if($up->rowCount()){
            $f=fopen('datum.txt', 'w');
            fwrite($f, date('d.m.Y. \u H:i:s',  time()+6*3600));
            fclose($f);
            echo 'Podaci potvrđeni<a href="index.php"> klikni za povratak</a>';
        } else echo 'Provjere nisu potvrđene!';} else        echo 'Nema provjera za potvrdu!';
        $db->query('INSERT into `obrisano` (`id_dan`,`id_predmet`,`id_nastavnik`,`razred`,`odjel`,`tip`,`obrisan`,`potvrda`)
        (SELECT `id_dan`,`id_predmet`,`id_nastavnik`,`razred`,`odjel`,`tip`,`obrisan`,`potvrda` from vremenik WHERE zapravo_obrisan=1)');
    $db->query('DELETE from vremenik WHERE zapravo_obrisan=1');
    
    }
    echo '<form method="POST" action ="">
        <input type="Submit" name="submit" value="Potvrdi"><br />';

    //if(isset($_POST['razred'])and in_array($_POST['razred'], range(1, 4))) $razred=$_POST['razred'];else        die ('Odaberi razred');
    //if(isset($_POST['odjel'])and in_array($_POST['odjel'], range('A', 'G'))) $odjel=$_POST['odjel'];else        die ('Odaberi odjel');
    //if(!isset ($_POST['sve'])) $join = ' RIGHT '; else $join = ' LEFT ';
    $query = "SELECT datumi.dan as dan,
        predmeti.naziv aS predmet,
        nastavnici.pravo_ime as ime,
        vremenik.id as id,
        vremenik.obrisan as obrisan,
        vremenik.razred as razred,
        vremenik.odjel as odjel
        FROM datumi
        right JOIN vremenik ON datumi.id=id_dan 
        LEFT JOIN nastavnici ON nastavnici.id=id_nastavnik
        left JOIN predmeti ON predmeti.id=id_predmet
        WHERE potvrda=0 or obrisan=1
        ORDER BY razred, odjel, datumi.dan ASC";
    $result = $db->query($query);
    $d=array(1=>'Pon','Uto','Srije','Čet','Pet');
    $t = array(1=>'Duga provjera', 'Kratka provjera');
    $data=array();
    echo '<table border="3"><tr><td>Razred</td><td>Datum</td><td>Predmet</td><td>Nastavnik</td><td>Odobri</td></tr>';
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $dan = date('d.m.Y',  strtotime($row['dan']));
        $dan1 = $d[date('N',strtotime($row['dan']))];
        $pre=$row['predmet'];
        $nas = $row['ime'];
        $id = $row['id'];
        $tip=$row['obrisan']?'brisanje':'potvrda';
        echo "<tr><td>$row[razred].$row[odjel]</td><td>$dan $dan1</td><td>$pre</td><td>$nas</td><td>
        <input type='checkbox' name='potvrdi[]' value=$id checked='checked'>$tip</td></tr>\n";
        //$data[] = array("$dan $dan1",$pre,$nas);
    }
    echo '</table><br /><input type="Submit" name="submit" value="Potvrdi"></form>';
    
    
?>
