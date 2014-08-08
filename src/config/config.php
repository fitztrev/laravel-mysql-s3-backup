<?php

return array(

	/*
	 * Configure with your Amazon S3 credentials
	 * You should use an IAM user who only has PutObject access
	 * to a specified bucket
	 *
	 * Or alternatively, you can set `s3` to false
	 * to disable S3 uploading entirely
	 */
	's3' => [
		'key'    => 'AMAZON_API_KEY',
		'secret' => 'AMAZON_API_SECRET',
		'bucket' => 'your-bucket-name',
	],
	// 's3' => false,

	/*
	 * Whether or not to gzip the .sql file
	 */
	'gzip'  => true,

	/*
	 * Backup filename
	 */
	'filename' => sprintf('backup-%s.sql', date('Ymd-His')),

	/*
	 * Where to store the backup file locally
	 */
	'backup_dir'      => '/tmp',

	/*
	 * Do you want to keep a copy of it or delete it
	 * after it's been uploaded?
	 */
	'keep_local_copy' => false,

);
