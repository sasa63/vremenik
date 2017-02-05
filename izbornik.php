<?php

if(isset($_SESSION['status']) and $_SESSION['status']>=2){
?>

<div style="background-color: linen; width: 100%"><a href="index.php?id=3">Izrada / promjena vremenika</a></div><br />
<div style="background-color: linen; width: 100%"><a href="index.php?id=7">Ispisi vremenik</a></div><br/>
<div style="background-color: linen; width: 100%"><a href="index.php?id=5">Promjena lozinke</a></div><br />
<div style="background-color: linen; width: 100%"><a href="index.php?id=10">Promjena imena</a></div><br />
    <?php
}
if (isset($_SESSION['status']) and $_SESSION['status']>7){
?>
    <hr style="line-height: 5" />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=4">Odobri</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=6">Unos bez provjere</a></div><br />

<?php
}
If(isset($_SESSION['status']) and $_SESSION['status'] == 10){
?>
    <div style="background-color: linen; width: 100%"><a href="index.php?id=1">Dodaj predmet</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=2">Dodaj zaduženje</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=9">Obriši zaduženje</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=8">Dodaj nastavnika</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=11">Dodijeli novu lozinku</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=12">Novi kalendar</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=13">Promjeni kalendar</a></div><br />
    <div style="background-color: linen; width: 100%"><a href="index.php?id=14">Aktiviraj kalendar</a></div><br />


<?php
} else if(isset($_SESSION['razrednik'])){ 
    //echo '<div style="background-color: linen; width: 100%"><a href="imenik/index.php" target="_blank">E-imenik</a></div><br /><br />';
}

?>
	