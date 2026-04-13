<?php
// date_default_timezone_set("Asia/Taipei");
// 引入所需的 PHP MQTT 函式庫和配置檔
// ignore_user_abort(false); // 腳本執行不受用戶中斷影響
// set_time_limit(0); // 移除執行時間限制
set_time_limit(0);
require("phpMQTT.php");
require("config.php");

// 建立一個 MQTT 客戶端實例
$mqtt = new bluerhinos\phpMQTT($host, $port, "tttttest".rand());

// 指定訂閱的主題
$topicName = 'test/#';

// 連接到 MQTT 伺服器
if(!$mqtt->connect(true, NULL, $username, $password)){
  exit(1);
}

// 設定訂閱的主題和對應的 QoS 等級，並指定訊息處理函式為 "procmsg"
$topics[$topicName] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);

// 持續處理 MQTT 訊息，直到程式退出
while($mqtt->proc()){

}
$mqtt->close();

function procmsg($topic, $msg) {
  // 切割字串以提取數據
  $stringArr = explode(",", $msg);
  date_default_timezone_set("Asia/Taipei");

  $current_time = date('Y-m-d H:i:s');

  // 建立資料庫連線
  $conn = new mysqli("localhost", "root", "", "powder");

  // 檢查連線是否成功
  if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
  }

  // 準備插入查詢的預備語句
  $insertDataQuery = "INSERT INTO machine_history (machine_num, powder_id, hyd, dew, nit, co2, hum, tem, uploadDT) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($insertDataQuery);

  // 確認預備語句準備成功
  if (!$stmt) {
    die("預備語句準備失敗: \n" . $conn->error);
  }

  // 將變量绑定到預備語句的參數
  $stmt->bind_param("siiiiidds", $machine_num, $powder_id, $hyd, $dew, $nit, $co2, $hum, $tem, $uploadDT);

  // 設置變量的值
  $machine_num = $stringArr[0];
  $powder_id = "";
  $hyd = (int)$stringArr[4];
  $dew = (int)$stringArr[1];
  $nit = (int)$stringArr[3];
  $co2 = (int)$stringArr[2];
  $hum = (float)$stringArr[6];
  $tem = (float)$stringArr[5];
  $uploadDT = $current_time;

  // 執行預備語句
  if ($stmt->execute()) {
    echo "資料已新增\n";
  } else {
    echo "新增資料時發生錯誤: " . $stmt->error;
  }

  // 關閉預備語句
  $stmt->close();
  // 關閉數據庫連接
  $conn->close();
}
?>
