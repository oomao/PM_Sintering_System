<?php
session_start();
require_once("dbtools.inc.php");
$_SESSION["machine"]="1001";
//建立資料連接
$link = create_connection();

$sql = "SELECT * FROM `new`";
$result = execute_sql($link, "powder", $sql);
$row2 = mysqli_fetch_object($result);

if(isset($_POST["machine"])) {
  $machine = $_POST["machine"];
  if($machine == "1001") {
    $nid = "1";
  }else if($machine == "1002") {
    $nid = "2";
  }
  $_SESSION["machine"] = $machine;
}else {
  $machine = $_SESSION["machine"];
  if($machine == "1001") {
    $nid = "1";
  }else if($machine == "1002") {
    $nid = "2";
  }
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


$sql2 = "SELECT * FROM machine_history WHERE machine_num = $machine ORDER BY powder_id DESC LIMIT 1";
$result2 = execute_sql($link, "powder", $sql2);
$row = mysqli_fetch_object($result2);

if (mysqli_num_rows($result) != 0) {
    $update_sql = "UPDATE `new` SET `hydlow`=$hydlow, `hydhigh`=$hydhigh, `dewlow`=$dewlow, `dewhigh`=$dewhigh, `nitlow`=$nitlow, `nithigh`=$nithigh, `co2low`=$co2low, `co2high`=$co2high, `humlow`=$humlow, `humhigh`=$humhigh, `temlow`=$temlow, `temhigh`=$temhigh WHERE $nid = $row2->nid";
    execute_sql($link, "powder", $update_sql);
}

// 定義函式來處理比較和字體顏色設定
function hydInRange($value, $low, $high) {
  $inRange = ($value >= $low && $value <= $high);
  $color = $inRange ? 'black' : 'red';

  return [
      'inRange' => $inRange,
      'color' => $color,
  ];
}

function dewInRange($value, $low, $high) {
  $inRange = ($value >= $low && $value <= $high);
  $color = $inRange ? 'black' : 'red';

  return [
      'inRange' => $inRange,
      'color' => $color,
  ];
}

function nitInRange($value, $low, $high) {
  $inRange = ($value >= $low && $value <= $high);
  $color = $inRange ? 'black' : 'red';

  return [
      'inRange' => $inRange,
      'color' => $color,
  ];
}

function co2InRange($value, $low, $high) {
  $inRange = ($value >= $low && $value <= $high);
  $color = $inRange ? 'black' : 'red';

  return [
      'inRange' => $inRange,
      'color' => $color,
  ];
}

function humInRange($value, $low, $high) {
  $inRange = ($value >= $low && $value <= $high);
  $color = $inRange ? 'black' : 'red';

  return [
      'inRange' => $inRange,
      'color' => $color,
  ];
}

function temInRange($value, $low, $high) {
  $inRange = ($value >= $low && $value <= $high);
  $color = $inRange ? 'black' : 'red';

  return [
      'inRange' => $inRange,
      'color' => $color,
  ];
}

// 檢查
$hydInfo = hydInRange($row->hyd, $hydlow, $hydhigh);
$dewInfo = dewInRange($row->dew, $dewlow, $dewhigh);
$nitInfo = nitInRange($row->nit, $nitlow, $nithigh);
$co2Info = co2InRange($row->co2, $co2low, $co2high);
$humInfo = humInRange($row->hum, $humlow, $humhigh);
$temInfo = temInRange($row->tem, $temlow, $temhigh);
?>

<!DOCTYPE html>
<html lang="en">
<meta name="viewport"
		content="width=device-width,
				initial-scale=1">
<meta http-equiv="X-UA-Compatible"
		content="ie=edge">
<meta name=
"apple-mobile-web-app-status-bar"
		content="#aa7700">
<meta name="theme-color"
		content="black">
<head>
  <link rel="manifest"
		href="/powder/manifest.json">
  <link rel="shortcut icon" href="#">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="5">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      margin: 0;
    }

    h3 {
      font-weight: bold;
    }

    input[type="text"],
    select {
      padding: 8px;
      margin-bottom: 10px;
    }

    table {
      height: 100%;
    }

    .table th,
    .table td {
      text-align: center;
      font-size: 16px;
    }
  </style>
  <title>機台即時資料</title>
</head>

<body>
  <nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="active nav-link" href="home.php">機台即時資料</a></li>
            <li class="nav-item"><a class="nav-link" href="control.php">控制介面</a></li>
            <li class="nav-item"><a class="nav-link" href="history.php">歷史氣體濃度曲線圖</a></li>
            <li class="nav-item"><a class="nav-link" href="history_table.php">機台歷史資料查詢</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="test.html">測試介面</a></li> -->
        </ul>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6" style="margin-top: 20px">
        <form name="form" method="post" action="home.php">
          <center>
            機台選擇：
            <select name="machine">
              <option value="1001">1號機台</option>
              <option value="1002">2號機台</option>
            </select>
            <button type="submit" class="btn btn-outline-dark" style="font-weight: bold;">送出</button>
          </center>
        </form>
        <br>
        <table class="table table-bordered" >
          <tr class='table-dark'>
            <td colspan='3' align='center'>
              <h3 class='font-effect-shadow-multiple'>
                <span>
                  <?php 
                    if($_SESSION["machine"] == "1001") {
                      $nid = "1";
                    }else if($_SESSION["machine"] == "1002") {
                      $nid = "2";
                    }
                    echo $nid;
                  ?>
                </span>號機台粉末冶金燒結氣體資料
              </h3>
            </td>
          </tr>
          <tr class='table-secondary'>
            <th>流水號</th>
            <td colspan='2'><?php echo $row->machine_num ?></td>
          </tr>
          <tr class='table-light'>
            <th>日期時間</th>
            <td colspan='2'><?php echo $row->uploadDT ?></td>
          </tr>
          <tr class='table-secondary'>
            <th>氫氣濃度(%)</th>
            <td colspan='2' style='color: <?php echo $hydInfo['color'] ?>'><?php echo $row->hyd ?></td>
          </tr>
          <tr class='table-secondary'>
            <th>氮氣濃度(%)</th>
            <td colspan='2' style='color: <?php echo $nitInfo['color'] ?>'><?php echo $row->nit ?></td>
          </tr>          
          <tr class='table-light'>
            <th>露點濕度(%)</th>
            <td colspan='2' style='color: <?php echo $dewInfo['color'] ?>'><?php echo $row->dew ?></td>
          </tr>
          <tr class='table-light'>
            <th>二氧化碳濃度(%)</th>
            <td colspan='2' style='color: <?php echo $co2Info['color'] ?>'><?php echo $row->co2 ?></td>
          </tr>
          <tr class='table-secondary'>
            <th>濕度(%)</th>
            <td colspan='2' style='color: <?php echo $humInfo['color'] ?>'><?php echo $row->hum ?></td>
          </tr>
          <tr class='table-light'>
            <th>溫度(ﾟC)</th>
            <td colspan='2' style='color: <?php echo $temInfo['color'] ?>'><?php echo $row->tem ?></td>
          </tr>
          <tr class='table-secondary'>
            <th rowspan='2'><p style="padding-top: 20px">氮氣：氫氣</p></th>
            <td>前端</td>
            <?php
            $gcd = $row->nit > $row->hyd ? $row->hyd : $row->nit;
            while ($row->nit % $gcd !== 0 || $row->hyd % $gcd !== 0) {
              $gcd--;
            }
            $nitt = $row->nit / $gcd;
            $hydd = $row->hyd / $gcd;
            echo "<td>{$nitt}：{$hydd}</td>";
            ?>
          </tr>
          <tr class='table-secondary'>
            <td>後端</td>
            <td>90：10</td>
          </tr>
        </table>
      </div>
    </div>   
  </div>
</body>
<script>
    const registerServiceWorker = async () => {
  if ("serviceWorker" in navigator) {
    try {
      const registration = await navigator.serviceWorker.register("serviceworker.js", {
        scope: "/powder/",
      });
      if (registration.installing) {
        console.log("Service worker installing");
      } else if (registration.waiting) {
        console.log("Service worker installed");
      } else if (registration.active) {
        console.log("Service worker active");
      }
    } catch (error) {
      console.error(`Registration failed with ${error}`);
    }
  }
};
// …
registerServiceWorker();

 </script>
</html>
