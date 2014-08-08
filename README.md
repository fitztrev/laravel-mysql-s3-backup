# Laravel MySQL to S3 Backup

This is a very simple database backup script for Laravel. It takes a `mysqldump` and optionally saves it to [Amazon S3](http://aws.amazon.com/s3/).

This package is very opinionated. Other backup scripts can support other database types or other places besides S3 to store your backup. This does not.

## Installation

1. Add it to your `composer.json`:

    ```
    "fitztrev/laravel-mysql-s3-backup": "dev-master"
    ```

2. Update your composer packages

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

    Edit `app/config/packages/fitztrev/laravel-mysql-s3-backup/config.php`:

    ```php
    's3' => [
        'key'    => 'AMAZON_API_KEY',
        'secret' => 'AMAZON_API_SECRET',
        'bucket' => 'your-bucket-name',
    ],
    ```

## Usage

```bash
$ php artisan db:backup
```

That's it. No arguments or optional parameters.
