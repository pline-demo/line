<?php
$required=['index.php','.htaccess','config/app.php','routes/web.php','database/migrations/001_initial_schema.sql'];
foreach($required as $file){if(!is_file(__DIR__.'/../'.$file)){fwrite(STDERR,"Missing $file\n");exit(1);}}
$files=array_merge(glob(__DIR__.'/../app/**/*.php'),glob(__DIR__.'/../resources/views/**/*.php'),[__DIR__.'/../index.php']);
foreach($files as $file){$out=[];$code=0;exec('php -l '.escapeshellarg($file),$out,$code);if($code!==0){fwrite(STDERR,implode("\n",$out)."\n");exit(1);}}
echo "PERLINA smoke checks passed\n";
