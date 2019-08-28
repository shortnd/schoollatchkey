<?php

namespace App\Console\Commands;

use App\School;
use App\Services\SchoolManager;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

class SchoolFresh extends Command
{
    use ConfirmableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schools:migrate:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops tables and remigrate database';

    protected $schoolManager;

    protected $migrator;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SchoolManager $schoolManager)
    {
        parent::__construct();

        $this->schoolManager = $schoolManager;
        $this->migrator = app('migrator');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $schools = School::all();

        foreach ($schools as $school) {
            $this->schoolManager->setSchool($school);

            \DB::connection('school')->reconnect();
            \DB::purge();
            $this->migrate();

        }
    }

    protected function migrate()
    {
        $this->prepareDatabase();
        $this->migrator->run(database_path('migrations/tenants'), []);

        foreach ($this->migrator->setOutput($this->output) as $note) {
            $this->output->writeln($note);
        }
    }

    protected function prepareDatabase()
    {
        $this->migrator->setConnection('school');

        if ($this->migrator->repositoryExists()) {
            $this->call('migrate:fresh');
        }
    }
}
