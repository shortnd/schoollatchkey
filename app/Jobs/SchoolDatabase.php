<?php

namespace App\Jobs;

use App\School;
use App\Services\SchoolManager;
use Illuminate\Bus\Queueable;
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
        $database = 'tenant_'. $this->school->id;
        $connection = \DB::connection('tenant');
        $createDatabase = $connection->statement('CREATE DATABASE '. $database);

        if ($createDatabase) {
            $this->schoolManager->setSchool($this->school);
            $connection->reconnect();
            $this->migrate();
        } else {
            $connection->statement('DROP DATABASE '. $database);
        }
    }

    private function migrate()
    {
        $migrator = app('migrator');
        $migrator->setConnection('tenant');

        if (! $migrator->repositoryExists()) {
            $migrator->getRepository()->createRepository();
        }

        $migrator->run(database_path('migrations/tenants'), []);
    }
}
