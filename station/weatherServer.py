#!/usr/bin/env python
# encoding: utf-8
"""
weatherServer
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


class Server:
    def __init__(self, serverEndpoint, authToken, refreshTime, maxArchiveSize):
        self.connected=True
        self.serverEndpoint = serverEndpoint
        self.authToken = authToken
        self.refreshTime = refreshTime
        self.maxArchiveSize = maxArchiveSize
        self.running = True
        self.__internalRunning = False
        pathlib.Path("storedData").mkdir(parents=True, exist_ok=True)
        self.__initServer()

    def is_connected(self):
        return self.connected

    def __clean_name(self,fPath):
        return os.path.basename(fPath).split(".")[0]

    def __initServer(self):
        t=threading.Thread(target = self.__serverLoop)
        t.daemon = True
        t.start()

    def start(self):
        self.stop()
        self.__initServer()

    def stop(self):
        self.running = False
        while self.__internalRunning:
            time.sleep(5)
        return True

    def restart(self):
        self.start()

    def __serverLoop(self):
        while self.running:
            self.__internalRunning = True
            try:
                self.__process_iterate_all_dirs()
                self.__clean()
            except Exception as e:
                raise e
                time.sleep(10)
            time.sleep(self.refreshTime)
        self.__internalRunning = False

    def __dir_size(self, dir):
        root_directory = pathlib.Path(dir)
        return int(sum(f.stat().st_size for f in root_directory.glob('**/*') if f.is_file()) / 1000000)

    def __clean(self):
        if self.__dir_size("storedData") < self.maxArchiveSize:
            return False
        f = int(open("storedData/last").read())
        allocNeed = self.maxArchiveSize - self.__dir_size("storedData")
        allocReach = 0
        toRem = []
        for dir in self.__list_dirs("storedData"):
            if not int(self.__clean_name(dir)) < f:
                continue
            if allocReach > allocNeed:
                break
            allocReach += self.__dir_size(dir)
            toRem.append(dir)
        for remov in toRem:
            os.unlink(remov)
        return True

    def __list_dirs(self, thedir):
        directories = [name for name in os.listdir(thedir) if os.path.isdir(os.path.join(thedir, name))]
        directories.sort(key=int)
        for i in range(len(directories)):
            directories[i] = thedir + "/" + str(directories[i])
        return directories

    def __list_files(self, chunkDir):
        return glob.glob(chunkDir+"/*.csv")

    def __current_chunk(self):
        UNIXmidnight = int(datetime.datetime.combine(datetime.datetime.today(), datetime.time.min).strftime('%s'))
        UNIXnow = time.time()
        cunknum = int((UNIXnow - UNIXmidnight) / self.refreshTime)
        dirpath = "storedData/" + str(UNIXmidnight)
        pathlib.Path(dirpath).mkdir(parents=True, exist_ok=True)
        return dirpath + "/" + str(cunknum) + ".csv"

    def __bufferin(self, value, typeData):
        try:
            q=self.__current_chunk()
            pathlib.Path(q).touch(exist_ok=True)
            f = open(self.__current_chunk(), "a+")
            f.write(str(int(time.time())) + "," + typeData + "," + str(value)+"\n")
            f.close()
            return True
        except Exception as e:
            print(e)
            return False

    def __process_chunk(self, chunkFile):
        if  self.__current_chunk() == chunkFile:
            return False
        try:
            data = open(chunkFile, "r").read()
            toSend = self.authToken + "\n" + data
            requests.post(self.serverEndpoint, data=toSend)
            self.connected=True
            return True
        except Exception as e:
            self.connected=False
            print(e)
            return False

    def __process_dir(self, dir):
        pathlib.Path(dir + "/last").touch(exist_ok=True)
        f = open(dir + "/last")
        lastChunkName = f.read()
        f.close()
        try:
            lastChunk = int(lastChunkName)
        except:
            lastChunk = 0
        for chunk in self.__list_files(dir):
            if int(self.__clean_name(chunk)) > lastChunk:
                if not self.__process_chunk(chunk):
                    return False
                else:
                    f = open(dir + "/last", "w")
                    f.write(str(self.__clean_name(chunk)))
                    f.close()
        return True

    def __process_iterate_all_dirs(self):
        UNIXmidnight = int(datetime.datetime.combine(datetime.datetime.today(), datetime.time.min).strftime('%s'))
        pathlib.Path("storedData/last").touch(exist_ok=True)
        f = open("storedData/last", "r")
        lastDirName = f.read()
        f.close()
        try:
            lastDir = int(lastDirName)
        except:
            lastDir = 0
        writeWhat = 0
        for dir in self.__list_dirs("storedData"):
            if int(self.__clean_name(dir)) > lastDir:
                if self.__process_dir(dir) and UNIXmidnight > int(self.__clean_name(dir)):
                    writeWhat = int(self.__clean_name(dir))
                else:
                    break
        f = open("storedData/last", "w")
        f.write(str(writeWhat))
        f.close()

    def record_temperature(self, temp):
        return self.__bufferin(temp, "T")

    def record_humidity(self, hum):
        return self.__bufferin(hum, "H")

    def record_pressure(self, pressure):
        return self.__bufferin(pressure, "P")

    def record_pluviometer_tick(self, litersCapacity):
        return self.__bufferin(litersCapacity, "R")
    
    def record_pm10(self, pm10):
        return self.__bufferin(pm10, "PM10")
    
    def record_pm25(self, pm25):
        return self.__bufferin(pm25, "PM25")
    
    def record_smoke(self, smokeppm):
        return self.__bufferin(smokeppm, "S")

