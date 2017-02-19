<?php
if(isset($_POST['submit'])){
    $pw1 = md5($_POST['pw']);
    include 'dbc.php';
        $pre=$_SESSION['pre'];
        $link=$_SESSION['link'];
        $user=$_SESSION['user'];
        $pw=$_SESSION['pw'];
        $db = new dbc($link, $user, $pw);
        $db->pre($pre);
        $sql =  "INSERT INTO %PREFIKS%nastavnici (ime, pravo_ime, lozinka, status,email) "
                . "VALUES ('admin', 'Admin', '$pw1',10 ,'')";
        $db->query($sql);
        $_SESSION['k3']='OK';
        $f =fopen('db.php','w');
        fwrite($f, '<?php '."\r\n");
        fwrite($f, 'include "dbc.php";'."\r\n");
        fwrite($f, '$db=new dbc("'.$link.'","'.$user.'","'.$pw.'");'."\r\n");
        fwrite($f, '$db->pre("'.$pre.'");');
        fclose($f);
        unlink('install.php');
        unlink('k1.php');
        unlink('k2.php');
        unlink('k3.php');
        header('location:Index.php');
    
} else {   
?>
<form method="POST" action=""><br />
    Određivanje pasworda za korisničko ime admin
    Unesite admin lozinku: <input type="text" name="pw" ><br />
    <input type="submit" name="submit" value="Dalje">
        
</form>
<?php
}


