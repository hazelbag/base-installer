<?php

namespace Hazelbag\BaseInstaller\Console;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'base:install';

    /**
     * The console command Description.
     *
     * @var string
     */

    protected $description = 'Base installer to verify the contents of the env file';

    /**
     * Execute the console command
     *
     * @return void
     */

    public function handle()
    {
        $this->info("Running Base Installer.");
        $this->info("");

        if (!$this->checkEnvFile()) exit(1);
        if (!$this->checkDatabaseCredentials()) exit(1);
        $this->info("Running migrations");
        Artisan::call('migrate', [ '--force' => true ], $this->getOutput());
        $this->setupSupportUser();
        $this->info("Installer finished");
    }

    private function checkEnvFile()
    {
        if (file_exists(base_path('.env'))) {
            // File exists, check if stuff is set
            $this->info("[checkEnvFile] .env file exists");
            return true;
        } else {
            $this->warn(".env file not present, create one by running:\n");
            $this->warn("    cp .env.example .env\n");
            $this->warn("    php artisan key:gen\n");
            $this->warn("Edit the .env file to set the variables correctly.");
            return false;
        }
    }

    private function checkDatabaseCredentials()
    {
        try {
            DB::connection('mysql')->getPdo();
            $this->info("[checkDatabaseCredentials] Successful PDO connection to mysql");
        } catch (\PDOException $ex) {
            $this->warn("Cannot connect to main database! Fix the DB_CONNECTION details and try again.");
            return false;
        }

        // All connections OK
        return true;
    }

    private function setupSupportUser()
    {
        $password = Str::random(8);
        $name = $this->ask('Your name?');
        $email = $this->ask('Your email?');

        $user = (new CreateNewUser())->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $user->id = 1000;
        $user->save();

        $this->info("[setupSupportUser] Created support user with password: $password");
    }
}