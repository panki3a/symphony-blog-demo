# Pixel Blog

### Prerequisites

Before running the project, ensure you have the following installed:

```
Docker

Docker Compose

Git
```

### Installation

To quickly get started, clone this project and run the following command:
Clone the repository:

```bash
git clone https://github.com/yourusername/pixel-blog.git
```

### Bulding the project

Navigate to the project directory:

```bash
cd pixel-blog
 ```

Then build and start the Docker containers:

```bash
docker-compose up --build
```

**Then open your browser and navigate to http://localhost:8080/**

### Automatic setup
Once all containers are started, everything will automatically initiate through the **docker-fpm-entrypoint.sh** script. This script handles the installation of dependencies, execution of migrations, seeding of the database, and creation of **.env** from **.env.example.**
```bash
composer install
bin/console doctrine:migrations:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
```

### Running tools for code quality in docker container

Enter the Docker container:

```bash
docker exec -it pixel-blog-php-fpm bash
```

Run every tool in the container:
#### PHP Code Sniffer

```bash
composer phpcs
```

#### PHP Code Sniffer Fixer

```bash
composer phpcsfix
```

#### PHPStan

```bash
composer phpstan
```

#### Commented Code

```bash
composer commented-code
```

#### Var Dump Check

```bash
composer var-dump-check
```

#### Twig

```bash
composer twig
```

#### PHPUnit

```bash
composer phpunit
```

### Stopping the project

To stop the Docker containers, press Ctrl + C in the terminal where the containers are running.
