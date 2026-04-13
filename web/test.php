<?php
  require_once("dbtools.inc.php");
  date_default_timezone_set('Asia/Taipei');


  //建立資料連接
  $link = create_connection();
  
  //取得表單資料
  $machine_num = $_POST["machine"];
  $hhyd = $_POST["hhyd"];
  $ddew = $_POST["ddew"];
  $nnit = $_POST["nnit"];
  $cco2 = $_POST["cco2"];
  $hhum = $_POST["hhum"];
  $ttem = $_POST["ttem"];
  $date = date("Y-m-d H:i:s");
  
  $sql3 = "SELECT * FROM machine_history";
  $result3 = execute_sql($link, "powder", $sql3);
  
  //釋放 $result3 佔用的記憶體
  mysqli_free_result($result3);
  //執行 SQL 命令，新增此筆資料
  $sql3 = "INSERT INTO `machine_history` (`machine_num`, `hyd`, `dew`, `nit`, `co2`, `hum`, `tem`, `uploadDT`) 
  VALUES ('$machine_num', '$hhyd', '$ddew', '$nnit', '$cco2', '$hhum', '$ttem', '$date')";
  $result3 = execute_sql($link, "powder", $sql3);

  //關閉資料連接
  mysqli_close($link);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0.05; url=test.html">
    <title>新增成功</title>
  </head>
  <body>
  </body>
</html>