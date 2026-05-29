import paho.mqtt.client as mqtt
import requests
import time
import logging
import os
import random
import datetime
from dotenv import load_dotenv
from escpos.printer import Serial

# --- Configuration ---
chemin_env = '/var/www/html/borne-ihm-sauvegarde/.env'
load_dotenv(dotenv_path=chemin_env)
URL_API_ADAM = os.getenv('API_URL')

logging.basicConfig(level=logging.INFO)
log = logging.getLogger("ecobox")

BASE_URL = "http://localhost/borne-ihm-sauvegarde/public/index.php"
SERIAL_PORT = "/dev/ttyUSB0"
SERIAL_BAUD = 9600

def get_next_ticket_number():
    path = '/var/www/html/borne-ihm-sauvegarde/writable/ticket_counter.txt'
    fallback_path = '/dev/shm/ticket_counter.txt'
    
    # Tente d'écrire sur le chemin primaire puis secondaire en cas d'erreur de droits
    for p in [path, fallback_path]:
        try:
            num = 1
            if os.path.exists(p):
                with open(p, 'r') as f:
                    content = f.read().strip()
                    num = int(content) + 1 if content.isdigit() else 1
            with open(p, 'w') as f:
                f.write(str(num))
            return num
        except Exception:
            continue
            
    # Fallback ultime basé sur le timestamp UNIX si l'écriture échoue partout
    return int(time.time()) % 100000

def imprimer_ticket(nb_bouteilles):
    if nb_bouteilles <= 0:
        log.warning("Impression ignorée car le nombre de bouteilles est de 0.")
        return
        
    try:
        # Calcul du montant en Euros (0.02€ par bouteille de PET)
        montant = nb_bouteilles * 0.02
        
        # Récupération de l'heure et de la date du jour
        maintenant = datetime.datetime.now()
        heure_str = maintenant.strftime("%H:%M")
        date_str = maintenant.strftime("%d/%m/%y")
        
        # Récupération du numéro de ticket incrémenté
        ticket_num = get_next_ticket_number()
        
        # Identifiant unique de bon d'achat pour le code-barres (5 chiffres aléatoires)
        voucher_id = random.randint(10000, 99999)
        barcode_digits = f"2000000{voucher_id:05d}"
        
        # Connexion physique à l'imprimante de la borne
        p = Serial(devfile=SERIAL_PORT, baudrate=SERIAL_BAUD, bytesize=8, parity='N', stopbits=1, timeout=2.00, xonxoff=False, dsrdtr=False)
        
        # 1. Bordure supérieure étoilée
        p.set(align='center', bold=False, width=1, height=1)
        p.text("******************************************\n")
        
        # 2. Grand titre "BON D'ACHAT"
        p.set(align='center', bold=True, width=2, height=2)
        p.text("BON D'ACHAT\n")
        
        # 3. Bordure intermédiaire
        p.set(align='center', bold=False, width=1, height=1)
        p.text("******************************************\n")
        
        # 4. Le montant en inverse (blanc sur fond noir)
        p.set(align='center', bold=True, width=3, height=3, invert=True)
        p.text(f" {montant:.2f} \n")
        p.text(" EUROS \n")
        
        # Réinitialisation du style normal
        p.set(align='center', bold=False, width=1, height=1, invert=False)
        p.text("\n")
        
        # 5. Bloc Date / Heure / Validité
        p.set(align='left', bold=False, width=1, height=1)
        indent = "            "
        p.text(f"{indent}Heure : {heure_str}\n")
        p.text(f"{indent}Date : {date_str}\n")
        p.text(f"{indent}Valable : 1 mois\n\n")
        
        # 6. Conditions de validité magasin
        p.set(align='center', bold=False, width=1, height=1)
        p.text("Valable uniquement au\n")
        p.text("magasin E.Leclerc\n")
        p.text("Bailleul\n\n")
        
        # 7. Code-barres EAN13
        p.set(align='center')
        p.barcode(barcode_digits, 'EAN13', width=2, height=80, pos='BELOW')
        p.text("\n")
        
        # 8. Métadonnées bas de ticket (Machine # et Ticket #)
        p.set(align='center', bold=False, width=1, height=1)
        p.text("Machine # 054571\n")
        p.text(f"Ticket # {ticket_num:05d}\n\n\n")
        
        # Coupe papier et fermeture de la connexion
        p.cut()
        p.close()
        log.info(f"Ticket imprimé : {nb_bouteilles} bouteilles -> {montant:.2f} EUR (Ticket #{ticket_num})")
        
    except Exception as e:
        log.error(f"Erreur lors de l'impression sur {SERIAL_PORT} : {e}")

def on_message(client, userdata, msg):
    topic = msg.topic
    payload = msg.payload.decode('utf-8').strip()

    log.info(f"Message MQTT reçu : {topic} -> {payload}")

    try:
        if topic == "ecobox/accepte":
            requests.post(f"{BASE_URL}/ajouter_bouteille", timeout=5)

        elif topic in ["ecobox/rejet", "ecobox/refuse"]:
            requests.post(f"{BASE_URL}/signaler_erreur", data={"motif": payload}, timeout=5)

        elif topic == "ecobox/imprimer":
            nb = int(payload) if payload.isdigit() else 0
            imprimer_ticket(nb)

        # 4. VÉRIFICATION DU CODE-BARRES AVEC L'API D'ADAM (Version URL Token)
        elif topic == "ecobox/scan":
            code_brut = payload
            if len(code_brut) >= 13:
                code_barre = code_brut[-13:]
            else:
                code_barre = code_brut

            log.info(f"Code nettoyé: {code_barre} | Vérification API Adam...")

            if URL_API_ADAM:
                try:
                    # TECHNIQUE BULLDOZER : Jeton dans l'URL pour éviter les erreurs 401 de headers
                    url_complete = f"{URL_API_ADAM}/{code_barre}?token=MonJetonBorne123"

                    reponse = requests.get(url_complete, timeout=2)

                    if reponse.status_code == 200:
                        log.info("API OK : Bouteille valide. Ordre -> CODE_VALIDE")
                        client.publish("ecobox/action", "CODE_VALIDE")
                    else:
                        log.warning(f"API REFUS ({reponse.status_code}) | Msg: {reponse.text}")
                        client.publish("ecobox/action", "CODE_REFUSE")

                except requests.exceptions.RequestException as e:
                    log.error(f"Erreur réseau API : {e}")
                    client.publish("ecobox/action", "CODE_REFUSE")
            else:
                log.error("ERREUR : API_URL non définie dans .env")

        elif topic == "ecobox/status":
            with open("/dev/shm/ecobox_etat.txt", "w") as f:
                f.write(payload)

    except Exception as e:
        log.error(f"Erreur inattendue : {e}")

def on_connect(client, userdata, flags, rc, *args):
    if rc == 0:
        log.info("✅ Python connecté au broker MQTT !")
        client.subscribe("ecobox/#")
    else:
        log.error(f"❌ Échec MQTT code: {rc}")

client = mqtt.Client()
client.on_connect = on_connect
client.on_message = on_message

log.info("⏳ Lancement du pont Crystarecycle...")
client.connect("127.0.0.1", 1883, 60)
client.loop_forever()
