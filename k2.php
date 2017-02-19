<?php

if(isset($_POST['submit'])){
    $pre = $_POST['pre']!=''?$_POST['pre'].'_' : '';
    include 'dbc.php';
        $_SESSION['pre']=$pre;
        $link=$_SESSION['link'];
        $user=$_SESSION['user'];
        $pw=$_SESSION['pw'];
        $db = new dbc($link, $user, $pw);
        $db->pre($pre);
        $db->query(file_get_contents('baza.sql'));
        $_SESSION['k2']='OK';
                
        header('location:Install.php?k=3');
    
} else {   
?>
<form method="POST" action=""><br />
    Prefiks tablic u bazi: <input type="text" name="pre" value="Vremenik"><br />
    <input type="submit" name="submit" value="Dalje">
        
</form>
<?php
}
