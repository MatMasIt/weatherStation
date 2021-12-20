dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $dir
cd storedData
git pull
git add *
git commit -m "Regular data update"
git push origin main