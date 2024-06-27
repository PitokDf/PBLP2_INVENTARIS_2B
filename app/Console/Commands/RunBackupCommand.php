<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\BackupDatabaseJob;

class RunBackupCommand extends Command
{
    protected $signature = 'run:backup';
    protected $description = 'Run the database backup job';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        BackupDatabaseJob::dispatch();
        $this->info('Backup job dispatched successfully.');
    }
}