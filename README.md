# Laravel MySQL to S3 Backup

This is a very simple database backup script for Laravel. It takes a `mysqldump` and saves it to [Amazon S3](http://aws.amazon.com/s3/).

It's very opinionated. Other backup scripts support other database types and other places to store your backup. This does not.

## Installation

1. Update `composer.json`:

    ```
    "fitztrev/laravel-mysql-s3-backup": "dev-master"
    ```

2. Update composer

    ```bash
    $ composer update
    ```

3. Update `app/config/app.php`:

    ```php
    'providers' => array(
        ...
        'Fitztrev\LaravelMysqlS3Backup\LaravelMysqlS3BackupServiceProvider',
    ),
    ```

4. Publish and edit the config
    
    ```bash
    $ php artisan config:publish fitztrev/laravel-mysql-s3-backup
    ```

## Usage

```bash
$ php artisan db:backup
```

That's it. No arguments or optional parameters.
