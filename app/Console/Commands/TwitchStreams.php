<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TwitchStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:streams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get streams from twitch';

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
     */
    public function handle()
    {
        $executor = new \App\Workers\TwitchStreams();
        $executor->run();
    }
}
