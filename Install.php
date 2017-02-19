<?php
session_start();

$korak1= isset($_SESSION['k1']) ? $_SESSION['k1']:'';
$korak2= isset($_SESSION['k2']) ? $_SESSION['k2']:'';
$korak3= isset($_SESSION['k3']) ? $_SESSION['k3']:'';
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
          Veza s bazom <?php          echo $korak1; ?> <BR /><BR />
          Stvaranje tablica <?php          echo $korak2; ?> <BR /><BR />
          Instalacija admina <?php          echo $korak3; ?> <BR /><BR />
          
      </div>
          
      <div style="float: none; display: inline-block;min-width: inherit; ">
          <?php
          if(isset($_GET['k'])){
              if($_GET['k']==2) include 'k2.php';
              if($_GET['k']==3) include 'k3.php';
          } else {
              include 'k1.php';
          }

          ?>
      </div>
      </div>
  </body>
<?php
/* include 'db.php';
if(file_exists('baza.sql')){
    $sql= file_get_contents('baza1.sql');
    $sql = str_replace('%PREFIKS%', 'vre'.'_', $sql);
    //$sql = str_replace('INTO `praznici', 'INTO `vrepraznici', $sql);
    //$db->query($sql);        
}
*/