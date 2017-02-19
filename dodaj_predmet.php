<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if(!isset($_SESSION) or $_SESSION['status']<10 )
    die ('<h1>Nemate ovlasti za pristup sadržaju</h1>');
include 'db.php';

if (isset ($_POST['submit'])){
    if($_POST['submit'] == 'Dodaj') {
        $ime = $db->quote($_POST['ime']);
        $sql = "INSERT INTO %PREFIKS%predmeti (naziv,poredak) VALUE ($ime,0)";
        
    } else if($_POST['submit'] == 'Briši'){
        if(isset ($_POST['brisi']) and is_array($_POST['brisi'])){
            $b = $_POST['brisi'];
            $t = TRUE;
            foreach ($b as $a) if (!ctype_digit($a)) $t = FALSE;
            if($t){
                $b = "('".implode("', '", $b)."')";
                $sql = "DELETE FROM %PREFIKS%predmeti WHERE id IN $b";
            }
        }
    }
    if(isset($sql)) $result = $db->query($sql);
    if(isset($result)) echo 'Podaci ažurirani'; else echo 'Problemi s bazom podataka';
    }
    $sql = 'SELECT * FROM %PREFIKS%predmeti';
    $result = $db->query($sql);
    echo '<form method="POST" action="">';
    if ($result->rowCount() > 0){
        echo '<table><tr><td> Predmet </td><td> Obriši? </td></tr>';
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "\n\t<tr><td> ".$row['naziv']." </td><td><input type='checkbox' name='brisi[]' value='$row[id]'></td></tr>";
        }
        echo "\n</table>\n<input type='Submit' name='submit' value='Briši'><br />\n";
    }
    echo "\n<input type='text' name='ime'>\n<input type='Submit' name='submit' value='Dodaj'></form>";
?>
