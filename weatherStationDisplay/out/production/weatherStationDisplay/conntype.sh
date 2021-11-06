if ping -q -c 1 -W 1 8.8.8.8 >/dev/null; then
  ip route get 8.8.8.8 | grep -Po 'dev \K\w+' | grep -qFf - /proc/net/wireless && echo wireless","$(iwgetid -r) || echo wired
else
  echo "NO"
fi


