# 🚀 PHP Development Template
A reusable, modern PHP development environment powered by Docker, Nginx, PHP-FPM, MySQL, and phpMyAdmin — designed so you can clone this template and instantly start a new PHP project.

This template includes:

- Fully configured Docker development environment
- Isolated PHP container with configurable PHP version
- Automatic volume syncing to your local project
- MySQL + health checks + phpMyAdmin
- Nginx configured for a PHP project
- Makefile with common developer commands
- .env.example for easy configuration
- Optional code formatters (php-cs-fixer, pretty-php, phpcs) installed globally in the PHP container

---

# 📁 Folder Structure
```
project-root/
│
├── dev_env/
│   ├── docker-compose.base.yml
│   ├── php-env/
│   │   ├── Dockerfile
│   │   └── php.ini
│   └── nginx/
│       └── default.conf
│
├── public/
│   ├── index.php
│   └── test-db.php
│
├── src/
│   └── .gitkeep
│
├── .php-cs-fixer.php          ←  PHP-CS-Fixer configuration
├── docker-php-cs-fixer.sh     ←  Runs PHP-CS-Fixer inside Docker
├── .pre-commit-config.yaml    ←  Pre-commit hook configuration
│
├── composer.json
├── Makefile
├── .env.example
└── README.md
```

---

# 🛠 Requirements
- Docker 24+
- Docker Compose V2
- GNU Make
- Git

---

# ⚙️ Installation
### 1. Clone the repository
```bash
git clone https://github.com/tresiab/php_dev_setup_template new-project
cd new-project
```
(or use this repo as a GitHub Template)

### 2. Create your environment file
```bash
cp .env.example .env
```
(edit .env to match your setup)

### 3. Start the development environment
```bash
make up
```

Containers will build and run:
- PHP (8.2 by default)
- Nginx
- MySQL
- phpMyAdmin

### 4. Open the website
```
http://localhost:8080
```

### 5. Open phpMyAdmin
```
http://localhost:8081
```
Login using credentials from .env:
- User: MYSQL_USER
- Password: MYSQL_PASSWORD

---

## 🐳 Docker Services
| Service	 | Port	       | Description          |
| :--------- | :---------- | :------------------- |
| Nginx	     | 8080 → 80   | Web server           |
| php-fpm	 | internal	   | Executes PHP scripts |
| MySQL	     | 3306 → 3306 | Database server      |
| phpMyAdmin |	8081 → 80  | DB admin UI          |

---

## 📦 Composer
The template includes a beginner-friendly composer.json:
```json
{
    "name": "yourname/php-project",
    "description": "Starter PHP project template",
    "type": "project",

    "require": {
        "php": "^8.2",
        "vlucas/phpdotenv": "^5.5"
    },

    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    },

    "require-dev": {
        "symfony/var-dumper": "^7.0"
    },

    "scripts": {
        "start": "php -S 0.0.0.0:8000 -t public",
        "dump": "composer dump-autoload"
    },

    "config": {
        "sort-packages": true
    }
}
```
Install dependencies:
```bash
make shell
git config --global --add safe.directory /var/www/html
composer install
```
---

## 🧰 Makefile Commands
| Command	            | Description                                    |
| :-------------------- | :--------------------------------------------- |
| make up               | Build and start all containers                 |
| make down	            | Stop all containers                            |
| make logs	            | Show PHP container logs                        |
| make shell	        | Get a shell inside the PHP container           |
| make db-shell	        | Open MySQL console inside DB container         |
| make format	        | Run PHP formatters (php-cs-fixer + pretty-php) |
| make clean-volumes	| Remove containers + volumes                    |
| make clean-images	    | Remove containers + images                     |

---

## 🔍 Testing Database Connection
The template provides:
```bash
public/test-db.php
```
Visit:
```
http://localhost:8080/test-db.php
```
You should see:
```
Database connection successful!
```
If not, double-check your .env values.

---

## 🧩 Starting Your Own Project
After cloning the template:
1. Edit .env
2. Rename yourname/php-project in composer.json
3. Add your code inside /src
4. Add routes, controllers, templates, etc.
5. Use /public for public-facing files

---

## To use pre-commit
```bash
pre-commit install
pre-commit run --all-files
```

---

## 🗑 Troubleshooting
### ❌ Port already in use
Example:

```nginx
Bind for 0.0.0.0:8080 failed: port is already allocated
```
Fix:
```bash
sudo lsof -i :8080
sudo kill <PID>
```
Or change ports in .env:
```
PROJECT_PHP_PORT=8082
PROJECT_PMA_PORT=8083
```

---

### ❌ Blank or missing variables inside PHP
Ensure .env loads inside Makefile:
```bash
export $(shell sed -E 's/=.*//' .env)
```
Double-check:
```bash
echo $MYSQL_USER
```
