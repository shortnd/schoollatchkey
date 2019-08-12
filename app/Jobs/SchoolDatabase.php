<?php

namespace App\Jobs;

use App\School;
use Illuminate\Bus\Queueable;
use App\Services\SchoolManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SchoolDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $school;

    protected $schoolManager;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(School $school, SchoolManager $schoolManager)
    {
        $this->school = $school;
        $this->schoolManager = $schoolManager;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $database = "school_{$this->school->id}";
        $connection = DB::connection('school');
        Log::alert('Database name: '.$connection->getDatabaseName());
        $connection->setDatabaseName(null);
        Log::alert('Connection: '. json_encode($connection));
        Log::alert('Database Name: '. $connection->getDatabaseName());

        if ($this->exists($connection, $database)) {
            Log::alert('Database already exits, dropping');
            $connection->statement("DROP DATABASE {$database}");
        }

        Log::alert("Creating database: {$database}");
        $createDatabase = $connection->statement("CREATE DATABASE {$database}");

        if ($createDatabase) {
            Log::alert('Database created successfully');
            $this->schoolManager->setSchool($this->school);
            $config['database'] = 'school_'. $this->school->id;
            $connection->reconnect();
            Log::alert('Running migrations');
            $this->migrate($database);
            Log::alert('Success!!');
        }
        // $database = 'school_'. $this->school->id;
        // $connection = \DB::connection('school');
        // // $createDatabase = $connection->statement('CREATE DATABASE '. $database);
        // $createDatabase = DB::connection('shared')->getPdo()->exec("CREATE DATABASE IF NOT EXISTS `{$database}`");

        // if ($createDatabase) {
        //     $this->schoolManager->setSchool($this->school);
        //     $connection->reconnect();
        //     $this->migrate();
        // } else {
        //     $connection->statement('DROP DATABASE '. $database);
        // }
    }

    private function migrate()
    {
        $migrator = app('migrator');
        $migrator->setConnection('school');

        if (! $migrator->repositoryExists()) {
            $migrator->getRepository()->createRepository();
        }

        $migrator->run(database_path('migrations/tenants'), []);
    }
}
