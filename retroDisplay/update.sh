#!/bin/bash
dir=$(cd -P -- "$(dirname -- "$0")" && pwd -P)
cd $dir
wget -O latest.json https://raw.githubusercontent.com/StazioneMeteoCocito/dati/main/last.json