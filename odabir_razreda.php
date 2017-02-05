<?php

if(!isset ($_SESSION) or $_SESSION['status']<10) die('<h1>Trenutno nemate dovoljne ovlasti!</h1>');
include 'db.php';


$result = $db->query('select id from godine where aktivan = 1');
$id_godina=$result->fetchColumn();
if(count($_POST)==0){
$result = $db->query('SELECT id, naziv, aktivan FROM godine WHERE 1 ORDER BY id');
echo '<form method="POST" action=""><select name="godina">';
if(isset($_SESSION['godina']))$id_godina=$_SESSION['godina'] ; else $id_godina=0;
while($row=$result->fetch(PDO::FETCH_ASSOC)){
    if($row['id']==$id_godina) $c="selected='selected'"; else $c='';
    echo "<option value='$row[id]' $c />",$row['naziv'],"</option>\n";
}
echo '</select><input type="submit" name="Submit" value="Dalje" /></form>';}
else{
if(isset($_POST['submit']) and $_POST['submit']=='Dalje' and isset($_POST['predmet'])){
    $_SESSION['uid1']=$_POST['nastavnik'];
    echo '<form method="POST" action="">';
    $result = $db->query('SELECT * FROM predmeti WHERE id IN ('.implode(',', $_POST['predmet']).')') or die(mysql_error());
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        echo 'Predmet ',$row['naziv'] ,' predaje u:';
        echo '<table>
    <tr><td>&nbsp;</td><td>A</td><td>B</td><td>C</td><td>D</td><td>E</td><td>F</td><td>G</td></tr>';
        for($i = 1; $i<5; $i++){
            echo "\t<tr><td>$i</td>";
            for($j='A'; $j<'H'; $j++){
                echo "<td><input type='checkbox' name='raz[".$row['id'] ,"][]' value='$i,$j'></td>";
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
    }
    echo "<input type='Submit' value='Zapamti' name='submit'></form>";
} else if(isset($_POST['submit'] ) and $_POST['submit']=='Zapamti'){
    $nast=$_SESSION['uid1'];
    foreach ($_POST['raz'] as $pred => $odj){
        foreach ($odj as $x){
            $x=explode(',', $x);
            $r=(int) $x[0];
            $o = $db->quote($x[1]);
            $q[] ="('$nast','$r',$o,'$pred','$id_godina')";
        }
    }
    if(count($q)) $query = 'INSERT INTO radi_u (id_nastavnik, razred, odjel, id_predmet, id_godina) VALUE '.  implode(', ', $q);
    if($query) $db->query ($query);
unset ($_SESSION['uid1']);
} elseif(isset($_POST['Submit']) and $_POST['Submit'] == 'Dalje') $_SESSION['godina']=$_POST['godina'];

if(isset($_SESSION['godina']) and !(isset($_POST['submit']) and $_POST['submit']=='Dalje')){ $id_godina= (int) $_SESSION['godina'];
    $query = 'SELECT * FROM nastavnici ORDER BY pravo_ime';
    $result = $db->query($query);
    echo "Odaberi nastavnika i predmet(e):<br />";
    echo '<form method="POST" action="">';
    echo "\n<select name='nastavnik'>\n";
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='$row[id]'>$row[pravo_ime]</option>\n";
    }
    echo '</select>';
    $query = 'SELECT * from predmeti';
    $result = $db->query($query);

    echo '<table><tr><td>Odaberi predmete</td></tr>';
    while ($row = $row=$result->fetch(PDO::FETCH_ASSOC)) echo '<tr><td>',$row['naziv'],'</td><td><input type="checkbox" value="',$row['id'],"\" name=\"predmet[]\"></td></tr>\n";


?>

</table>
<input type="Submit" name="submit" value="Dalje" />
</form>
<?php
}
}
?>