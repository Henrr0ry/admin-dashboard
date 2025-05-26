# Admin Dashboard

### Linux commands for installing packages
```
sudo apt install apache2 php mysql-server libapache2-mod-php php-mysql -y
```

### Linux bash commands for php permission to edit files
```
sudo chown www-data:www-data /var/www/uploads
sudo chmod 755 /var/www/uploads
```

### Linux mysql database enable null root password
```
sudo mysql -u root -p
update mysql.user set plugin = 'mysql_native_password' where User='root';
FLUSH PRIVILEGES;
```

### Permisions for uploading
```
chown www-data:www-data /upload-files
```

### To Do List
- [x] add login and logout event to log
- [x] smart datatype preload
- [x] litle redesign
- [x] add dark mode
- [ ] create / delete / edit tables
- [ ] add / remove / change  accounts
- [ ] user access to tables
- [ ] better file upload
