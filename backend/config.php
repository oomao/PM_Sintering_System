<?php
// ========== MQTT Configuration ==========
// Please update these values with your own credentials
// Or set them as environment variables
$host     = getenv('MQTT_HOST') ?: "YOUR_MQTT_HOST";
$port     = getenv('MQTT_PORT') ?: 1883;
$username = getenv('MQTT_USERNAME') ?: "YOUR_MQTT_USER";
$password = getenv('MQTT_PASSWORD') ?: "YOUR_MQTT_PASS";
?>