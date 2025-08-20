# Admin Dashboard

### Linux commands for installing packages
```bash
sudo apt install apache2 php mysql-server libapache2-mod-php php-mysql -y
```

### Linux bash commands for php permission to edit files
```bash
sudo chown www-data:www-data upload-files
sudo chmod 755 upload-files
```

### Linux mysql database enable null root password
```bash
sudo mysql -u root -p
```
```mysql
update mysql.user set plugin = 'mysql_native_password' where User='root';
FLUSH PRIVILEGES;
```

### To Do List
- [x] add login and logout event to log
- [x] smart datatype preload
- [x] litle redesign
- [x] add dark mode
- [x] create / delete / edit tables
- [x] sql console
- [x] add / remove / change  accounts
- [x] user access to tables
- [x] better file upload
- [x] better security

## Installation Documentation

### 1) Copy files
- copy ```/admin``` directory to your project

### 2) Setup Database
- add new tables to ```/admin/reset.sql```
- then setup new account for your database or use login info from your provider

```mysql
CREATE USER 'new_username'@'localhost' IDENTIFIED BY 'new_password';

GRANT ALL PRIVILEGES ON *.* TO 'new_username'@'localhost';

FLUSH PRIVILEGES;
```

### 3) Update Connection
- update login info in ```/admin/config.php``` and ```/admin/command/connect.php```

### 4) Change Default Login
- then on your site (for example ```localhost/admin```) should be visible admin dashboard
- login with default credentials:
```
User: admin
Password: admin
```
- change your password and if you need and new one
