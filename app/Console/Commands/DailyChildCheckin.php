<?php

namespace App\Console\Commands;

use App\Child;
use App\Services\SchoolManager;
use Illuminate\Console\Command;

class DailyChildCheckin extends Command
{
    private $schoolManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schools:children-daily-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Daily Checkin for each child in each school.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SchoolManager $schoolManager)
    {
        parent::__construct();

        $this->schoolManager = $schoolManager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schools = School::get();

        foreach ($schools as $school) {
            $this->schoolManager->setSchool($school);
            $children = Child::get();

            foreach ($children as $child) {
                $child->addCheckin();
                $child->addWeeklyTotal();
            }

            $this->commet("Daily Checkin Table created for {$school->name}");
        }
    }
}
