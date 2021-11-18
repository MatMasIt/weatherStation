dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $dir
mkdir -p results
python3 export.py
cd results
git add *
git commit -m "Regular data update"
git push origin main