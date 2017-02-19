<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['submit'])){
    $host = $_POST['host'];
    $dbname=$_POST['dbname'];
    $user=$_POST['user'];
    $pw=$_POST['pw'];
    $link = 'mysql:host='.$host.';dbname='.$dbname;
    try {
        echo$db = new PDO($link, $user, $pw) or die('PDO');
        $_SESSION['k1']=' - OK';
        $_SESSION['link']=$link;
        $_SESSION['user']=$user;
        $_SESSION['pw']=$pw;
        header('location:Install.php?k=2');
    } catch (Exception $ex) {
        echo $_SESSION['k1']=' - greška';
        header('location:Install.php');

    } 
     //$_SESSION['k1']='OK';
     //header('location:Install.php?k=2');
} else {   
?>
<form method="POST" action=""><br />
    Server baze, podataka:<input type="text" name="host" value="localhost"><br />
    Naziv baze: <input type="text" name="dbname"><br />
    Korisnik: <input type="text" name="user"><br />
    Lozinka: <input type="text" name="pw"><br />
    <input type="submit" name="submit" value="Dalje">
        
</form>
<?php
}
?>