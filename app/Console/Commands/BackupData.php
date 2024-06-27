<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\DbDumper\Databases\MySql;

class BackupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $databaseName = env('DB_DATABASE');
        $userName = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $backupPath = public_path('backups');

        $fileName = $databaseName . '_' . date('Y_m_d_His') . '.sql';

        MySql::create()
            ->setDbName($databaseName)
            ->setUserName($userName)
            ->setPassword($password)
            ->setHost($host)
            ->dumpToFile($backupPath . '/' . $fileName);

        $this->info('Backup data berhasil dibuat: ' . $fileName);
    }

    // File: app/Console/Kernel.php

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:data')->everyMinute();
    }

}