#!/bin/bash
# usage: snap.sh <url-path> <out-name> [width] [height]
cd "$(dirname "$0")"
PATH_="${1:-/}"; OUT="${2:-page}"; W="${3:-1920}"; H="${4:-12000}"
SLUG=$(echo "$PATH_" | tr '/' '_' | tr -d '%')
curl -s -H "Host: alfadigital.duckdns.org" "http://127.0.0.1$PATH_" \
  | sed 's#http://alfadigital\.duckdns\.org#http://127.0.0.1#g' > "snap$SLUG.html"
chmod 644 "snap$SLUG.html"
chromium --headless=new --no-sandbox --disable-gpu --hide-scrollbars --user-data-dir=/tmp/chr-snap \
  --window-size=$W,$H --virtual-time-budget=9000 --screenshot="$PWD/$OUT.png" \
  "http://127.0.0.1/wp-content/themes/alfa/.figma-cache/snap$SLUG.html" 2>&1 | grep -oE "ERR_[A-Z_]+|written to file" | tail -1
python3 - "$OUT.png" <<'PY'
import sys
from PIL import Image
im = Image.open(sys.argv[1]); w,h = im.size
bg = im.getpixel((5,h-5)); bottom = h
for y in range(h-1,0,-40):
    row=[im.getpixel((x,y)) for x in range(0,w,97)]
    if any(abs(p[0]-bg[0])+abs(p[1]-bg[1])+abs(p[2]-bg[2])>12 for p in row):
        bottom=y+40; break
im.crop((0,0,w,bottom)).save(sys.argv[1].replace('.png','-full.png'))
print('height', bottom)
PY
