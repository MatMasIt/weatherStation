millicputemp=$(cat /sys/class/thermal/thermal_zone*/temp)
echo "System report"
date
echo "$millicputemp / 1000" | bc -l | awk '{ printf "CPU Temperature: %.2f °C\n", $1 }'
free -m | awk 'NR==2{printf "Memory Usage: %s/%sMB (%.2f%%)\n",$3,$2,$3*100/$2 }'
df -h | awk '$NF=="/"{printf "Disk Usage: %d/%dGB (%s)\n",$3,$2,$5}'
top -bn1 | grep load | awk '{printf "CPU Load: %.2f %%\n",$(NF-2)*100}'
du -sh storedData
tmux ls
iwgetid -r
