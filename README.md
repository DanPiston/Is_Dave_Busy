# Is Dave Busy


### Required:
	1. app/lib (bower should take care of this)
	2. app/node_modules (this might be old)
	3. api/vendor (composer should take care of this)
	4. api/google-api (clone google php api library - src/Google folder contents into this dir)

### For .htaccess
	AllowOverride All in /var/www (in the correct /etc/apache2/.../*.conf file)
	a2enmod rewrite

### .google.serviceaccount.json - put downloaded private key here - in root directory