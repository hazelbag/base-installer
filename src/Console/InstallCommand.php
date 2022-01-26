<?php

namespace Hazelbag\BaseInstaller\Console;

use App\Models\User;
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

    protected $description = 'Base installer to verify the contents of the env file, check your DB connection and create a Support User';

    /**
     * Execute the console command
     *
     * @return void
     */

    public function handle()
    {
        $this->info("Running Base Installer.");
        $this->info("");

        $userCreation = $this->confirm('Do you want to create a support user?');

        if (!$this->checkEnvFile()) exit(1);

        $databaseCheck = $this->confirm('Would you like to test your DB connection and run the migrations?');

        if($databaseCheck) {
            if (!$this->checkDatabaseCredentials()) exit(1);
            $this->info("Running migrations");
            Artisan::call('migrate', ['--force' => true], $this->getOutput());
        }

        if($userCreation && $databaseCheck) {
            $this->setupSupportUser();
        }

        $this->info("Installer finished");
    }

    private function checkEnvFile(): bool
    {
        if (file_exists(base_path('.env'))) {
            $this->info("[checkEnvFile] .env file exists");
            return true;
        } else {
            $this->warn(".env file not present, creating one by running:\n");
            $this->warn("    cp .env.example .env\n");
            $env = file_get_contents(base_path('.env.example'));
            file_put_contents(base_path('.env'), $env);
            $this->info('env file has been created.');
            $this->warn("    php artisan key:gen\n");
            Artisan::call('key:generate', ['--force' => true], $this->output);
            $this->warn("Remember to edit the env file to set your variables.");
            return true;
        }
    }

    private function checkDatabaseCredentials(): bool
    {
        try {
            DB::connection()->getPdo();
            $this->info("[checkDatabaseCredentials] Successful PDO connection to mysql");
        } catch (\PDOException $ex) {
            $this->warn("Cannot connect to main database! Fix the DB_CONNECTION details and try again.");
            return false;
        }
        return true;
    }

    private function setupSupportUser()
    {
        $password = Str::random(8);
        $name = $this->ask('Your name?');
        $email = $this->ask('Your email?');

        $user = (new User())->create([
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