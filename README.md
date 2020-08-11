# SymfonyProject
This is demo project for Symfony Learning I did it in Symfony 4.4 version.
This project is about a online softwares selling web application where a software provider can list his softwares to the end user.

## Steps to Configure this SymfonyProject on your server
### Step 1: Software We Required
- PHP (7.2 or above)
- MySQL (5.7 or MariaDb 10.1.14)
- Symfony (4.4)
- Git
- Composer
### Step 2: Create New Folder
Open Command Prompt(cmd) and clone the project repository by following command
```
git clone https://github.com/ruqeebak2020/SymfonyProject.git
```
### Step 3: Database Configuration

- Open  ***.env*** file in your editor.
- Go to ***Line Number 28***
- Replace ***db_user*** with your ***Database Username***
- Replace ***db_password*** with your ***Database Password***
- Replace ***db_name*** with your ***Database Name***
- Check your database version and update accordingly.
   - Go to ***mysql/bin*** and open new command prompt.
   - Run this following command to check database version
   ```
    mysqld -v
    ```
- if its showing ***5.7*** then no need to change ***serverVersion*** at ***.env*** file.
- If its different then change the ***serverVersion*** accordingly.
- At last line you have to add your Fixer API key at ***APP_CURRENCY_KEY***.

### Step 4: Project Folder
- Open Command Prompt and run the composer command as follows
```
composer install
```
- Create Database with following command (Make sure your MySQL server is running already.)
```
php bin/console doctrine:database:create
```
- Migrate the existing project Entities(tables) on your database with following command
```
php bin/console doctrine:migrations:migrate
```
- 3 tables will create in your database, i.e ***Platform***, ***Provider** and ***Bundle***.
- Add entities class in ***config/packages/easy_admin.yaml*** file.
```
- easy_admin:
    site_name: 'Admin <em style="font-size: 80%;">Dashboard</em>'
    entities:
        # List the entity class name you want to manage
        - App\Entity\Platform
        - App\Entity\Provider
        - App\Entity\Bundle
```

### Step 5: Start Symfony Server
- Start your symfony server by following command
```
symfony server:start
```
- Your ***Project url*** will be like this ***http://127.0.0.1:8000*** or something similar to this.

### Step 6: Data Uploading
- Open browser and enter ***http://127.0.0.1:8000/admin***
- Before opening the home page of your project we need to add data on following tables, because home page is depend upon these tables data.
  - Platform
  - Provider
  - Bundle
- ***Platform***
  - Add only ***Name*** and save it.
- ***Provider***
   - Add all fields according to your choice and add multiple the ***Platform*** field.
- ***Bundle***
   - Add all fields according to your choice.
   - For Image field you need to move your product image under ***public/images/product/*** folder then add only its ***file name with extention*** in text field.
    - For example you need to pass only ***image_name.png*** here.


### Step 7 : Go To Home Page
- Open your ***Project url*** which is similar to this ***http://127.0.0.1:8000***
- Done

# Thanks
