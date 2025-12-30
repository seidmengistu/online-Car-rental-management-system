<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckOverdueRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rentals:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue rentals and notify customers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $overdueRentals = \App\Models\Rental::where('status', 'active')
            ->where('end_date', '<', now())
            ->get();

        foreach ($overdueRentals as $rental) {
            // Check if we haven't already sent a notification today (optional optimization)
            // For now, we'll just send it. The notification system handles basic throttling if configured.

            try {
                $rental->user->notify(new \App\Notifications\RentalOverdue($rental));
                $this->info("Notified user {$rental->user->name} for overdue rental #{$rental->id}");
            } catch (\Exception $e) {
                $this->error("Failed to notify user {$rental->user->name}: " . $e->getMessage());
            }
        }

        $this->info('Overdue rental check completed.');
    }
}
