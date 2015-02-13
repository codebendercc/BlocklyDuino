#!/bin/bash

# Handy variables!
WEBROOT=/var/www/
BDROOT=$WEBROOT/BlocklyDuino
NGINXROOT=/etc/nginx

# Download programs, etc.
sudo apt-get -y update && \
sudo apt-get -y upgrade && \
sudo apt-get -y install nginx git

# Backup files that we'll overwrite, just in case.
mkdir $HOME/backups
sudo cp $NGINXROOT/nginx.conf $HOME/backups/.
sudo cp $NGINXROOT/sites-available/default $HOME/backups/.

# Create a user/group for nginx.
sudo groupadd -g 80 nginx
sudo useradd -M -d /dev/null -s /bin/false -u 80 -g nginx nginx

# Create www directory and clone our git repo in there.
sudo mkdir -p $WEBROOT
cd $WEBROOT
sudo git clone https://github.com/codebendercc/BlocklyDuino.git

# Copy the config file into /etc/nginx/nginx.conf
sudo cp $BDROOT/server_quickstart/nginx.conf $NGINXROOT/nginx.conf

# Update the /etc/nginx/sites-available/default file to point to where we'll download the repo
sudo cp $BDROOT/server_quickstart/default_site $NGINXROOT/sites-available/default

# Finally, make sure everything has the appropriate group, and bounce the nginx server
sudo chown -R ubuntu:nginx $WEBROOT
sudo service nginx stop
sudo service nginx start

echo "OOOOOOOH YEEEEEEYAH!"
