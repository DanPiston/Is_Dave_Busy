### Back-end application

# SLIM framework right now (http://www.slimframework.com/)
	or we go to python if this ends up being dumb. 

###Setup
	1. Install composer
	2. php composer.phar install (to download slim to /vendor)
	3. make sure api/.htaccess has:
			--------------------------------------
			RewriteEngine On
			RewriteCond %{REQUEST_FILENAME} !-f
			RewriteRule ^ index.php [QSA,L]
			--------------------------------------