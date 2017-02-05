<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
If(!isset ($_SESSION['uid'])) session_start ();
include_once 'db.php';
if(isset ($_POST['submit']) and $_POST['submit'] == 'Promijeni'){
    $ns1=trim($_POST['ns1']);
    $ns2=trim($_POST['ns2']);
    $ss=trim($_POST['ss']);
    if($ns1!=$ns2) echo 'Lozinke nisu jednake:';
    else {
        if(!$ns1) echo 'Lozinka ne može biti prazna';
        else {
            $ns = md5($ns1);
            $ss = md5($ss);
            $id=$_SESSION['uid'];
            $ime = $db->quote($_POST['ime']);
            $sql = "UPDATE nastavnici SET lozinka='$ns' WHERE lozinka='$ss' and id=$id and ime=$ime";
            $res=$db->query($sql);
           
        }
    }
}
?>
<h3>Promjena lozinke</h3><form method="POST" action="">
<table>
    <tr>
        <td>Korisničko ime</td><td><input type="text" name="ime" /></td>
    </tr><tr>
        <td>Stara lozinka</td><td><input type="password" name="ss" value=""/></td>
    </tr><tr>
        <td>Nova lozinka</td><td><input type="password" name="ns1" /></td>
    </tr><tr>
        <td>Nova lozinka #2</td><td><input type="password" name="ns2" /></td>

    </tr>

</table>
    <br /><input type="Submit" name="submit" value="Promijeni" />
</form>
<br />
<a href="index.php">Povratak</a>