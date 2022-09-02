<?php

namespace App\Console\Commands;

use App\Admin;
use Hash;
use Illuminate\Console\Command;

class NewAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin with given credentials';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        (new Admin([
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
        ]))->save();

        $this->info('Created new admin with email ' . $this->argument('email'));
    }
}
