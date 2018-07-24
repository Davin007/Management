<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mockery\CountValidator\Exception;


class UserShell extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {user} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user from command';

    /**
     * User
     *
     * @var object
     */
    private $user;


    public function __construct()
    {
        parent::__construct();
        $this->user = new \App\User();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');
        $password = $this->argument('password');
        $email = $this->argument('email');
        $this->user->user_id = $this->user->generateUserId();
        $this->user->user_name = $user;
        $this->user->user_full_name = $user;
        $this->user->email = $email;
        $this->user->user_password = hash('sha256', $password);
        $this->user->department_id = 1; // Choose a default department
        $this->user->position_id = 1; // Choose a default position
        $this->user->role_id = 1; // Choose a default role
        $this->user->branch_id = 1; // Choose a default branch
        $this->user->created_at = date('Y-m-d H:i:s');
        $this->user->created_by = 0; // Created by console
        $this->user->updated_at = date('Y-m-d H:i:s');
        $this->user->updated_by = null;
        try {
            $this->user->save();
            $this->info('1 user created successfully.');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
