#!/bin/sh

nginx &

FILE="/etc/nginx/conf.d/nginx.conf"
LAST=`md5sum "$FILE"`
while true; do
  sleep 0.1;
  if [ -f "$FILE" ]; then
  	NEW=`md5sum "$FILE"`
  	if [ "$NEW" != "$LAST" ]; then
  	  nginx -s reload;
  	  LAST="$NEW";
  	fi
  fi
done 
