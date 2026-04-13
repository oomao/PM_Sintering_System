<?php
require_once("dbtools.inc.php");

//建立資料連接
$link = create_connection();

$sql = "SELECT * FROM `new` WHERE `nid` = 1 ";
$result = execute_sql($link, "powder", $sql);
$row2 = mysqli_fetch_object($result);

//取得表單資料
$nid = "1";
if(isset($_POST["machine"])) {
  $machine = $_POST["machine"];
  $_SESSION["machine"] = $machine;
}else {
  $machine = "1001";
} 
if(isset($_POST["hyd1"]))$hydlow = $_POST["hyd1"];else $hydlow = $row2->hydlow;
if(isset($_POST["hyd2"]))$hydhigh = $_POST["hyd2"];else $hydhigh = $row2->hydhigh;
if(isset($_POST["dew1"]))$dewlow = $_POST["dew1"];else $dewlow = $row2->dewlow;
if(isset($_POST["dew2"]))$dewhigh = $_POST["dew2"];else $dewhigh = $row2->dewhigh;
if(isset($_POST["nit1"]))$nitlow = $_POST["nit1"];else $nitlow = $row2->nitlow;
if(isset($_POST["nit2"]))$nithigh = $_POST["nit2"];else $nithigh = $row2->nithigh;
if(isset($_POST["CO21"]))$co2low = $_POST["CO21"];else $co2low = $row2->co2low;
if(isset($_POST["CO22"]))$co2high = $_POST["CO22"];else $co2high = $row2->co2high;
if(isset($_POST["hum1"]))$humlow = $_POST["hum1"];else $humlow = $row2->humlow;
if(isset($_POST["hum2"]))$humhigh = $_POST["hum2"];else $humhigh = $row2->humhigh;
if(isset($_POST["tem1"]))$temlow = $_POST["tem1"];else $temlow = $row2->temlow;
if(isset($_POST["tem2"]))$temhigh = $_POST["tem2"];else $temhigh = $row2->temhigh;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>控制介面</title>
</head>

<style>
    body {
      margin: 0;
    }

    h3 {
      font-weight: bold;
    }

    form {
        margin-top: 20px;
        margin: 0 auto;
        background-color: #ffffffad;
        padding: 20px;
        border: 1px solid #271b1b;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        font-size: 16px;
    }

    legend {
      font-weight: bold;
    }

    button {
      margin-top: 10px;
    }
</style>

<script>
  function validateForm() {
    // 檢查 $hydlow 是否大於 $hydhigh
    if (parseInt(document.forms["control"]["hyd1"].value) > parseInt(document.forms["control"]["hyd2"].value) ||
        parseInt(document.forms["control"]["dew1"].value) > parseInt(document.forms["control"]["dew2"].value) ||
        parseInt(document.forms["control"]["nit1"].value) > parseInt(document.forms["control"]["nit2"].value) ||
        parseInt(document.forms["control"]["CO21"].value) > parseInt(document.forms["control"]["CO22"].value) ||
        parseInt(document.forms["control"]["hum1"].value) > parseInt(document.forms["control"]["hum2"].value) ||
        parseInt(document.forms["control"]["tem1"].value) > parseInt(document.forms["control"]["tem2"].value)) {
        alert('請由小到大輸入');
        return false; // 阻止表單提交
    }
    // 檢查其他條件...
    return true; // 允許表單提交
  }
</script>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-md">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar1">
          <ul class="navbar-nav me-auto">
              <li class="nav-item"><a class="nav-link" href="home.php">機台即時資料</a></li>
              <li class="nav-item"><a class="active nav-link" href="control.php">控制介面</a></li>
              <li class="nav-item"><a class="nav-link" href="history.php">歷史氣體濃度曲線圖</a></li>
              <li class="nav-item"><a class="nav-link" href="history_table.php">機台歷史資料查詢</a></li>
              <!-- <li class="nav-item"><a class="nav-link" href="test.html">測試介面</a></li> -->
          </ul>
      </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6" style="margin-top: 70px">
                <form name="control" method="post" action="home.php" onsubmit="return validateForm()">
                    <center>
                        <legend><h3 class='font-effect-shadow-multiple'>控制介面</h3></legend>
                        機台選擇：
                        <select name="machine">
                        <option value="1001">1號機台</option>
                        <option value="1002">2號機台</option>
                        </select>
                        <br>
                        <br>
                        氫氣濃度區間：
                        <input type="number" name="hyd1" min="0" max="100" value="<?php echo $hydlow ?>" required>~
                        <input type="number" name="hyd2" min="0" max="100" value="<?php echo $hydhigh ?>" required>
                        <br>
                        <br>
                        氮氣濃度區間：
                        <input type="number" name="nit1" min="0" max="100" value="<?php echo $nitlow ?>" required>~
                        <input type="number" name="nit2" min="0" max="100" value="<?php echo $nithigh ?>" required>
                        <br>
                        <br>                        
                        露點濕度區間：
                        <input type="number" name="dew1" min="0" max="100" value="<?php echo $dewlow ?>" required>~
                        <input type="number" name="dew2" min="0" max="100" value="<?php echo $dewhigh ?>" required>
                        <br>
                        <br>
                        二氧化碳區間：
                        <input type="number" name="CO21" min="0" max="100" value="<?php echo $co2low ?>" required>~
                        <input type="number" name="CO22" min="0" max="100" value="<?php echo $co2high ?>" required>
                        <br>
                        <br>
                        濕度區間：
                        <input type="number" name="hum1" min="0" max="100" value="<?php echo $humlow ?>" required>~
                        <input type="number" name="hum2" min="0" max="100" value="<?php echo $humhigh ?>" required>
                        <br>
                        <br>
                        溫度區間：
                        <input type="number" name="tem1" min="0" max="100" value="<?php echo $temlow ?>" required>~
                        <input type="number" name="tem2" min="0" max="100" value="<?php echo $temhigh ?>" required>
                        <br>
                        <br>
                        <center><button type="submit" class="btn btn-outline-dark" style="font-weight: bold;">送出</button></center>
                    </center>
                </form>
            </div>
        </div>
    </div>
</body>
</html>