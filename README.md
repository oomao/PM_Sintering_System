# 🏭 粉末冶金燒結製程 IoT 監控系統

## PM Sintering Process IoT Monitoring System

> 應用物聯網技術監控優化粉末冶金燒結過程之整合系統

本系統為畢業專題作品，旨在透過 IoT 技術即時監控粉末冶金燒結製程中的關鍵氣體參數，提升製程品質與效率。

---

## 📋 目錄

- [系統架構](#-系統架構)
- [功能特色](#-功能特色)
- [技術棧](#-技術棧)
- [專案結構](#-專案結構)
- [安裝與部署](#-安裝與部署)
- [系統截圖](#-系統截圖)
- [Live Demo](#-live-demo)
- [研討會發表](#-研討會發表)
- [作者](#-作者)

---

## 🏗 系統架構

```
┌──────────────┐     MQTT      ┌──────────────┐     MySQL     ┌──────────────┐
│   ESP32      │──────────────▶│  MQTT Broker  │──────────────▶│   PHP Web    │
│  感測器模組   │   Publisher   │  (Mosquitto)  │  Subscriber   │   監控平台    │
│              │               │               │               │              │
│ • 氫氣感測器  │               │               │               │ • 即時資料    │
│ • 氮氣感測器  │               └──────────────┘               │ • 控制介面    │
│ • 露點感測器  │                                               │ • 歷史曲線    │
│ • CO₂感測器  │                                               │ • 資料查詢    │
│ • 溫濕度感測器│                                               │              │
└──────────────┘                                               └──────────────┘
```

---

## ✨ 功能特色

### 🔍 即時監控
- 即時顯示機台氣體濃度數據（氫氣、氮氣、露點濕度、CO₂、溫度、濕度）
- 數值異常時自動以紅色標示警告
- 自動計算氮氣：氫氣比例
- 每 5 秒自動刷新數據

### ⚙️ 控制介面
- 可設定各項氣體濃度的安全範圍上下限
- 支援多台機台切換（1號、2號機台）
- 輸入驗證（確保下限不大於上限）

### 📈 歷史數據分析
- 各氣體濃度歷史曲線圖（折線圖）
- 氮氣：氫氣堆疊百分比長條圖
- 支援按日期區間查詢歷史資料表

### 📱 PWA 支援
- 支援 Progressive Web App，可安裝至手機桌面
- Service Worker 離線快取

---

## 🛠 技術棧

| 類別 | 技術 |
|------|------|
| **硬體** | ESP32 微控制器 |
| **通訊協定** | MQTT (Mosquitto Broker) |
| **後端** | PHP 7+, phpMQTT |
| **資料庫** | MySQL / MariaDB |
| **前端** | HTML5, CSS3, JavaScript |
| **UI 框架** | Bootstrap 5.3 |
| **圖表** | AnyChart 8.11 |
| **PWA** | Service Worker, Web App Manifest |
| **IDE** | Arduino IDE (韌體開發) |

---

## 📁 專案結構

```
PM_Sintering_System/
│
├── firmware/                          # ESP32 韌體程式
│   ├── esp32-sensor-publisher/        # 感測器數據發佈端
│   │   └── esp32-sensor-publisher.ino
│   └── esp32-mqtt-subscriber/         # MQTT 訂閱接收端
│       └── esp32-mqtt-subscriber.ino
│
├── backend/                           # PHP 後端（MQTT 訂閱 & 資料庫寫入）
│   ├── config.php                     # MQTT 連線設定
│   ├── phpMQTT.php                    # PHP MQTT 函式庫
│   ├── subscribe.php                  # MQTT 訂閱 → 寫入資料庫
│   ├── publish.php                    # MQTT 發佈介面
│   └── dbtools.inc.php                # 資料庫工具函式
│
├── web/                               # Web 前端監控平台
│   ├── home.php                       # 機台即時資料頁面
│   ├── control.php                    # 控制介面（設定安全範圍）
│   ├── history.php                    # 歷史氣體濃度曲線圖
│   ├── history_table.php              # 機台歷史資料查詢
│   ├── test.html                      # 測試資料輸入表單
│   ├── test.php                       # 測試資料寫入處理
│   ├── dbtools.inc.php                # 資料庫工具函式
│   ├── manifest.json                  # PWA Manifest
│   ├── serviceworker.js               # Service Worker
│   └── images/                        # 圖片資源
│
├── database/                          # 資料庫
│   └── powder.sql                     # MySQL 資料庫匯出檔
│
├── demo/                              # Live Demo（靜態展示版）
│   └── index.html
│
├── docs/                              # 文件資料
│   ├── 研討會報告.png
│   ├── 論文發表證明.pdf
│   └── 應用物聯網技術監控優化粉末冶金燒結過程之整合系統.docx
│
├── .env.example                       # 環境變數範本
├── .gitignore
└── README.md
```

---

## 🚀 安裝與部署

### 前置需求

- PHP 7.0+
- MySQL / MariaDB
- MQTT Broker（如 Mosquitto）
- Arduino IDE（韌體燒錄）
- ESP32 開發板

### 1. 資料庫設定

```bash
# 匯入資料庫
mysql -u root -p < database/powder.sql
```

### 2. 環境變數設定

```bash
# 複製環境變數範本
cp .env.example .env

# 編輯 .env 填入您的設定
```

### 3. 啟動 MQTT Broker

```bash
# 安裝 Mosquitto
sudo apt install mosquitto mosquitto-clients

# 啟動
sudo systemctl start mosquitto
```

### 4. 啟動 PHP 後端

```bash
# 啟動 MQTT 訂閱服務（持續運行）
php backend/subscribe.php

# 啟動 Web 伺服器
php -S localhost:8080 -t web/
```

### 5. 燒錄 ESP32 韌體

1. 在 Arduino IDE 中開啟 `firmware/esp32-sensor-publisher/esp32-sensor-publisher.ino`
2. 修改 WiFi 及 MQTT 連線資訊
3. 選擇正確的開發板與連接埠
4. 上傳韌體

---

## 📸 系統截圖

| 即時監控頁面 | 控制介面 |
|:---:|:---:|
| 顯示各項氣體即時數據 | 設定安全範圍上下限 |

| 歷史曲線圖 | 歷史資料表 |
|:---:|:---:|
| 各氣體濃度趨勢圖 | 按日期區間查詢 |

---

## 🌐 Live Demo

👉 [**點擊查看 Live Demo**](https://oomao.github.io/PM_Sintering_System/)

> 注意：Live Demo 為靜態展示版本，使用模擬數據呈現系統介面與功能。實際系統需搭配 ESP32 硬體、MQTT Broker 及 MySQL 資料庫運行。

---

## 📄 研討會發表

本專題作品發表於：

**2024 管理、商業與資訊國際學術研討會**
*(2024 International Conference on Management, Business and Information, ICMBI 2024)*

相關證明文件請參閱 `docs/` 資料夾。

---

## 👥 作者

**本系統為畢業專題作品**

| 角色 | 姓名 |
|------|------|
| **指導教師** | 張朝旭 教授 |
| **團隊成員** | 黃柏瑜 |
| | 陳盛茂 |
| | 林士庭 |
| | 羅珮綺 |
| | 陳芊慈 |
| | 李佳軒 |
