<?php
setlocale(LC_CTYPE, "en_US.UTF-8");
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $php = "C:/bin/php/php8.x/php.exe";
} else {
    $php = "/usr/bin/php";
}
define('DS', DIRECTORY_SEPARATOR);
/**
 * Prevent direct access to this file if not cli
 */
if ($_SERVER['REMOTE_ADDR'] != 'x.x.x.x' && php_sapi_name() != 'cli') {
    // silence is golden
    exit;
}
/**
 * Function to run composer commands on the server
 * This function is used by the composer.php script to run composer commands on the server, it uses the exec()/shell_exec()/system()/passthru() (depending on the availability) to run the command and return the output.
 *
 * @param $command string
 * @param $path string
 * @return string
 */
function runComposerCommand($command, $path = null)
{
    global $php;
    $output = '';
    $command = $php . ' ' . dirname(__FILE__) . DS . 'composer.phar ' . $command;
    if (!file_exists(dirname(__FILE__) . DS . 'composer.phar')) {
        $command = $php . ' ' . dirname(__FILE__) . DS . 'composer-setup.php ' . $command;
    }
    if ($path) {
        $command .= ' --working-dir=' . $path;
    } else {
        $path = dirname(__FILE__);
        if (!file_exists($path . DS . 'composer.json') && !file_exists($path . DS . 'composer.lock') && file_exists('/usr/bin/composer')) {
            $command = 'composer ' . $command;
        } elseif (!file_exists($path . DS . 'composer.json') && !file_exists($path . DS . 'composer.lock') && file_exists('/usr/bin/composer')) {
            $command = 'composer ' . $command;
        } else {
            die('composer.json not found and/or composer is not available.');
        }
    }
    $output = runCommand($command, $path);
    return $output;
}

function runCommand($command, $path = null) {
    if ($path) {
        $command1 = 'cd ' . $path . ' && ' . $command;
        if (runCommand($command1)) {
            runCommand($command);
        }
    }
    $output = '';
    if (function_exists('passthru')) {
        ob_start();
        passthru($command);
        $output = ob_get_contents();
        ob_end_clean();
    } elseif (function_exists('system')) {
        ob_start();
        system($command);
        $output = ob_get_contents();
        ob_end_clean();
    } else {
        $output = 'Command execution not possible on this system';
    }
    return $output;
}

/**
 * Function to get composer.phar file if not exists
 * This function is used by the composer.php script to get the composer.phar file if not exists.
 * @return string
 */
function getComposerPhar()
{
    if (file_exists(dirname(__FILE__) . DS . 'composer.phar')) {
        return dirname(__FILE__) . DS . 'composer.phar';
    }

    $composerPhar = dirname(__FILE__) . DS . 'composer.phar';
    if (!file_exists($composerPhar)) {
        $composerPhar = dirname(__FILE__) . DS . 'composer-setup.php';
        if (!file_exists($composerPhar)) {
            $composerPhar = dirname(__FILE__) . DS . 'composer-setup.php';
            $composerSetup = file_get_contents('https://getcomposer.org/installer');
            file_put_contents($composerPhar, $composerSetup);
        }
        $output = runComposerCommand('install', dirname(__FILE__));
        if (file_exists(dirname(__FILE__) . DS . 'composer.phar')) {
            unlink(dirname(__FILE__) . DS . 'composer-setup.php');
        }
    }
    return $composerPhar;
}

// start using the function
$composerPhar = getComposerPhar();
if (!file_exists($composerPhar)) {
    die('composer.phar not found');
}
//$output = runComposerCommand('self-update', dirname(__FILE__));
$output = runComposerCommand('update', dirname(__FILE__));
echo $output;
exit;
$output = runComposerCommand('install', dirname(__FILE__));
// check if output contains: 'Nothing to install or update'
if (strpos($output, 'Nothing to install or update') !== false) {
    $output = 'Nothing to install or update';
} elseif (strpos($output, 'lock file is not up to date with the latest changes in composer.json') !== false) {
    echo 'lock file is not up to date with the latest changes in composer.json, running update...';
    $output = runComposerCommand('update', dirname(__FILE__));
}
echo $output;
