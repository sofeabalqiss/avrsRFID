<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use App\Models\Rfid;
use Carbon\Carbon;

class DeactivateExpiredRfids extends Command
{
    protected $signature = 'rfids:deactivate-expired';
    protected $description = 'Deactivate expired RFID tags and reset permanent ones to reusable';

    public function handle()
    {
        // Get all active RFIDs with their latest visitor
        $rfids = Rfid::with('latestVisitor')
                    ->where('status', 'active')
                    ->get();

        $deactivated = 0;
        $converted = 0;

        foreach ($rfids as $rfid) {
            $latest = $rfid->latestVisitor;

            if ($latest && $latest->valid_until < now()) {
                $updateData = ['status' => 'inactive'];

                if ($rfid->type === 'permanent') {
                    $updateData['type'] = 'reusable'; // Reset to reusable
                    $converted++;
                }

                $rfid->update($updateData);
                $deactivated++;
            }
        }

        $this->info("Deactivated {$deactivated} expired RFIDs");
        if ($converted > 0) {
            $this->info("Converted {$converted} permanent RFIDs to reusable");
        }

        return 0;
    }

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('rfids:deactivate-expired')->dailyAt('23:59');
    }
}
