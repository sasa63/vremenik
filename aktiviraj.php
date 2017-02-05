<?php

/**
 * @author sasasa
 * @copyright 2003
 */

include 'status.php';

if(isset($_POST['Submit']) and $_POST['Submit']='Aktiviraj'){
    $id = (int) $_POST['id'];
    $db->query('UPDATE godine SET aktivan=0 where 1');
    $db->query('UPDATE godine SET aktivan=1 where id='.$id);
}
$result = $db->query('SELECT id, naziv, aktivan FROM godine WHERE 1 ORDER BY id') or die(mysql_error());
echo '<form method="POST" action="">';
while($row=$result->fetch(PDO::FETCH_ASSOC)){
    if($row['aktivan']) $c="checked='checked'"; else $c='';
    echo "<input type='radio' value='$row[id]' name='id' $c />",$row['naziv'],"<br />\n";
}
echo '<input type="submit" name="Submit" value="Aktiviraj" />';
?>