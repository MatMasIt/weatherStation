#!/bin/bash
dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $dir
php -S 127.0.0.1:8080&
firefox --kiosk 127.0.0.1:8080
pkill php