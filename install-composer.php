<?php
// Composer installer script for shared hosting
echo "Starting Composer installation...\n";

// Download composer
copy('https://getcomposer.org/installer', 'composer-setup.php');

// Verify installer
if (hash_file('sha384', 'composer-setup.php') === file_get_contents('https://composer.github.io/installer.sig')) {
    echo 'Installer verified';
} else {
    echo 'Installer corrupt';
    unlink('composer-setup.php');
    exit;
}

// Run installer
echo shell_exec('php composer-setup.php');
unlink('composer-setup.php');

// Install dependencies
echo "Installing dependencies...\n";
echo shell_exec('php composer.phar install --no-dev --optimize-autoloader');

// Generate key
echo shell_exec('php artisan key:generate');

echo "Installation complete!";
?>