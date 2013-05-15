# Aptostat_gui
The front-end part of Aptostat

## Installation
Aptostat_gui relies on both Aptostat_gather and aptostat_api.
It is recommended that you set them up first.

Note: The instructions assume that you install the gui part in on a separate machine than api and gather (virtual or not).
If you host them on the same machine you need to configure the vHosts correctly.

## Installation
Note: Most of the commands might require sudo
### Setting up your server
#### Initial setup your server
You need:
- Ubuntu 12.04 LTS x64

Install the following with apt-get
- apache2
- php5
- curl
- php5-curl
- git

    `$ sudo apt-get install apache2 php5 curl php5-curl git `

#### Configure apache
Configure your DNS with a domain to the server
Apart from setting up apache as normal you have to:

- Enable rewrite engine

    `$ sudo a2enmod rewrite`

- Change your Virtual host settings (Typically in sites-available named default)
- Add /web to your DocumentRoot. Example: `/var/www/web`. (From a default of /var/www)
- Change Directory `/var/www/` into `/var/www/web`.
- `AllowOverride all` in <Directory /var/www/web/>

Example file: (first few lines)
```xml
<VirtualHost *:80>
    ServerAdmin webmaster@localhost

    DocumentRoot /var/www/web
    <Directory />
        Options FollowSymLinks
        AllowOverride None
    </Directory>
    <Directory /var/www/web>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>
[...]
```
Restart apache2
    $ sudo service apache2 restart

#### Download and install Composer
Navigate into home or any other place to store files temporarily:

    $ curl -sS https://getcomposer.org/installer | php
    $ mv composer.phar /usr/local/bin/composer

### Set up Aptostat
#### Clone the files

    $ git clone https://github.com/nox27/aptostat_gui.git
    $ sudo mv aptostat_gui/* /var/www/

`/var/www` will be described as projectRoot folder.

Run `composer install` in projectRoot folder.

Create log dir, lock dir and make them writable:

    $ mkdir -p app/log

    $ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/log
    $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/log

Note: You might need to install 'acl' first.

### Set up deploy-config
Read the README in `app/deploy-config` folder for more detailed info.

In short:
Write the url for API. It could be localhost or any other domain.
Rename it config.php and move it to the `/app` folder

Done! (Hopefully)