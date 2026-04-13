<?php
// 在這裡放置與數據庫連接的代碼
require_once("dbtools.inc.php");

//建立資料連接
$link = create_connection();

$sql = "SELECT DISTINCT machine_num FROM machine_history";
$result = execute_sql($link, "powder", $sql);
$machineNums = mysqli_fetch_object($result);

// 如果提交了查詢表單

$selectedMachineNum = $startDateTime = $endDateTime = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["machine_num"])) {
    $selectedMachineNum = $_POST["machine_num"];
  }
  if (isset($_POST["start_date"])) {
    $startDateTime = $_POST["start_date"];
  }
  if (isset($_POST["end_date"])) {
    $endDateTime = $_POST["end_date"];
  }

  // 構建查詢語句
  $query = "SELECT * FROM machine_history WHERE 1";

  if (!empty($selectedMachineNum)) {
    $query .= " AND machine_num = $selectedMachineNum";
  }

  // 修改為日期時間的區間查詢
  if (!empty($startDateTime) && !empty($endDateTime)) {
    $query .= " AND uploadDT BETWEEN '$startDateTime' AND '$endDateTime'";
  }

  $result2 = mysqli_query($link, $query);
  $data = mysqli_fetch_all($result2, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>機台歷史資料查詢</title>

  <style>
    body {
      font-family: 'Helvetica Neue', Arial, sans-serif;
      background-color: #f8f9fa;
      color: #212529;
      line-height: 1.5;
    }

    h3 {
      font-weight: bold;
    }

    form {
      margin-bottom: 20px;
    }

    label {
      margin-right: 10px;
    }

    input[type="text"],
    input[type="date"],
    select {
      padding: 8px;
      margin-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #343A40;
      color: #fff;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar1">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="home.php">機台即時資料</a></li>
            <li class="nav-item"><a class="nav-link" href="control.php">控制介面</a></li>
            <li class="nav-item"><a class="nav-link" href="history.php">歷史氣體濃度曲線圖</a></li>
            <li class="nav-item"><a class="active nav-link" href="history_table.php">機台歷史資料查詢</a></li>
            <!-- <li class="nav-item"><a class="nav-link" href="test.html">測試介面</a></li> -->
        </ul>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h3 class='font-effect-shadow-multiple'>機台歷史資料查詢</h3>
        <form action="" method="post">
          <label for="machine_num">選擇機台：</label>
          <select name="machine_num" id="machine_num">
            <option value="1001">1號機台</option>
            <option value="1002">2號機台</option>
          </select>

          <label for="start_date">開始日期：</label>
          <input type="date" name="start_date" id="start_date">

          <label for="end_date">結束日期：</label>
          <input type="date" name="end_date" id="end_date">

          <button type="submit" class="btn btn-outline-dark" style="font-weight: bold;">查詢</button>
        </form>

        <?php
        // 如果有查詢結果，顯示表格
        if (isset($data)) {
          echo "<h3>查詢結果：</h3>";
          echo "<table>";
          echo "<tr><th>流水號</th><th>日期時間</th><th>氫氣濃度(%)</th><th>氮氣濃度(%)</th><th>露點濕度(%)</th><th>二氧化碳濃度(%)</th><th>濕度(%)</th><th>溫度(℃)</th></tr>";

          foreach ($data as $row) {
            echo "<tr>";
            echo "<td>{$row['machine_num']}</td>";
            echo "<td>{$row['uploadDT']}</td>";
            echo "<td>{$row['hyd']}</td>";
            echo "<td>{$row['nit']}</td>";            
            echo "<td>{$row['dew']}</td>";
            echo "<td>{$row['co2']}</td>";
            echo "<td>{$row['hum']}</td>";
            echo "<td>{$row['tem']}</td>";
            echo "</tr>";
          }

          echo "</table>";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>