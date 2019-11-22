<?php
use devskyfly\php56\core\Cli;
use devskyfly\php56\libs\fileSystem\Files;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\core\Info;

include 'vendor/autoload.php';

if(Files::fileExists(__DIR__.'/README.md')){
    print('README.md exists.').Info::PHP_EOL;
}else{
    print('README.md does not exist.').Info::PHP_EOL;
}