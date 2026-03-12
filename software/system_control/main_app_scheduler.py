from apscheduler.schedulers.background import BackgroundScheduler
import subprocess
import datetime
import threading
import requests
import time
import deteksi

# ========================
# CONFIG WEB COMMAND
# ========================
URL_GET = "https://smartharvest.online/assets/php/get_command.php"
URL_DONE = "https://smartharvest.online/assets/php/done_command.php"

headers = {
    "User-Agent": "Mozilla/5.0",
    "Accept": "*/*"
}

scheduler = BackgroundScheduler()
deteksi_lock = threading.Lock()


# ========================
# FUNGSI KAMERA
# ========================
def set_kamera_home():
    deteksi.rotateCamera("DEFAULT")
    time.sleep(2)
    deteksi.rotateCamera("HOME")
    deteksi.setupGPIO()
    #if deteksi.bacaStopper():
     #   deteksi.tarik(10, 1)


# ========================
# FUNGSI DETEKSI
# ========================
def jalankan_deteksi():
    if deteksi_lock.locked():
        print("Deteksi masih berjalan, skip...")
        return

    with deteksi_lock:
        print("Deteksi dijalankan:", datetime.datetime.now())

        # Gunakan run supaya blocking dan lock benar-benar efektif
        subprocess.run(
            ["/home/ubuntu2025/Desktop/yolov8/venv3.10/bin/python", "/home/ubuntu2025/Desktop/yolov8/source_code/deteksi.py"]
        )

        print("Deteksi selesai")


# ========================
# POLLING WEB MANUAL COMMAND
# ========================
def polling_web_command():
    while True:
        try:
            r = requests.get(URL_GET, headers=headers, timeout=10).json()

            if r.get("command"):
                print("COMMAND dari web:", r)

                if r["command"] == "scan":
                    requests.post(
                        URL_DONE,
                        data={"id": r["id"]},
                        headers=headers,
                        timeout=10
                    )
                    jalankan_deteksi()

                

        except Exception as e:
            print("Error polling:", e)

        time.sleep(10)


# ========================
# INIT SISTEM
# ========================
print("Set kamera ke HOME")
set_kamera_home()

print("Start scheduler 10:00")

# Jadwal otomatis (ubah sesuai kebutuhan)
#scheduler.add_job(jalankan_deteksi, 'interval', minutes=30)
scheduler.add_job(jalankan_deteksi, 'cron', hour=10, minute=00)
scheduler.start()

# Start polling thread
threading.Thread(target=polling_web_command, daemon=True).start()

print("Sistem berjalan 10:00...")

# Loop utama agar program tidak exit
while True:
    time.sleep(60)
