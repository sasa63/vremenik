<?php
if(isset($_COOKIE['login']) and $_COOKIE['login'] == 1) {
    $_POST = $_COOKIE;
    $_POST['submit']="Prijava";
}

if(isset($_POST['submit']) and $_POST['submit']=='Prijava'){
        include 'db.php';
        //$db = new PDO("mysql:host=localhost;dbname=Vremenik","root","");
        $ime=preg_replace('/[^a-z.]/i', '', strtolower($_POST['ime']));
	$sql="SELECT * FROM nastavnici WHERE ime='".$ime."' AND lozinka='".md5($_POST['loz'])."'";
        $r=$db->query($sql);
        $us=0;
        $row = $r->fetch(); 
        if( ($row)){
            //$row = mysql_fetch_array($r);
            $_SESSION['prijavljen'] = true;
            $_SESSION['ime'] = $row['pravo_ime'];
            $_SESSION['status'] = $row['status'];
            $_SESSION['uid']=$row['id'];
            $us=1;
        
        $db->query("INSERT INTO login (ime, ip, uspjesno) VALUE ('$ime', '".$_SERVER['REMOTE_ADDR']. "', $us)");
        $sql="select id from admin where id_nastavnik=$_SESSION[uid]";
        $result=$db->query($sql);
        if($result->fetch()) $_SESSION['admin']=1; 
        $sql="SELECT id from razredi where id_razrednik=$_SESSION[uid]";
        $result=$db->query($sql);
        if($row=$result ->fetch()) $_SESSION['razrednik']=$row[0];
        }
}
if(isset($_SESSION['prijavljen'])and $_SESSION['prijavljen']) {
    echo "<div style='background-color: linen; width: 100%;font-size: 22px;'>$_SESSION[ime]</div>";
    echo '
        <form method="POST" action="">
	<input type="submit" name="odjava" value="Odjava" /><br />
</form>';
}else {

?>
<div style='background-color: linen; width: 100%;font-size: 22px;'>Prijava:</div>
<form method="POST" action=""><table>
	<tr><td>Ime:</td><td><input type="text" name="ime"></td></tr>
	<tr><td>Lozinka:</td><td><input type="password" name="loz"></td></tr>
        <tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Prijava" /></td></tr></table>
</form>
<?php
}
?>