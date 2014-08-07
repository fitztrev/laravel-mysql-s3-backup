<?php namespace Fitztrev\LaravelMysqlS3Backup\Commands;

use Aws\S3\S3Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;

class MysqlS3Backup extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:backup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a sqldump of your MySQL database and upload it to Amazon S3';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$db_name = Config::get('database.connections.mysql.database');
		$db_host = Config::get('database.connections.mysql.host');
		$db_user = Config::get('database.connections.mysql.username');
		$db_pass = Config::get('database.connections.mysql.password');

		$filename = sprintf('/tmp/backup-%s-%s.sql', $db_name, date('Ymd-His'));

		$this->info('Running backup for database `' . $db_name . '`');

		$cmd = sprintf('mysqldump --host=%s --user=%s --password=%s --single-transaction --routines --triggers %s',
			escapeshellarg($db_host),
			escapeshellarg($db_user),
			escapeshellarg($db_pass),
			escapeshellarg($db_name)
		);

		if ( Config::get('laravel-mysql-s3-backup::gzip') ) {
			$filename .= '.gz';
			$cmd      .= sprintf(' | gzip > %s', escapeshellarg($filename));
		} else {
			$cmd      .= sprintf(' > %s', escapeshellarg($filename));
		}

		$process = new Process($cmd);
		$process->run();

		if (!$process->isSuccessful()) {
			$this->error($process->getErrorOutput());
			return;
		}

		$s3 = S3Client::factory([
			'key'    => Config::get('laravel-mysql-s3-backup::s3.key'),
			'secret' => Config::get('laravel-mysql-s3-backup::s3.secret'),
		]);

		$key = sprintf('%s/%s/%s/%s/%s',
			Config::get('laravel-mysql-s3-backup::s3.prefix'),
			date('Y'),
			date('m'),
			date('d'),
			basename($filename)
		);

		$result = $s3->putObject([
			'Bucket'     => Config::get('laravel-mysql-s3-backup::s3.bucket'),
			'Key'        => $key,
			'SourceFile' => $filename,
		]);

		unlink($filename);
		$this->info('Done');
	}

}
