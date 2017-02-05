<?php
include_once 'status.php';
echo '
<form method="POST" action="">
Unesite naziv razdoblja:<input type="text" name="naziv" value="naziv" /><br />
Unesite trajanje razdoblja:<br />
        Prvo razdoblje od :<input type="text" name="od1" /> do:<input type="text" name="do1" /><br />
        Drugo razdoblje od:<input type="text" name="od2" /> do:<input type="text" name="do2" /><br />
        Trece razdoblje od:<input type="text" name="od3" /> do:<input type="text" name="do3" /><br />
        <input type="submit" name="Submit" value="Razdoblja" />
</form>';


if (isset($_POST['Submit']) and $_POST['Submit'] == 'Razdoblja') {
    
    $sql = 'SELECT dan FROM praznici WHERE 1';
    $result = $db->query($sql);
    //$sql = "UPDATE `datumi` a SET redbr=1+((SELECT COUNT(*) FROM (SELECT dan FROM datumi WHERE aktivan =1 and id_godina =1) b WHERE b.dan<a.dan)) WHERE aktivan =1 and id_godina=1";
    while ($r = $result->fetch()) {
        $praznici[] = $r[0];
    }
    
    echo $sql = "INSERT INTO godine SET naziv=" . $db->quote($_POST['naziv']). ' , aktivan=0';
    $db->query($sql) ;
    echo $id_godina = $db->lastInsertID();
    //echo $_POST['do1'];
    $od = explode('.', preg_replace('/[^0-9]/', '.', $_POST['od1']));
    if($od[2]<100) $od[2] +=2000;
    $od1 = strtotime($od[2] . '/' . $od[1] . '/' . $od[0]) + 5000;
    $od = explode('.', preg_replace('/[^0-9]/', '.', $_POST['do1']));
    if($od[2]<100) $od[2] +=2000;
    $do1 = strtotime($od[2] . '/' . $od[1] . '/' . $od[0]) + 10000;
    $tjedan = 0;
    $brojac = 0;
    $redniBroj=0;
    //$id_godina=2;
    $fields = "(id_godina, dan, aktivan, tjedan, redbr)";
    $value = array();
    while ($od1 <= $do1) {
        // echo date('d.m', $od1)," -- <br>";
        if (date('N', $od1) < 6 and !in_array(date('d.m', $od1), $praznici)) {
            if ($tjedan != date('W', $od1)) {
                $tjedan = date('W', $od1);
                $brojac++;
                $redniBroj++;
                //echo '<hr />';
            }
            //echo date('d.m.Y', $od1), ' - ', $brojac, '<br />';
            $value[] = "($id_godina, '" . date('Y/m/d', $od1) . "', 1,$brojac,$redniBroj)";
        }
        $od1 += 86400;
    }
    $od = explode('.', preg_replace('/[^0-9]/', '.', $_POST['od2']));
    if($od[2]<100) $od[2] +=2000;
    $od1 = strtotime($od[2] . '/' . $od[1] . '/' . $od[0]) + 5000;
    $od = explode('.', preg_replace('/[^0-9]/', '.', $_POST['do2']));
    if($od[2]<100) $od[2] +=2000;
    $do1 = strtotime($od[2] . '/' . $od[1] . '/' . $od[0]) + 10000;
    while ($od1 <= $do1) {
         
        if (date('N', $od1) < 6 and !in_array(date('d.m', $od1), $praznici)) {
            if ($tjedan != date('W', $od1)) {
                $tjedan = date('W', $od1);
                $brojac++;
                $redniBroj++;
                //echo '<hr />';
            }
            //echo date('d.m.Y', $od1), ' - ', $brojac, '<br />';
            $value[] = "($id_godina, '" . date('Y/m/d', $od1) . "', 1,$brojac,$redniBroj)";
        }
        $od1 += 86400;
    }
    $od = explode('.', preg_replace('/[^0-9]/', '.', $_POST['od3']));
    if($od[2]<100) $od[2] +=2000;
    $od1 = strtotime($od[2] . '/' . $od[1] . '/' . $od[0]) + 5000;
    $od = explode('.', preg_replace('/[^0-9]/', '.', $_POST['do3']));
    if($od[2]<100) $od[2] +=2000;
    $do1 = strtotime($od[2] . '/' . $od[1] . '/' . $od[0]) + 10000;
    while ($od1 <= $do1) {

        if (date('N', $od1) < 6 and !in_array(date('d.m', $od1), $praznici)) {
            if ($tjedan != date('W', $od1)) {
                $tjedan = date('W', $od1);
                $brojac++;
                $redniBroj++;
                //echo '<hr />';
            }
            //echo date('d.m.Y', $od1), ' - ', $brojac, '<br />';
            $value[] = "($id_godina, '" . date('Y/m/d', $od1) . "', 1 , $brojac , $redniBroj)";
        }
        $od1 += 86400;
    }
    $value = implode(', ', $value);
   echo $sql = "INSERT INTO datumi $fields VALUE $value";
    $db->query($sql);
    //$_POST['submit']='Zapamti';
    //include 'kalendar2.php';
}




?>