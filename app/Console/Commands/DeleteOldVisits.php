<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Visit;
use Carbon\Carbon;

class DeleteOldVisits extends Command
{
    protected $signature = 'visits:clean';

    protected $description = 'Delete visits older than 6 months';

    public function handle()
    {
        $cutoff = Carbon::now()->subDays(180); // adjust as needed

        $count = Visit::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted $count old visit(s).");
    }
}
