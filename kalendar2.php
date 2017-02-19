<?php
include_once 'status.php';
$dani = array(1 => 'PON', 'UTO', 'SRE', 'ČET', 'PET');
if(isset($_POST['submit']) and $_POST['submit']=='Zapamti'){
   
    $neaktivni=array();
    foreach ($_POST['dan'] as $k => $v) {if($v==0) $neaktivni[]=$k;}
    //$neaktivni=array_keys($_POST['dan']);
    if(count($neaktivni)>0) $ne_aktivni= implode(', ',$neaktivni); else $ne_aktivni='';
    $db->query("update %PREFIKS%datumi SET aktivan=1 Where id_godina=$id_godina");
    if(count($neaktivni)>0) $db->query("update %PREFIKS%datumi SET aktivan=0 Where id IN ($ne_aktivni)") or die('kalendar2');
} else if(isset($_POST['Submit']) and $_POST['Submit']=='Dalje'){
    $id_godina=(int) $_POST['godina'];
    $sql="SELECT id, dan, aktivan FROM %PREFIKS%datumi WHERE id_godina = $id_godina ORDER BY dan ASC";
    $result = $db->query($sql) ;
    echo '<form method="POST" action=""><table border="3">';
    while($r=$result->fetch(PDO::FETCH_ASSOC)){
        $dan = implode('.',array_reverse(explode('-', $r['dan'])));
        echo "<tr><td>".$dan," - ",$dani[date('N',strtotime($r['dan']))],"</td>";
        echo "<td><input type='radio' name='dan[$r[id]]'",$r['aktivan'] ? ' checked' : ''," value='1' />Aktivan</td><td><input type='radio' name='dan[$r[id]]'",$r['aktivan'] == 1 ? '' : "checked" ," value='0' />Neaktivan </td></tr>\n";
    }
    echo "</table>\n<input type='submit' name='submit' value='Zapamti'>";
} else {
    $result = $db->query('SELECT id, naziv, aktivan FROM %PREFIKS%godine WHERE 1 ORDER BY id') or die(mysql_error());
    echo '<form method="POST" action=""><select name="godina"  >Odaberite kalendar:<br />>';
    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        
        echo "<option value='$row[id]'>",$row['naziv'],"</option><br />\n";
    }
    echo '</select><input type="submit" value="Dalje" name="Submit" /></form>';
}
?>