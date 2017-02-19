<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//session_start();
if(!isset ($_SESSION) or $_SESSION['status']<2) die('<h1>Trenutno nemate dovoljne ovlasti!</h1>');
include 'db.php';
if(!isset ($_POST['submit'])){
    $nastavnik=$_SESSION['uid'];
    $res=$db->query("SELECT id, pravo_ime, email from %PREFIKS%nastavnici where id=$nastavnik");
    $row=$res->fetch(PDO::FETCH_ASSOC);
    echo "<form method='POST' action=''>
        Pravo ime: <input type='text' value='$row[pravo_ime]' name='ime'><br />
        E-mail: <input type='text' value='$row[email]' name='email'><br />
        ";
    echo "<input type='Submit' value='Zapamti' name='submit'></form>
        <a href='index.php'>Povratak</a>";
} elseif($_POST['submit']=='Zapamti'){
    //print_r($_POST);
    $ime = $db->quote($_POST['ime']);
    $email = $db->quote($_POST['email']);
    $db->query("UPDATE %PREFIKS%nastavnici SET pravo_ime=$ime, email=$email WHERE id=$_SESSION[uid]");
    
}

?>
  </body></html>