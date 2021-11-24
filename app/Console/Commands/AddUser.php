<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {name} {pass} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

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
     * @return int
     */
    public function handle()
    {
        $model = User::create([
            'name' => $this->argument('name'),
            'password' => Hash::make($this->argument('pass')),
            'email' => $this->argument('email')
        ]);
        $this->info('User added');

        $this->info(
            $model->createToken('meteo-sensor', [
                'device:auth',
                'device:add-once'
            ])->plainTextToken);

        return Command::SUCCESS;
    }
}
