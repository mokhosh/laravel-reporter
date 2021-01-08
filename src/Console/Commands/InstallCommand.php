<?php

namespace Mokhosh\Reporter\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'reporter:install';
    protected $description = 'Install laravel-reporter\'s npm dependencies.';

    public function __construct()
    {
        parent::__construct();

        if (file_exists(base_path('node_modules/@nesk'))) {
            $this->setHidden(true);
        }
    }

    public function handle()
    {
        shell_exec('npm install @nesk/puphpeteer');
        return 0;
    }
}
