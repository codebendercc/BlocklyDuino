#!/bin/bash

# Handy variables!
OURUSER=${1:-ubuntu}
WEBROOT=/var/www
BDROOT=${WEBROOT}/BlocklyDuino
NGINXROOT=/etc/nginx
COMPOSERDIR=$HOME

# Download programs, etc.
echo "[Step 1]: Installing updates and software..."
sudo apt-get -y update && \
sudo apt-get -y upgrade && \
sudo apt-get -y install python-software-properties curl nginx git && \
sudo apt-get -y install php5-fpm php5-cli php5-curl
cd ${COMPOSERDIR}
wget https://getcomposer.org/composer.phar

echo "[Step 2]: Backing up default files..."
mkdir $HOME/backups
sudo cp ${NGINXROOT}/nginx.conf $HOME/backups/.
sudo cp ${NGINXROOT}/sites-available/default $HOME/backups/.
sudo cp /etc/php5/fpm/pool.d/www.conf $HOME/backups/.

echo "[Step 3]: Setting up Nginx user and group..."
sudo groupadd -g 80 nginx
sudo useradd -M -d /dev/null -s /bin/false -u 80 -g nginx nginx
# As part of this, we need to update the php5-fpm user and group
sudo sed "s/nginx/www-data/g" $HOME/backups/www.conf > /etc/php5/fpm/pool.d/www.conf
sudo service php5-fpm restart

echo "[Step 4]: Creating a web directory and downloading the BlocklyDuino git repo..."
sudo mkdir -p ${WEBROOT}
cd ${WEBROOT}
sudo git clone https://github.com/codebendercc/BlocklyDuino.git
cd ${BDROOT}

# The next line will need to be removed once this gets onto the master branch
sudo git checkout builder_service_integration

echo "[Step 5]: Applying configuration files..."
sudo cp ${BDROOT}/server_quickstart/nginx.conf ${NGINXROOT}/nginx.conf
sudo cp ${BDROOT}/server_quickstart/blocklyduino.conf ${NGINXROOT}/sites-available/default

echo "[Step 6]: Running Composer..."
sudo php ${COMPOSERDIR}/composer.phar update

echo "[Step 7]: Fixing up permissions and restarting the Nginx service..."
# Finally, make sure everything has the appropriate group, and bounce the nginx server
sudo chown -R $OURUSER:nginx ${WEBROOT}
sudo service nginx restart

echo "[Step 8]: ..."
echo "OOOOOOOH YEEEEEEYAH!"
