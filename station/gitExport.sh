dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $dir
bash infofile.sh | tee "storedData/report.txt"
cd storedData
git pull
git add *
git commit -m "Regular data update"
git push origin main
