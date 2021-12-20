# 2021, Mattia Mascarello, The MIT License
import serial
from Station import Station
import time
import random
from sense_hat import SenseHat
import datetime
sense = SenseHat()
s = Station()
ser = serial.Serial('/dev/ttyACM0', 9600, timeout=10)


def get_sensors_serial(ser):
    print("Requesting data from arduino")
    ser.write(bytes(1))
    dataA = []
    for i in range(3):
        try:
            dataA.append(float(str(ser.readline()).split(",")
                         [1].replace("\\r\\n'", "")))
        except:
            print("Serial connection with arduino timed out")
            return False
    if(len(dataA) == 0):
        print("Arduino sent no data")
        return False
    return {"pm10": dataA[0], "pm2.5": dataA[1], "smoke": dataA[2]}

timeMeasure = 5*60

while True:
    try:
        print("New measurement")
        dts = datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S")
        allData = {"humidity": sense.get_humidity(), "temperature": sense.get_temperature_from_humidity(),
                   "pressure": sense.get_pressure(), "when": dts, "serialOk": False}
        s.record_humidity(allData["humidity"])
        print("Humidity {h:.2f}".format(h=allData["humidity"]))
        s.record_pressure(allData["pressure"])
        print("Pressure {p:.2f} hPa".format(p=allData["pressure"]))
        s.record_temperature(allData["temperature"])
        arduino = get_sensors_serial(ser)
        if arduino:
            allData["serialOk"] = True
            s.record_pm10(arduino["pm10"])
            s.record_pm25(arduino["pm2.5"])
            s.record_smoke(arduino["smoke"])
            allData["pm10"] = arduino["pm10"]
            allData["pm2.5"] = arduino["pm2.5"]
            allData["smoke"] = arduino["smoke"]
            print("Arduino data - PM10: {pmt:.2f}, PM 2.5: {pmtw:.2f}, Smoke: {s:.2f}".format(
                pmt=arduino["pm10"], pmtw=arduino["pm2.5"], s=arduino["smoke"]))
        else:
            print("Arduino not present")
        time.sleep(timeMeasure)
    except Exception as e:
        print("EXCEPTION:")
        print(e)
        time.sleep(10)
