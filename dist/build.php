<?php
/**************************************************************************
 *
* Copyright 2011 Marco Behnke <marco@behnke.biz>
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
*    http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*
**************************************************************************/

printf ( 'PHP Game Components PHAR Builder (cli)' . PHP_EOL );
printf ( 'Copyright (c) 2011-2012 Marco Behnke' . PHP_EOL );
printf ( '' . PHP_EOL );
printf ( 'Usage: build.php [-c(gzip|bzip2)] [-s(1|256|512)]' . PHP_EOL );
printf ( 'Options:' . PHP_EOL );
printf ( '-c set compression algorithm to gzip or bzip2' . PHP_EOL );
printf ( '-s set signature algorithm to SHA1, SHA256 or SHA512' . PHP_EOL );
printf ( '' . PHP_EOL );

$signatureAlgorithm = Phar::SHA512;
$compression = null;
$extension = '';

foreach ( $_SERVER ['argv'] as $k => $v )
{
	if ($v [0] == '-') // configuration option
	{
		switch ($v [1])
		{
			case 'h' :
				// print help only
				exit ( 0 );
				break;
			case 's' : // signature
				switch (substr ( $v, 2 ))
				{
					case '1' :
						$signatureAlgorithm = Phar::SHA1;
						break;
					case '256' :
						$signatureAlgorithm = Phar::SHA256;
						break;
					case '512' :
						$signatureAlgorithm = Phar::SHA512;
						break;
					default :
						printf ( 'Unsupported signature mode SHA%s. Exit.' . PHP_EOL, substr ( $v, 2 ) );
						exit ( - 4 );
				}
				break;
			case 'c' : // compression
				switch (substr ( $v, 2 ))
				{
					case 'gzip' :
						$compression = Phar::GZ;
						$extension = '.gz';
						break;
					case 'bzip2' :
						
						$compression = Phar::BZ2;
						$extension = '.bz2';
						break;
					default :
						printf ( 'Unsupported compression %s. Exit.' . PHP_EOL, substr ( $v, 2 ) );
						exit ( - 3 );
				}
		}
	}
}

$t1 = microtime ( true );
printf ( 'Create phar build of game components' . PHP_EOL );

$buildFile = __DIR__ . '/php-game-components.phar' . $extension;
$base_dir = realpath ( __DIR__ . '/../biz' );

if (file_exists ( $buildFile ))
{
	printf ( 'Unlinking old build' . PHP_EOL );
	Phar::unlinkArchive ( $buildFile );
}

printf ( 'Build from %s' . PHP_EOL, $base_dir );
printf ( 'Saving build to %s' . PHP_EOL, $buildFile );

$regex = '/[\w-_]?\.php/';
try
{
	$phar = new Phar ( $buildFile, 0, basename ( $buildFile ) );
	
	if (! is_null ( $compression ))
	{
		printf ( 'Compress build' . PHP_EOL );
		$phar->compress ( $compression );
	}
	
	$phar->startBuffering ();
	$phar->buildFromDirectory ( $base_dir, $regex );
	printf ( 'Added %d files' . PHP_EOL, $phar->count () );
	
	$metadata = array (
		'date' => date ( 'Y-m-dhH:i:s' ) 
	);
	$phar->setMetadata ( $metadata );
	
	printf ( 'Sign build' . PHP_EOL );
	$phar->setSignatureAlgorithm ( Phar::SHA512 );
	
	$phar->stopBuffering ();
}
catch ( UnexpectedValueException $e )
{
	printf ( 'Creating build file failed. Message: %s' . PHP_EOL, $e->getMessage () );
	exit ( - 2 );
}
catch ( Exception $ex )
{
	printf ( 'Creating build file failed. Message: %s' . PHP_EOL, $ex->getMessage () );
	exit ( - 1 );
}
printf ( 'Creating build took %f ms' . PHP_EOL, microtime ( true ) - $t1 );
printf ( 'Include into your application with %s' . PHP_EOL, "\n\trequire_once \"phar:/" . $buildFile . "\";" );
