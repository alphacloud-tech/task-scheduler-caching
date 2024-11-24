<?php

namespace App\Console\Commands;

use App\Models\ApiLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean-old';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete API logs older than 5 minutes for testing purposes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // \DB::table('api_logs')
        //     ->where('created_at', '<', now()->subDays(30))
        //     ->delete();

        ApiLog::where('created_at', '<', Carbon::now()->subDays(30))->delete();
        // ApiLog::where('created_at', '<', Carbon::now()->subMinutes(2))->delete();
        // ApiLog::where('created_at', '<', now()->subDays(30))->delete();

        $this->info('Old logs cleaned successfully.');
    }
}