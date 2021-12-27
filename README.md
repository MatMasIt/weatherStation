# weatherStation
[![Build LaTeX document](https://github.com/MatMasIt/weatherStation/actions/workflows/LATEX.yml/badge.svg)](https://github.com/MatMasIt/weatherStation/actions/workflows/LATEX.yml)

[![Pylint](https://github.com/MatMasIt/weatherStation/actions/workflows/pylint.yml/badge.svg)](https://github.com/MatMasIt/weatherStation/actions/workflows/pylint.yml)

![GitHub](https://img.shields.io/github/license/MatMasIt/weatherStation)

![GitHub language count](https://img.shields.io/github/languages/count/MatMasIt/weatherStation)

Source Code for the weather station situated at [Liceo Cocito](https://liceococito.edu.it): station and server 

[A pdf presentation :it: is also available](documents/ws.pdf)

[Open data - explore the complete dataset](https://github.com/StazioneMeteoCocito/dati)

## Overview

|Component|Path|Description|Languages|Further developments|
|---|---|---|---|---|
|Arduino|`arduino`|Handles the acquisition of air quality data from the PM10-2,5 and smoke sensors, sending it to the raspberry over a serial connection|C||
|Station|`station`|The software which runs on the raspberry pi and receives temperature, humidity and pressure data from the sense hat, along with serial data from the arduino is tasked with acquisition storage of the weather data.|python|Better memory management, reboot cycle|
|Server|`server`|This Web App pulls git weather data, stores it and allows for retrieval and plotting of archival and current data|php (html,css,js)|REST API|
|Neon display|`retroDisplay`|A simple neon display that shows current data. Ideal for small screens|php (html,css,js)|Maintenance screen|
|Exporter|`station/gitExport.sh`|Allows for exporting and mainaining data into a git repository sorted by year/month/day|shell||
|Documentation|`documents`|The presetation paper of the project|LaTeX|Update data|


> 2021, Mattia Mascarello, Lorenzo Dellapiana, Luca Biello, The MIT License

