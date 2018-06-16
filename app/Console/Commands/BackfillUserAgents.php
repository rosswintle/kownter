<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackfillUserAgents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kownter:backfill-user-agents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses, user agent strings and populates details';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userAgents = \App\UserAgent::all();
        $userAgents->map( function($ua) { $ua->addDetails(); });
    }
}
