sudo apt-get install python-software-properties
sudo add-apt-repository ppa:ondrej/php
sudo add-apt-repository ppa:ondrej/apache2
sudo add-apt-repository -y ppa:ondrej/mysql-5.6
sudo apt-get update
sudo apt-get install -y php7.0
sudo apt-get install apache2
sudo apt-get install mysql-server-5.6
sudo apt-get install libapache2-mod-php7.0 php7.0-mysql php7.0-curl php7.0-json
service mysqld start
mysql_secure_installation
mysql -u root -p PASSWORD -e "CREATE DATABASE arcturus; USE ARCTURUS; SOURCE /path/to/arcturus.sql; GRANT ALL PRIVILEGES ON arcturus.* TO 'arcturus'@'localhost' DEFINED BY 'arcturus';"
cd /var/www/html
wget https://github.com/sant0ro/chocolatey/archive/binaries.zip
unzip binaries.zip
mv chocolatey-binaries/* ./
mv chocolatey-binaries/.* ./
php artisan migrate
service apache start