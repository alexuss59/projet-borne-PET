import paho.mqtt.client as mqtt

# Configuration
MQTT_BROKER = "127.0.0.1"
MQTT_TOPIC = "borne/client/scan"

# Utilisation de l'API Version 2 (standard actuel)
client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)

try:
    client.connect(MQTT_BROKER, 1883, 60)
    print("✅ Connecté au Broker MQTT local")
except Exception as e:
    print(f"❌ Erreur : Mosquitto n'est pas lancé sur le Pi : {e}")
    exit(1)

print("--- LECTEUR QR PRÊT ---")

while True:
    try:
        # Le module 14810 simule un clavier + Entrée
        customer_id = input().strip() 
        
        if customer_id:
            print(f"Scan reçu : {customer_id}")
            client.publish(MQTT_TOPIC, customer_id)
            print(f"ID envoyé à l'IHM sur le topic : {MQTT_TOPIC}")
            
    except KeyboardInterrupt:
        break