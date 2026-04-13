<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <meta http-equiv="refresh" content="5"> -->
  <title>歷史氣體濃度曲線圖</title>
  <script src="https://cdn.anychart.com/releases/8.11.1/js/anychart-base.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <style type="text/css">
    html,
    body,
    #hyd-container,
    #nit-container {
      width: 100%;
      height: 92%;
      margin: 0;
      padding: 0;
    }

    input[type="text"],
    select {
      padding: 8px;
      margin-bottom: 10px;
    }

    a {
      text-decoration: none;
    }
  </style>
</head>

<body>
  <br>
  <div id="hyd-container"></div>
    <script>
      anychart.onDocumentReady(function () {
        <?php
        session_start();
        require_once("dbtools.inc.php");
        //建立資料連接
        $link = create_connection();

        if (isset($_POST["select_machine"])) {
          $machine = $_POST["select_machine"];
          $_SESSION["select_machine"] = $machine;
        } else {
          $machine = $_SESSION["select_machine"];
        }
        if (isset($_POST["choose"])) {
          $choose= $_POST["choose"];
        }
        $sql = "SELECT * FROM `machine_history` WHERE `machine_num` = '{$_SESSION["select_machine"]}'";
        $result = execute_sql($link, "powder", $sql);

        // 添加數據
        $data = array();

        while ($row = mysqli_fetch_object($result)) {
          // 將每一行的資料添加到數組中
          if($choose == "HN") {
            $data[] = array($row->uploadDT, $row->hyd, $row->nit);
          }else {
            $data[] = array($row->uploadDT, $row->$choose);
          }
        }
        $data = array_slice($data, -10);
      ?>
        // 將PHP陣列轉換為JavaScript變數
        var data = <?php echo json_encode($data); ?>;
        // 創建數據集
        var dataSet = anychart.data.set(data);
        // 為所有系列映射數據
        var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });
        //創建折線圖
        var chart = anychart.line();
        // 創建系列並命名
        var firstSeries = chart.line(firstSeriesData);
        var jsVariable = <?php echo json_encode($choose); ?>;
        if(jsVariable=="hyd"){
        firstSeries.name("氫氣濃度(%)");
        // 添加標題並自定義参數
        chart
          .title()
          .enabled(true)
          .useHtml(true)
          .text(
            '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>氫氣歷史曲線圖</span>'
          );
        //y軸格線
        chart.yGrid(true);
        // 命名軸
        chart.yAxis().title("氫氣濃度(%)");

        chart.xAxis().title("時間");
        // 自定義標記
        firstSeries.markers().enabled(true).type("circle").size(4);
        // 開啟十字軸，並且去掉十字軸的Y軸
        chart.crosshair().enabled(true).yStroke(null).yLabel(false);
        // 改變工具提示的位置
        chart.tooltip().positionMode("point");
        chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
        // 在普通狀態下改變系列折線樣式
        firstSeries.normal().stroke("#E07A5F", 2.5);
        // 設置在哪里放置折線圖
        chart.container("hyd-container");
        // 繪製折線圖
        chart.draw();
        }else if(jsVariable=="dew"){
        firstSeries.name("露點濕度(%)");
        // 添加標題並自定義参數
        chart
          .title()
          .enabled(true)
          .useHtml(true)
          .text(
            '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>露點濕度歷史曲線圖</span>'
          );
        //y軸格線
        chart.yGrid(true);
        // 命名軸
        chart.yAxis().title("露點濕度(%)");

        chart.xAxis().title("時間");
        // 自定義標記
        firstSeries.markers().enabled(true).type("circle").size(4);
        // 開啟十字軸，並且去掉十字軸的Y軸
        chart.crosshair().enabled(true).yStroke(null).yLabel(false);
        // 改變工具提示的位置
        chart.tooltip().positionMode("point");
        chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
        // 在普通狀態下改變系列折線樣式
        firstSeries.normal().stroke("#E07A5F", 2.5);
        // 設置在哪里放置折線圖
        chart.container("hyd-container");
        // 繪製折線圖
        chart.draw();
        }else if(jsVariable=="nit"){
        firstSeries.name("氮氣濃度(%)");
        // 添加標題並自定義参數
        chart
          .title()
          .enabled(true)
          .useHtml(true)
          .text(
            '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>氮氣歷史曲線圖</span>'
          );
        //y軸格線
        chart.yGrid(true);
        // 命名軸
        chart.yAxis().title("氮氣濃度(%)");

        chart.xAxis().title("時間");
        // 自定義標記
        firstSeries.markers().enabled(true).type("circle").size(4);
        // 開啟十字軸，並且去掉十字軸的Y軸
        chart.crosshair().enabled(true).yStroke(null).yLabel(false);
        // 改變工具提示的位置
        chart.tooltip().positionMode("point");
        chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
        // 在普通狀態下改變系列折線樣式
        firstSeries.normal().stroke("#E07A5F", 2.5);
        // 設置在哪里放置折線圖
        chart.container("hyd-container");
        // 繪製折線圖
        chart.draw();
        }else if(jsVariable=="co2"){
        firstSeries.name("二氧化碳濃度(%)");
        // 添加標題並自定義参數
        chart
          .title()
          .enabled(true)
          .useHtml(true)
          .text(
            '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>二氧化碳歷史曲線圖</span>'
          );
        //y軸格線
        chart.yGrid(true);
        // 命名軸
        chart.yAxis().title("二氧化碳濃度(%)");

        chart.xAxis().title("時間");
        // 自定義標記
        firstSeries.markers().enabled(true).type("circle").size(4);
        // 開啟十字軸，並且去掉十字軸的Y軸
        chart.crosshair().enabled(true).yStroke(null).yLabel(false);
        // 改變工具提示的位置
        chart.tooltip().positionMode("point");
        chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
        // 在普通狀態下改變系列折線樣式
        firstSeries.normal().stroke("#E07A5F", 2.5);
        // 設置在哪里放置折線圖
        chart.container("hyd-container");
        // 繪製折線圖
        chart.draw();
        }else if(jsVariable=="hum"){
        firstSeries.name("濕度(%)");
        // 添加標題並自定義参數
        
        chart
          .title()
          .enabled(true)
          .useHtml(true)
          .text(
            '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>濕度歷史曲線圖</span>'
          );
        //y軸格線
        chart.yGrid(true);
        // 命名軸
        chart.yAxis().title("濕度(%)");

        chart.xAxis().title("時間");
        // 自定義標記
        firstSeries.markers().enabled(true).type("circle").size(4);
        // 開啟十字軸，並且去掉十字軸的Y軸
        chart.crosshair().enabled(true).yStroke(null).yLabel(false);
        // 改變工具提示的位置
        chart.tooltip().positionMode("point");
        chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
        // 在普通狀態下改變系列折線樣式
        firstSeries.normal().stroke("#E07A5F", 2.5);
        // 設置在哪里放置折線圖
        chart.container("hyd-container");
        // 繪製折線圖
        chart.draw();
        }else if(jsVariable=="tem"){
        firstSeries.name("溫度(ﾟC)");
        // 添加標題並自定義参數
        chart
          .title()
          .enabled(true)
          .useHtml(true)
          .text(
            '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>溫度歷史曲線圖</span>'
          );
        //y軸格線
        chart.yGrid(true);
        // 命名軸
        chart.yAxis().title("溫度(ﾟC)");

        chart.xAxis().title("時間");
        // 自定義標記
        firstSeries.markers().enabled(true).type("circle").size(4);
        // 開啟十字軸，並且去掉十字軸的Y軸
        chart.crosshair().enabled(true).yStroke(null).yLabel(false);
        // 改變工具提示的位置
        chart.tooltip().positionMode("point");
        chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
        // 在普通狀態下改變系列折線樣式
        firstSeries.normal().stroke("#E07A5F", 2.5);
        // 設置在哪里放置折線圖
        chart.container("hyd-container");
        // 繪製折線圖
        chart.draw();
        }else if(jsVariable=="HN") {
          // 創建堆疊直方圖
          var chart = anychart.column();
          // 創建系列並命名
          var Series1 = chart.column(firstSeriesData);
          var Series2 = chart.column(firstSeriesData);

          Series1.name("氫氣");
          Series2.name("氮氣");

          Series1.normal().stroke("#FFD494", 2.5).fill("#FFD494", 2.5);
          Series2.normal().stroke("#FEA38A", 2.5).fill("#FEA38A", 2.5);

          // 添加圖例
          chart.legend().enabled(true);
          chart.data(data);  
          // %
          chart.yScale().stackMode("percent");
          // 工具樣式
          chart.tooltip().position("right").anchor("left-center").offsetX(5).offsetY(5);
          chart.yAxis().labels().format("{%Value}%");
          // 主題
          chart
            .title()
            .enabled(true)
            .useHtml(true)
            .text(
              '<span style="color: black; font-weight: bold; font-size:20px;"><?php echo $_SESSION["select_machine"] ?>氫氣：氮氣歷史堆疊長條圖</span>'
            );
            //y軸格線
            chart.yGrid(true);
            // 命名軸
            chart.yAxis().title("氫氣：氮氣");
            chart.xAxis().title("時間");
            chart.container("hyd-container");
            chart.draw();
        }
      });
    </script>

  <form name="form" method="post" action="history.php">
    <center>
      機台選擇：
      <select name="select_machine">
        <option value="1001">1號機台</option>
        <option value="1002">2號機台</option>
      </select>

      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="hyd">氫氣</button>
      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="nit">氮氣</button>
      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="HN">氮氣&氫氣</button>
      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="dew">露點濕度</button>
      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="co2">二氧化碳</button>
      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="hum">濕度</button>
      <button type="submit" class="btn btn-outline-dark btn-lg" style="font-weight: bold;" name="choose" value="tem">溫度</button>
      <a class="btn btn-outline-danger btn-lg" style="font-weight: bold;" href="home.php">回即時資料頁面</a>
    </center>
  </form>
</body>

</html>