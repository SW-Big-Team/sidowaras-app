<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class GenerateSystemNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate system notifications (stok menipis, kadaluarsa, stock opname pending)';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $this->info('Generating system notifications...');
        
        $notificationService->generateSystemNotifications();
        
        $this->info('System notifications generated successfully!');
        
        return Command::SUCCESS;
    }
}
