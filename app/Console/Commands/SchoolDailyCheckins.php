<?php

namespace App\Console\Commands;

use App\Child;
use App\School;
use App\Services\SchoolManager;
use Illuminate\Console\Command;

class SchoolDailyCheckins extends Command
{
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
    protected $description = 'Add a new daily entry for every child in the database for each school';

    protected $schoolManager;

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
        $schools = School::all();

        foreach ($schools as $school) {
            $this->schoolManager->setSchool($school);
            \DB::connection('school')->reconnect();
            $children = Child::get();
            $children->each(function ($child) {
                $child->addCheckin();
                $child->addWeeklyTotal();
                $child->update([
                    'half_day' => false
                ]);
            });
        }

        $this->comment('Daily Tabled add to Children');
    }
}
