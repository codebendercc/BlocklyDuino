#!/bin/bash

# Handy variables!
WEBROOT=/var/www
BDROOT=$WEBROOT/BlocklyDuino
NGINXROOT=/etc/nginx

# Download programs, etc.
echo "[Step 1]: Installing updates and software..."
sudo apt-get -y update && \
sudo apt-get -y upgrade && \
sudo apt-get -y install nginx git

# Backup files that we'll overwrite, just in case.
echo "[Step 2]: Backing up default files..."
mkdir $HOME/backups
sudo cp $NGINXROOT/nginx.conf $HOME/backups/.
sudo cp $NGINXROOT/sites-available/default $HOME/backups/.

# Create a user/group for nginx.
echo "[Step 3]: Setting up Nginx user and group..."
sudo groupadd -g 80 nginx
sudo useradd -M -d /dev/null -s /bin/false -u 80 -g nginx nginx

# Create www directory and clone our git repo in there.
echo "[Step 4]: Creating a web directory and downloading the BlocklyDuino git repo..."
sudo mkdir -p $WEBROOT
cd $BDROOT
sudo git clone https://github.com/codebendercc/BlocklyDuino.git
# The next line will need to be removed once this gets onto the master branch
sudo git checkout server_quickstart

echo "[Step 5]: Applying configuration files..."
# Copy the config file into /etc/nginx/nginx.conf
sudo cp $BDROOT/server_quickstart/nginx.conf $NGINXROOT/nginx.conf

# Update the /etc/nginx/sites-available/default file to point to where we'll download the repo
sudo cp $BDROOT/server_quickstart/default_site $NGINXROOT/sites-available/default

echo "[Step 6]: Fixing up permissions and restarting the Nginx service..."
# Finally, make sure everything has the appropriate group, and bounce the nginx server
sudo chown -R ubuntu:nginx $WEBROOT
sudo service nginx stop
sudo service nginx start

echo "[Step 7]: ..."
echo "OOOOOOOH YEEEEEEYAH!"
