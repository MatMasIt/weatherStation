dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $dir
rm app.log
touch app.log
