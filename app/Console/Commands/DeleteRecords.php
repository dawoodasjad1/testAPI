<?php

namespace App\Console\Commands;

use App\Models\Contact;
use Illuminate\Console\Command;

class DeleteRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Contact::whereRaw('DATEDIFF(NOW(), created_at) > 30')->delete();

        return true;
    }
}
