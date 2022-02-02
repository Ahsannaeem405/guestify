#!/bin/bash
echo "Starting deploy script...."
cd /home/guestify/web/stage.guestify.net/public_html/guestify/
chown guestify:guestify -R /home/guestify/web/stage.guestify.net/public_html/guestify/
#git fetch --all
#git reset --hard origin/master
git pull origin master
chown guestify:guestify -R /home/guestify/web/stage.guestify.net/public_html/guestify/
echo "Deploy-script finished...."
