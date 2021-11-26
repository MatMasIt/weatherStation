
from datetime import datetime
import os
from pathlib import Path
dests = {}
gitExport = True
if  gitExport:
    dests["S"]="smoke.csv"
    dests["H"]="humidity.csv"
    dests["T"]="temperature.csv"
    dests["P"]="pressure.csv"
    dests["PM10"]="pm10.csv"
    dests["PM25"]="pm25.csv"
else:
    dests["S"]=open("results/smoke.csv","a+")
    dests["H"]=open("results/humidity.csv","a+")
    dests["T"]=open("results/temperature.csv","a+")
    dests["P"]=open("results/pressure.csv","a+")
    dests["PM10"]=open("results/pm10.csv","a+")
    dests["PM25"]=open("results/pm25.csv","a+")
for path in Path('storedData').rglob('*.csv'):
    with  path.open() as fo:
        for line in fo.read().split("\n"):
            le = line.split(",")
            if len(le) == 1:
                continue
            lf = datetime.utcfromtimestamp(int(le[0])).strftime('%Y-%m-%d %H:%M:%S')+","+str(le[2])+"\n"
            if gitExport:
                foldPath = "results/"+datetime.utcfromtimestamp(int(le[0])).strftime('%Y/%m/%d')
                Path(foldPath).mkdir(parents=True, exist_ok=True)
                f = open(foldPath+"/"+dests[le[1]],"a+")
                f.write(lf)
                f.close()
                os.system("sort "+foldPath+"/"+dests[le[1]]+" | uniq | tee temp > /dev/null")
                os.system("mv temp "+foldPath+"/"+dests[le[1]])
            else:
                dests[le[1]].write(lf)
