# 2021, Mattia Mascarello, The MIT License 
from gpiozero import CPUTemperature
import serial
import weatherServer
import time
import random
from sense_hat import SenseHat
import datetime
import logging
logging.basicConfig(filename='app.log',format='%(asctime)s.%(msecs)-15d|  %(levelname)-8s | %(filename)s:%(lineno)-20d|%(module)s.%(funcName)-30s|thread %(threadName)s %(thread)-30d| %(message)s',datefmt='%Y-%m-%d:%H:%M:%S',level=logging.DEBUG)
chunkTime = 10*60
timeMeasure = 5*60
sense = SenseHat()
s= weatherServer.Server("ADDRESS","TOKEN",chunkTime,3000)
ser=serial.Serial('/dev/ttyACM0',9600,timeout=10)
def base_img():
    if int(datetime.datetime.now().strftime("%H"))>19 or int(datetime.datetime.now().strftime("%H"))<7:
        logging.info("Clearing led matrix")
        sense.clear()
        return False
    if int(datetime.datetime.now().strftime("%m"))==6 and int(datetime.datetime.now().strftime("%d"))==2:
        sense.load_image("it.png")
        logging.info("Displayed italian flag")
    elif int(datetime.datetime.now().strftime("%m"))==6:
        sense.load_image("rainbow.png")
        logging.info("Displayed rainbow")
    else:
        sense.load_image("forest.png")
        logging.info("Displayed base forest image")
base_img()
def show_data_led(data):
    if int(datetime.datetime.now().strftime("%H"))>19 or int(datetime.datetime.now().strftime("%H"))<7:
        sense.clear()
        logging.info("It's time to shut off the lights")
        return False
    scrollSpeed=0.05
    logging.info("Showing data on led matrix")
    sense.show_message("Liceo Scientifico \"Leonardo Cocito\"",scroll_speed=scrollSpeed)
    sense.show_message("Dati del "+str(data["when"]),scroll_speed=scrollSpeed)
    sense.show_message("Temperatura: "+str(int(data["temperature"]))+ " C",scroll_speed=scrollSpeed,text_colour=[235,40,26])
    sense.show_message("Umidita': "+str(int(data["humidity"]))+" %",scroll_speed=scrollSpeed,text_colour=[26,235,207])
    sense.show_message("Pressione: "+str(int(data["pressure"]))+" hPa",scroll_speed=scrollSpeed,text_colour=[43,235,26])
    if data["serialOk"]:
        sense.show_message("PM 10: "+str(int(data["pm10"]))+" ppm",scroll_speed=scrollSpeed,text_colour=[26,43,235])
        sense.show_message("PM 2.5: "+str(int(data["pm2.5"]))+" ppm",scroll_speed=scrollSpeed,text_colour=[26,43,235])
        sense.show_message("Fumo e vapori infiammabili: "+str(int(data["smoke"]))+" ppm",scroll_speed=scrollSpeed,text_colour=[235,26,130])
    else:
        sense.load_image("alert.png")
        time.sleep(5)
        sense.show_message("I sensori per la misurazione della qualita' dell'aria non rispondono ai comandi",scroll_speed=scrollSpeed,text_colour=[235,40,26])
    if not s.is_connected():
         sense.load_image("alert.png")
         time.sleep(5)
         sense.show_message("Connessione di rete non disponibile, i dati verranno salvati nella memoria locale",scroll_speed=scrollSpeed,text_colour=[235,40,26])
    listUs=["Mattia Mascarello","Lorenzo Dellapiana","Luca Biello","Arsildo Gjoka"]
    random.shuffle(listUs)
    sense.show_message("Progetto stazione meteo, 2021, "+(", ".join(listUs)),scroll_speed=scrollSpeed)
    base_img()
def get_sensors_serial(ser):
    logging.info("Requesting data from arduino")
    ser.write(bytes(1))
    dataA=[]
    for i in range(3):
        try:
            dataA.append(float(str(ser.readline()).split(",")[1].replace("\\r\\n'","")))
        except:
            logging.warning("Serial connection with arduino timed out")
            return False
    if(len(dataA)==0):
        logging.warning("Arduino sent no data")
        return False
    return {"pm10":dataA[0],"pm2.5":dataA[1],"smoke":dataA[2]}

while True:
    try:
        logging.info("New measurement")
        dts = datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")
        cpuTemp = CPUTemperature().temperature
        ambientTemp = sense.get_temperature_from_humidity()
        factor = 1.8
        tempCorrect=ambientTemp - ((cpuTemp - ambientTemp)/factor)
        logging.info("Raw ambient temperature: {at:.2f}, CPU temperature {cput:.2f}, Corrected temperature {corrtemp:.2f}".format(at=ambientTemp,cput=cpuTemp,corrtemp=tempCorrect))
        allData={"humidity":sense.get_humidity(),"temperature":tempCorrect,"pressure":sense.get_pressure(),"when":dts,"serialOk":False}
        s.record_humidity(allData["humidity"])
        logging.info("Humidity {h:.2f}".format(h=allData["humidity"]))
        s.record_pressure(allData["pressure"])
        logging.info("Pressure {p:.2f} hPa".format(p=allData["humidity"]))
        s.record_temperature(allData["temperature"])
        arduino=get_sensors_serial(ser)
        if arduino:
            allData["serialOk"]=True
            s.record_pm10(arduino["pm10"])
            s.record_pm25(arduino["pm2.5"])
            s.record_smoke(arduino["smoke"])
            allData["pm10"]=arduino["pm10"]
            allData["pm2.5"]=arduino["pm2.5"]
            allData["smoke"]=arduino["smoke"]
            logging.info("Arduino data - PM10: {pmt:.2f}, PM 2.5: {pmtw:.2f}, Smoke: {s:.2f}".format(pmt=arduino["pm10"],pmtw=arduino["pm2.5"],s=arduino["smoke"]))
        else:
            logging.warning("Arduino not present")
        show_data_led(allData)
        time.sleep(timeMeasure)
    except Exception as e:
        logging.exception("Exception")
        print("EXCEPTION:")
        print(e)
        time.sleep(10)
