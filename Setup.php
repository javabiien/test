<?php

namespace compotest;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Setup
{
    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
        echo "Welcome to CompoTest!\n";
    }

    public static function postAutoloadDump(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        some_function_from_an_autoloaded_file();
    }

    public static function postPackageInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        //self::config();
    }

    public static function warmCache(Event $event)
    {
        // make cache toasty
    }

    public static function readline($prompt = null){
        if($prompt){
            echo $prompt;
        }
        $fp = fopen("php://stdin","r");
        $line = rtrim(fgets($fp, 1024));
        return $line;
    }

    // created main .htaccess
    public static function htaccess($appfolder){
        $ht = "RewriteBase $appfolder\nRewriteEngine on\nRewriteCond %{REQUEST_FILENAME} !-d\nRewriteCond %{REQUEST_FILENAME} !-f\nRewriteRule (.*) index.php/$1 [L]";
        $file = fopen(".htaccess","w");
        fwrite($file,$ht);
        fclose($file);
    }


    public static function createCacheDir() {
        @mkdir("./cache/appData", 0700, true);
        //copy("app/.htaccess", "./cache/.htaccess");
    }     
   
    public static function install() {
        echo 'Welcome, CompoTest will be installed soon!\n';
        // create cache dir
        self::createCacheDir();
        self::htaccess("/");
    }
}




// launch install
Setup::install();
