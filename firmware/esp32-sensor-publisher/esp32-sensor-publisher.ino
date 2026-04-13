#include <WiFi.h>
#include <PubSubClient.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

// ========== Configuration ==========
// Please update these values with your own credentials
const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";

// MQTT broker settings
const char* mqtt_server = "YOUR_MQTT_HOST";
const int mqtt_port = 1883; 
const char* mqtt_username = "YOUR_MQTT_USER"; 
const char* mqtt_password = "YOUR_MQTT_PASS";
// ====================================

#define DHT11PIN 2

WiFiClient espClient;
PubSubClient client(espClient);

void setup() {
  Serial.begin(115200);
  delay(10);
  // 連接WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  // 連接到MQTT代理
  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);

  while (!client.connected()) {
    Serial.println("Connecting to MQTT...");
    if (client.connect("ArduinoClient", mqtt_username, mqtt_password)) {
      Serial.println("Connected to MQTT");
    } else {
      Serial.print("Failed, rc=");
      Serial.print(client.state());
      Serial.println(" Trying again in 5 seconds...");
      delay(6000);
    }
  }

  // 訂閱主題
  client.subscribe("test");
}

void loop() {
  String message = "bobobobo";
  if (client.connected()) {
    client.publish("test", message.c_str()); 
    client.subscribe("test");
  }

  // 處理MQTT消息
  client.loop();

  // 延遲10秒
  delay(10000);
}


int generateRandomNumber(int min, int max) {
  int randomInt = rand();
  int randomNumber = (randomInt % (max - min + 1)) + min;
  return randomNumber;
}

void callback(char* topic, byte* payload, unsigned int length) {
  Serial.print("Message received in topic: ");
  Serial.println(topic);

  Serial.print("Message:");
  for (int i = 0; i < length; i++) {
    Serial.print((char)payload[i]);
  }
  Serial.println();
}