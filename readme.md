# Admin Dashboard
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

### To Do List
- [x] add login and logout event to log
- [ ] smart datatype preload
- [x] litle redesign
- [x] add dark mode
- [ ] create / delete / edit tables
- [ ] add / remove / change  accounts
