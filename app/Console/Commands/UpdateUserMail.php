<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Jenssegers\Date\Date;

class UpdateUserMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user email for dev';

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
        $users = User::where('id','>',1)->orderBy('created_at', 'DESC')->get();



        foreach($users as $user)
        {
			$user->email = $user->id.$user->email;
			$user->update();
        }
    }
}
