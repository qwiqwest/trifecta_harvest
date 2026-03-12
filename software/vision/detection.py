import time
import requests
import subprocess
import RPi.GPIO as GPIO
from ultralytics import YOLO
import cv2


JUMLAH_BARIS = 2
MAX_RETRY = 1  # supaya tidak infinite loop

#Definisi pin
#17 -> lampu
#22 -> tarik
#27 -> ulur

MOTOR_GPIO_ACTIVE = True

# Gunakan penomoran BCM
GPIO.setmode(GPIO.BCM)

# Daftar pin
pinLampu = 17
pinTarik = 22
pinUlur = 27
pinMagnet = 26
pinStopper = 20
pins = [pinLampu, pinTarik, pinUlur, pinMagnet, pinStopper]

a1 = 0
a2 = 0
b1 = 0
b2 = 0

payload = {
    "a1":a1,
    "a2":a2,
    "b1":b1,
    "b2":b2
}

url = "https://smartharvest.online/assets/php/api_insert.php"

model = YOLO(r"/home/ubuntu2025/Desktop/yolov8/best.pt")

headers = {
    "User-Agent": "Mozilla/5.0",
    "Accept": "*/*"
}

#===FUNCTION===
def deteksi_jeruk(path, filename):
    result = model(path +filename +".jpg")
    result[0].save(filename= path + filename +"_dtc.jpg")
    jumlah_matang = 0
    jumlah_mentah = 0

    for box in result[0].boxes:
        cid = int(box.cls)

        if cid == 0:
            jumlah_matang += 1
        elif cid == 1:
            jumlah_mentah += 1

    return jumlah_mentah, jumlah_matang

def kirim_ke_database():
    payload = {
        "a1":a1,
        "a2":a2,
        "b1":b1,
        "b2":b2
    }
    print(payload)
    r = requests.post(
    url,
    data=payload,
    headers=headers,
    timeout=15,
    allow_redirects=True
    )
    print(r.status_code)
    print(r.text)
    
def bacaStopper():
    state = GPIO.input(pinStopper)
    print(state)
    return state

def setupGPIO():
    GPIO.setmode(GPIO.BCM)
    GPIO.setup(pins, GPIO.OUT)
    GPIO.setup(pinLampu, GPIO.OUT)
    GPIO.setup(pinMagnet, GPIO.IN)
    GPIO.setup(pinStopper, GPIO.IN)

def tarik(onDelay):
    
    GPIO.output(pinLampu, GPIO.HIGH)
    GPIO.output(pinTarik, GPIO.HIGH)
    print("tarik on")
    time.sleep(onDelay)
                
    GPIO.output(pinTarik, GPIO.LOW)
    print("tarik off")
    
    GPIO.output(pinLampu, GPIO.LOW)
            
        
    
def ulur(onDelay, offDelay):
    GPIO.output(pinLampu, GPIO.HIGH)
    if MOTOR_GPIO_ACTIVE:
        GPIO.output(pinUlur, GPIO.HIGH)
        print("ulur on")
    time.sleep(onDelay)
    
    if MOTOR_GPIO_ACTIVE:
        GPIO.output(pinUlur, GPIO.LOW)
        print("ulur off")
    time.sleep(offDelay)
    GPIO.output(pinLampu, GPIO.LOW)
    

def rotateCamera(orientasi):
    #pan_absolute 0x009a0908 (int)      : min=-540000 max=540000 step=3600 default=0 value=0
    #tilt_absolute 0x009a0909 (int)     : min=-324000 max=324000 step=3600 default=0 value=0
    #kiri   :
    #v4l2-ctl --set-ctrl=pan_absolute=-380000
    #v4l2-ctl --set-ctrl=tilt_absolute=50000
    #tengah :
    #v4l2-ctl --set-ctrl=pan_absolute=-80000
    #v4l2-ctl --set-ctrl=tilt_absolute=50000
    if orientasi == "KIRI":
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=pan_absolute=-324000"])
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=tilt_absolute=36000"])
    elif orientasi == "KANAN": 
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=pan_absolute=324000"])
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=tilt_absolute=36000"])
    elif orientasi == "HOME":
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=pan_absolute=0"])
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=tilt_absolute=-270000"])
    elif orientasi == "DEFAULT":
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=pan_absolute=0"])
        subprocess.run(["v4l2-ctl", "-d", "/dev/video0", "--set-ctrl=tilt_absolute=0"])

def capture_image(path, filenameSave):
    cap = cv2.VideoCapture("/dev/video0", cv2.CAP_V4L2)

    cap.set(cv2.CAP_PROP_FOURCC, cv2.VideoWriter_fourcc(*'MJPG'))
    cap.set(cv2.CAP_PROP_FPS, 15)
    cap.set(cv2.CAP_PROP_FRAME_WIDTH, 3840)
    cap.set(cv2.CAP_PROP_FRAME_HEIGHT, 2160)
    
    for _ in range(120):
        ret, frame = cap.read()
    ret, frame = cap.read()

    if ret:
        frame = cv2.flip(frame, 0)
        cv2.imwrite(path + filenameSave +".jpg", frame)
        print("Gambar tersimpan dengan shape:", frame.shape)
    else:
        print("Gagal membaca kamera!")

    cap.release()



def proses_deteksi(path, baris, sisi, filenameSave):
    global a1, a2, b1, b2
    retry = 0
    mentah = 0
    matang = 0

    # while mentah == 0 and matang == 0:
    #     print("Ambil gambar ulang...")
    capture_image(path, filenameSave)

    mentah, matang = deteksi_jeruk(path, filenameSave)

    print("Mentah:", mentah)
    print("Matang:", matang)

        # retry += 1
        # if retry >= MAX_RETRY:
        #     print("Gagal deteksi setelah beberapa percobaan")
        #     break
    
    totalBuah = matang + mentah
    
    if sisi == "KIRI":
        if baris == 1:
            a1 = matang
            print(f"a1={a1}")
        elif baris == 2:
            a2 = matang
            print(f"a2={a2}")
    elif sisi == "KANAN":
        if baris == 1:
            b1 = matang
            print(f"b1={b1}")
        elif baris == 2:
            b2 = matang
            print(f"b2={b2}")
    
    
    # if sisi == "KIRI":
    #     payload[f"baris{baris}"]["A"]["persentase"] = persentase
    # if sisi == "KANAN":
    #     payload[f"baris{baris}"]["B"]["persentase"] = persentase
    
    return mentah, matang

# ===============================
# MAIN SETUP
# ===============================
if __name__ == "__main__":
        
    path = "/home/ubuntu2025/Desktop/yolov8/img_out/"       
    filename = time.strftime("foto_%Y%m%d_%H%M%S")
    
    setupGPIO()
    rotateCamera("DEFAULT")
    time.sleep(2)
    rotateCamera("HOME")
    time.sleep(2)
    #tarik(5)
    # ===============================
    # MAIN LOOP
    # ===============================

    for baris in range(1, JUMLAH_BARIS+1):
        print(f"Mulai baris {baris}")

        # Geser/ulur mekanik
        if baris == 1:
            rotateCamera("DEFAULT")
            time.sleep(2)
            rotateCamera("HOME")
            ulur(22, 1)
        elif baris == 2:
            rotateCamera("DEFAULT")
            time.sleep(2)
            rotateCamera("HOME")
            ulur(110, 1)#30,1

        # ======================
        # ROTASI KIRI
        # ======================
        rotateCamera("DEFAULT")
        time.sleep(2)
        rotateCamera("KIRI")
        filenameKiri = filename + f"baris{baris}_kiri"
        proses_deteksi(path, baris, "KIRI", filenameKiri)
        
        # ======================
        # ROTASI KANAN
        # ======================
        rotateCamera("DEFAULT")
        time.sleep(2)
        rotateCamera("KANAN")
        filenameKanan = filename + f"baris{baris}_kanan"
        proses_deteksi(path, baris, "KANAN", filenameKanan)
        


    # ===============================
    # Kembali ke HOME
    # ===============================
    kirim_ke_database()
    rotateCamera("DEFAULT")
    time.sleep(2)
    rotateCamera("HOME")
    tarik(137)
    rotateCamera("DEFAULT")
    time.sleep(2)
    rotateCamera("HOME")
    print("Selesai semua baris")
