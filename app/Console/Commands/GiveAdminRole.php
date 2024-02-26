<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GiveAdminRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:give-admin-role {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gives the role of an admin to an user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $candidate = User::find($id); 
        if (!$candidate) {
            $this->error('Такого пользователя нет');
            return;
        }
        $candidate->role = 'ADMIN';
        $candidate->save();
        $this->info('Успешно выдан админ');
        return;
        
    }
}
