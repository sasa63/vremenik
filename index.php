<?php
session_start();
if(isset ($_POST['odjava'])){
    unset ($_SESSION);
    session_destroy();
    header('Location: index.php');
    if(isset ($_POST['submit']) and $_POST['submit']=='Odustani') header('Location: index.php');
}
if(isset ($_POST['submit']) and $_POST['submit']=='Odustani') header('Location: index.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title>Vremenik</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body >
      <div style="width: 100%; background-color: azure; height: 100%;">
      <div class="zaglavlje" style="width: 100%; height: 80px;background-color: lime;font-size: 4em;text-align: center;font-weight: 900;
           vertical-align: middle;">
          V R E M E N I K
      </div>
      <div class="levi" style="width: 200px; float: left; background-color: lightgreen; min-height:100%; ">
          <br />
          <?php
          include 'login.php';
          include 'izbornik.php';
          ?>
      </div>
      <div style="float: none; display: inline-block;min-width: inherit; ">
          <?php
          if(isset($_GET['id'])){
          if(isset ($_GET['id']) and $_GET['id']==1){
          if($_GET['id']==1 and $_SESSION['prijavljen'] and $_SESSION['status']==10) include 'dodaj_predmet.php';
          
          }
          if($_GET['id']==2) include 'odabir_razreda.php';
          if($_GET['id']==3) include 'unos.php';
          if($_GET['id']==4) include 'odobri.php';
          if($_GET['id']==5) include 'promjeni_sifru.php';
          if($_GET['id']==6) include 'unos_ravnatelj.php';
          if($_GET['id']==7) include 'pokazi_moj.php';
          if($_GET['id']==8) include 'dodaj_nastavnika.php';
          if($_GET['id']==9) include 'obrisi_zaduzenje.php';
          if($_GET['id']==10) include 'edit_nastavnik.php';
          if($_GET['id']==11) include 'novaloz.php';
          if($_GET['id']==12) include 'kalendar.php';
          if($_GET['id']==13) include 'kalendar2.php';
          if($_GET['id']==14) include 'aktiviraj.php';
          } else {
              if(file_exists('datum.txt'))
              echo '<h1 style=" text-decoration: underline;">Zadnja promjena: ',  file_get_contents('datum.txt'),' sati</h1><br/><br/>';
              include 'vr_dj.php';
          }

          ?>
      </div>
      </div>
  </body>
</html>
