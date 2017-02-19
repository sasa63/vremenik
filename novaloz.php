<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!isset ($_SESSION['status']) or $_SESSION['status']<10) die ('Nemate ovlasti!');
include_once 'db.php';
if(isset ($_POST['submit'])){
    if($_POST['submit']=='Dalje'){
        $result=$db->query("select pravo_ime,ime from %PREFIKS%nastavnici where id=$_POST[prof]");
        $row=$result->fetch(PDO::FETCH_ASSOC);
        echo "Promjena lozinke za nastavnika<br /><h1>$row[pravo_ime]</h1><br />
        Korisničko ime: $row[ime]<br/>
        <form method='POST' action=''>
        Nova lozinka: <input type='password' name='loz' /><br>
        Nova lozinka 2#: <input type='password' name='loz2' /><br>
        <input type='hidden' value='$_POST[prof]' name='prof' />
        <input type='Submit' name='submit' value='Zapamti' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type='Submit' name='submit' value='Odustani' /></form>";
    }
    if($_POST['submit']=='Zapamti'){
        if($_POST['loz']==$_POST['loz2']){
            $result=$db->query("update %PREFIKS%nastavnici set lozinka='".md5($_POST['loz'])."' where id=$_POST[prof]")or die (mysql_error());
            if($result){
                echo 'Lozinka uspješno promjenjena.<br />';
                $result=$db->query("select ime, pravo_ime from %PREFIKS%nastavnici where id=$_POST[prof]");
                $row=$result->fetch(PDO::FETCH_ASSOC);
                echo $row['pravo_ime'],'<br />Ime: ',$row['ime'],'<br />Lozinka: ',$_POST['loz'];
            } else                echo 'Greška';
        } else            echo 'Lozinke moraju biti jednake!';
    }
} else {
    $result = $db->query('select id, pravo_ime from %PREFIKS%nastavnici order by pravo_ime') or die (mysql_error());
    echo '<form method="POST" action="">
        <select name="prof">';
    while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        echo "<option value='$row[id]'>$row[pravo_ime]</option>\n";
    }
    echo "</select>
        <input type='Submit' name='submit' value='Dalje' /></form>";
}
?>
