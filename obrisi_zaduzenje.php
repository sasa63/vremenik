<?php
include('db.php');
if(!isset($_SESSION))session_start();
if($_SESSION['status'] < 10)    header('Location: index.php');
if(isset ($_POST['Submit']) and $_POST['Submit'] == 'Dalje'){ 
    if(isset($_POST['godina'])) $_SESSION['godina']=(int)$_POST['godina'];}
if(!isset($_POST['godina']) and !isset($_POST['submit'])){
    $result = $db->query('select id from %PREFIKS%godine where aktivan = 1');
    $id_godina=$result->fetch(PDO::FETCH_COLUMN);
    $result = $db->query('SELECT id, naziv, aktivan FROM %PREFIKS%godine WHERE 1 ORDER BY id');
    echo '<form method="POST" action=""><select name="godina">';
    if(isset($_SESSION['godina'])) $id_godina=$_SESSION['godina'];
    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        if($row['id']==$id_godina) $c="selected='selected'"; else $c='';
        echo "<option value='$row[id]' $c />",$row['naziv'],"</option>\n";
    }
    echo '</select><input type="submit" name="Submit" value="Dalje" /></form>';
}
if(isset ($_POST['submit']) and $_POST['submit'] == 'Dalje'){
    if(isset($_POST['godina'])) $_SESSION['godina']=(int)$_POST['godina'];
    $id_godina=$_SESSION['godina'];    
    $nastavnik = $db->query('Select pravo_ime FROM %PREFIKS%nastavnici WHERE id='.(int)$_POST['nastavnik']);
    $nastavnik = $nastavnik->fetch(PDO::FETCH_COLUMN);
    $query = "SELECT %PREFIKS%radi_u.id as id,
                %PREFIKS%radi_u.razred as razred,
                %PREFIKS%radi_u.odjel as odjel,
                %PREFIKS%predmeti.naziv as predmet
            FROM %PREFIKS%radi_u LEFT JOIN %PREFIKS%predmeti ON %PREFIKS%predmeti.id=id_predmet WHERE id_nastavnik=".
            (int)$_POST['nastavnik'].' AND id_godina='.$id_godina .' ORDER BY razred, odjel';
    echo "<h1>Brisanje zaduženja</h1>Nastavnik: $nastavnik<br />Označi zaduženja za brisanje<br />\n
        <form method='POST' action='' />";
    $result = $db->query($query) or die (mysql_error());
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        echo "<input type='checkbox' value='$id' name='brisi[]' /> $razred. $odjel - $predmet<br />";
    }
    echo '<input type="Submit" name="submit" value="Briši" /></form>';
}
if(isset ($_POST['submit']) and $_POST['submit'] == 'Briši'){
    if (isset ($_POST['brisi'])){
        $brisi = implode(',', $_POST['brisi']);
        $result=$db->query("DELETE FROM %PREFIKS%radi_u WHERE id IN ($brisi)");
        echo 'Broj obrisanih zaduženja: ', $result->rowCount();
    } else echo 'Ništa nije označeno za brisanje';
}
if(isset ($_POST['Submit']) and $_POST['Submit']=='Dalje'){
    echo "Odaberi nastavnika: <br /><form method='POST' action='' /><select name='nastavnik'>";
    $query=$db->query('SELECT id, pravo_ime FROM %PREFIKS%nastavnici ORDER BY pravo_ime');
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='$row[id]'>$row[pravo_ime]</option>\n";
    }
    echo '</select><input type="Submit" name="submit" value="Dalje" /></form>';
}
?>
