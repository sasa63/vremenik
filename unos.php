<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//echo '<pre>',print_r($_POST),'</pre>';
if($_SESSION['status']<2) die('<h1>Trenutno nemate dovoljne ovlasti!</h1>');
include('db.php');
$result = $db->query('select id from godine where aktivan = 1');
$id_godina=$result->fetchColumn();
if(!isset ($_POST['submit'])){
$query = "SELECT * FROM radi_u LEFT JOIN predmeti ON predmeti.id=id_predmet WHERE id_godina=$id_godina AND id_nastavnik=".(int)$_SESSION['uid'];

$result = $db->query($query) ;
if($result->rowCount()==0) {
    die('<h1>Prvo odaberite razrede i predmet!</h1>');
}
echo '<form method="POST" action="">Odaberi razred: <select name="razred">
    ';
while ($row =  $result->fetch(PDO::FETCH_ASSOC)) {
    $value = $row['razred'].','.$row['odjel'].','.$row['id_predmet'];
    $text = $row['razred'].'. '.$row['odjel'].' - '.$row['naziv'];
    echo "<option value='$value'>$text</option>";
}
echo '</select><br />
Do <input type="text" value="', date('d.m.Y'),'" name="poc"> realizirano je <input type="text" name="realizacija"> sati.<br />',
'Odaberi dane:<br />
    <table><tr><td>&nbsp;</td><td> Pon </td><td> Uto </td><td> Sri </td><td> Čet </td><td> Pet </td></tr>',"\n";
    for($i = 1; $i<8;$i++){
        echo "\t<tr><td> $i </td>";
        for($j=2; $j<7; $j++){
            echo "<td><input type='checkbox' name='dan[$j][$i]' value='1' ></td>";
        }
        echo "</tr>\n";
    }
    echo '</table><br /><input type="Submit" name="submit" value="Dalje"></form>';

} else {
    if($_POST['submit']=='Dalje'){ 
        if(!isset ($_POST['dan'])) die ('<h1>Morate popuniti raspored!</h1>');
        
        $in = '('.implode(',', array_keys($_POST['dan'])).')';
        list ($razred, $odjel, $predmet1) = explode(',', $_POST['razred']);
        $query = $db->query('SELECT naziv From predmeti where id='.(int) $predmet1);
        $predmet = $query->fetchColumn();
        $d=array(0,0,0,0,0,0,0);
        foreach ($_POST['dan'] as $dan => $value) $d[$dan] = count ($value);
        $count = (int) $_POST['realizacija'];
        $query ="SELECT count(vremenik.id) as x, datumi.tjedan FROM `vremenik` left join datumi on datumi.id=id_dan
            WHERE razred='$razred' and odjel='$odjel' and obrisan<1 AND id_godina=$id_godina group by datumi.tjedan having x>=4";
        $result = $db->query($query) or die (mysql_error());
        $puni_tj=array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $puni_tj[] = $row['tjedan'];
        }
        $dan = explode('.',trim($_POST['poc'],'. '));
        $prethodni_dan = '';
        $poc_datum = implode('-', array_reverse($dan));
        $query = "SELECT datumi.id did,
                         vremenik.id vid,
                         datumi.dan as dan2,
                         DATE_FORMAT(datumi.dan,'%e.%c.%Y') dan,
                         dayofweek(datumi.dan) as dan1,
                         datumi.tjedan as tjedan,
                         predmeti.naziv predmet,
                         vremenik.id_nastavnik nid,
                         nastavnici.pravo_ime nastavnik
        from datumi left join vremenik on (datumi.id=id_dan and razred=$razred and odjel='$odjel' and obrisan<1)
        left join predmeti on predmeti.id=id_predmet
        left join nastavnici on nastavnici.id=id_nastavnik
        where dan>'$poc_datum' AND id_godina=$id_godina AND datumi.aktivan=1 order by datumi.dan";
        $nas_dan = array(2 => 'Pon', 'Uto', 'Srije' ,'Čet', 'Pet');

        $result = $db->query($query);
 ?>
<form method="POST" action="">
    <input type="hidden" name="razred" value="<?php echo $razred;?>">
    <input type="hidden" name="odjel" value="<?php echo $odjel;?>">
    <input type="hidden" name="predmet" value="<?php echo $predmet1;?>">
    <input type="hidden" name="predmet_ime" value="<?php echo $predmet;?>">
<?php
        $count++;
        echo "<h3>Vremenik za $razred. $odjel za predmet $predmet</h3><br /><table border='3'>";
        while ($row =  $result->fetch(PDO::FETCH_ASSOC)) {
            
            $dan1 = $row['dan1'];
            $dan2 = strtotime($row['dan2']);
            if($prethodni_dan!=$row['dan']){
               if($d[$dan1]>1)$c=$count.' - '.($count-1+$d[$dan1]);
               if($d[$dan1]==1)$c=$count;
               if($d[$dan1]<1) $c='&nbsp;';
               $count+=$d[$row['dan1']];
               $prethodni_dan=$row['dan'];
            }
            $p=$row['predmet']?$row['predmet']:'&nbsp;';
            $n=$row['nastavnik']?$row['nastavnik']:'&nbsp;';
            echo "<tr><td>$row[dan]</td><td>".$nas_dan[$row['dan1']]."</td><td>$c</td><td>$p</td><td>$n</td>";
            if($row['predmet'] or !$d[$dan1] or in_array($row['tjedan'], $puni_tj) or strtotime($row['dan2']) - time()<=120*3600) {
//            if($row['predmet'] or !$d[$dan1] or in_array($row['tjedan'], $puni_tj)) {
                $input = '<td>&nbsp</td><td>&nbsp</td>';
                if($row['nid']==$_SESSION['uid']and $dan2 > time()) $input = "<td><input type='checkbox' name='brisi[".$row['vid']."]' value='2'>Briši</td><td>&nbsp</td>";
            }
            else {
                if($dan2 - time()>144*3600)
                $input = "<td><input type='checkbox' name='dodaj[".$row['did']."]' value='2'> Kratka provjera</td><td><input type='checkbox' name='dodaj[".$row['did']."]' value='1'> Duga provjera</td>";
            }
            echo $input,"</tr>\n";
        }
        echo "</table>";
        echo '<input type="Submit" name="submit" value="Zapamti"></form>';
       echo '<a href="index.php?id=3">novo</a><br/>';}
    
    if($_POST['submit']== 'Odustani') header ('Location: index.php?id=3');
    
    if($_POST['submit']== 'Zapamti'){
    
//   print_r($_POST);
        $razred = (int) $_POST['razred'];
        $odjel = in_array($_POST['odjel'], range('A', 'H')) ? $_POST['odjel'] :'';
        $predmet = (int) $_POST['predmet'];
        $nastavnik = $_SESSION['uid'];
        //$poruka = "U VREMENIK je uvršteno za razred $razred.$odjel i predmet $_POST[predmet_ime]:<br />";
        if(!isset ($_POST['dodaj']) and !isset ($_POST['brisi'])) die ("U VREMENIK za razred $razred.$odjel i predmet $_POST[predmet_ime] nije uvršteno ništa!");

        if(isset($_POST['dodaj'])){
            $test=false;
            $poruka = "U VREMENIK je uvršteno za razred $razred.$odjel i predmet $_POST[predmet_ime]:<br />";
            foreach ($_POST['dodaj'] as $dan => $tip){
            $dan = (int) $dan;
            $tip = $tip == 2 ? 2 : 1;
            if($tip>1)$test=TRUE;
            $ppotvrda = $tip-1;
            //provjera
            $x='';
            $result=$db->query("select tjedan from datumi where id=$dan");
            $tj=$result->fetchColumn();
            $result=$db->query("SELECT count(*) From datumi
                                right join vremenik on (`datumi`.`id`=id_dan and razred=$razred and odjel='$odjel' and obrisan<1)
                                WHERE tjedan =$tj AND id_godina=$id_godina") or die(mysql_error());
            if($result->fetchColumn()>3) $x.='U tom tjednu je već 4 ispita ';
            $result=$db->query("SELECT id from vremenik WHERE razred=$razred and id_dan=$dan and odjel='$odjel' and obrisan<1") or die(mysql_error());
            if($result->rowCount()>0)$x.='Za taj dan već postoji upisana provjera';
            
            
            //provjera
            if($x==''){
            $query = "Insert into vremenik (id_dan, id_predmet, id_nastavnik, razred, odjel, tip, potvrda) VALUE
                ($dan, $predmet, $nastavnik, $razred, '$odjel', $tip, $ppotvrda)";
            $result = $db->query($query) ;
            //if(mysql_affected_rows ()==1) $x.='OK'; else $x='Nepoznata greška';
            }
            $result = $db->query("SELECT dan FROM datumi WHERE id=$dan");
            $dan = date('d.m.Y', strtotime($result->fetchColumn()));
            $tip = $tip == 1 ? 'duga provjera' : 'kratka provjera';
            $poruka .="$dan -> $tip $x<br />\n";
        }
        }//echo $poruka;
        if(isset ($_POST['brisi'])){
            $poruka.="<br/><br/>Brisanja za razred $razred.$odjel i predmet $_POST[predmet_ime]:</br>\n";
            foreach($_POST['brisi'] as $id => $value){
                $result=$db->query("SELECT datumi.dan as dan, id_dan, id_predmet, id_nastavnik, razred, odjel, tip, obrisan+0 as obrisano, potvrda
                                    FROM vremenik,datumi WHERE vremenik.id=$id and datumi.id=id_dan") or die(mysql_error());
                $row= $result->fetch(PDO::FETCH_ASSOC);
                $dan1 = date('d.m.Y',  strtotime ($row['dan']));
                if($row['id_nastavnik']!=$_SESSION['uid']) die('<h1>Krive ovlasti!</h1>');
                if(strtotime($row['dan']) > time()){
                    if($row['tip']==2 or $row['potvrda']==0){
                        if($row['tip']==2)$test=TRUE;
                        $sql="Insert into obrisano (id_dan, id_predmet, id_nastavnik, razred, odjel,tip, obrisan, potvrda) value
                                     ($row[id_dan],$row[id_predmet],$row[id_nastavnik],$row[razred],'$row[odjel]',$row[tip],'$row[obrisano]',$row[potvrda])";
                        $db->query($sql);
                        $db->query("DELETE FROM vremenik where id=$id");
                        
                    } else {
                        $db->query("UPDATE vremenik SET obrisan=1 WHERE ID=$id");
                        //if(mysql_affected_rows ()==1) $poruka.= "$dan1 - najava brisanja provjere<br />\n";
                    }
                }

            } 
            
        }echo $poruka;
        if($test){
            $f=fopen('datum.txt', 'w');
            fwrite($f, date('d.m.Y. \u H:i:s', time()+6*3600));
            fclose($f);
        }
    }
}

?>
    <br><a href="index.php">Povratak</a>