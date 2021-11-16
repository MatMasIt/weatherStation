from datetime import datetime
dests = {}
dests["S"]=open("results/smoke.csv","a+")
dests["H"]=open("results/humidity.csv","a+")
dests["T"]=open("results/temperature.csv","a+")
dests["P"]=open("results/pressure.csv","a+")
dests["PM10"]=open("results/pm10.csv","a+")
dests["PM25"]=open("results/pm25.csv","a+")
from pathlib import Path
for path in Path('storedData').rglob('*.csv'):
    with  path.open() as fo:
        for line in fo.read().split("\n"):
            le = line.split(",")
            if len(le) == 1:
                continue
            lf = "\""+datetime.utcfromtimestamp(int(le[0])).strftime('%Y-%m-%d %H:%M:%S')+"\";\""+str(le[2]).replace(".",",")+"\"\n" 
            dests[le[1]].write(lf)
