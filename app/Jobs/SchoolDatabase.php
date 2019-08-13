<?php

namespace App\Jobs;

use App\School;
use Illuminate\Bus\Queueable;
use App\Services\SchoolManager;
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
        $connection = \DB::connection('school');
        $createDB = $connection->statement("CREATE DATABASE IF NOT EXISTS {$database}");

        if ($createDB) {
            $this->schoolManager->setSchool($this->school);
            $connection->reconnect();
            $this->migrate($database);
        } else {
            $connection->statement("DROP DATABASE {$database}");
        }
    }

    private function migrate()
    {
        $migrator = app('migrator');
        $migrator->setConnection('school');

        if (! $migrator->repositoryExists()) {
            $migrator->getRepository()->createRepository();
        }
        $migrator->run('tenants:migrate');
    }
}
