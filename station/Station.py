#!/usr/bin/env python
# encoding: utf-8
"""
Station
Created by Mattia Mascarello on 21/05/21.
MIT License
"""
import datetime
import os.path
import pathlib
import time
import requests
import threading
import glob


class Station:
    def __init__(self):
        pathlib.Path("storedData").mkdir(parents=True, exist_ok=True)

    def __path(typeData):
        return "storedData/"+datetime.datetime.now().strftime('%Y/%m/%d')+"/"+typeData+".csv"

    def __bufferin(self, value, typeData):
        try:
            q = self.__path(typeData)
            pathlib.Path(os.path.dirname(q)).mkdir(exist_ok=True)
            pathlib.Path(q).touch(exist_ok=True)
            f = open(q, "a+")
            f.write(datetime.datetime.now().strftime(
                '%Y-%m-%d %H:%M:%S')+","+str(value)+"\n")
            f.close()
            return True
        except Exception as e:
            print(e)
            return False

    def record_temperature(self, temp):
        return self.__bufferin(temp, "temperature")

    def record_humidity(self, hum):
        return self.__bufferin(hum, "humidity")

    def record_pressure(self, pressure):
        return self.__bufferin(pressure, "pressure")

    def record_pm10(self, pm10):
        return self.__bufferin(pm10, "pm10")

    def record_pm25(self, pm25):
        return self.__bufferin(pm25, "pm25")

    def record_smoke(self, smokeppm):
        return self.__bufferin(smokeppm, "smoke")
