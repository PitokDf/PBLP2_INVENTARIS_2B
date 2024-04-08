<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

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
        // Logika untuk membuat backup data
        $filename = 'backup-' . date('Y-m-d') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        // Jalankan perintah untuk membuat backup MySQL menggunakan mysqldump
        exec('mysqldump -u ' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' > ' . $path);

        $this->info('Backup data berhasil dibuat: ' . $filename);
    }

    // File: app/Console/Kernel.php

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:data')->everyMinute();
    }

}