## CONTRIBUTING TO ELITE HOMES API

# GETTING STARTED

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

# Prerequisities

    - A winning attitude

# Development Setup

1. Fork the repository and clone it to your local machine.

```
git clone <repository-url>
```

2. Navigate to the project directory.

```
composer install
```

3. Configure Environment:

```
Make a copy of the .env.example file and rename it to .env.
```

4. Generate App Key

```
php artisan key:generate
```

5. Start the Laravel development server

```
php artisan serve
```

# Development Workflow

1. Create a new branch for the feature you want to work on.

```
$ git checkout -b feature/feature-name
```

2.  Make your changes.
3.  Commit your changes.

```
$ git add .
$ git commit -m "commit message"
```

4. Pull from the upstream `main` branch to get the latest changes.

```
$ git pull upstream main
```

5. Push your changes to remote branch

```
$ git push origin feature/feature-name
```

6.  Create a pull request to the `main` branch
7.  Wait for your pull request to be merged.

# Commit Message Guidelines
