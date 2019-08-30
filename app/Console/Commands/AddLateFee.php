<?php

namespace App\Console\Commands;

use App\Child;
use App\School;
use App\Services\SchoolManager;
use Illuminate\Console\Command;

class AddLateFee extends Command
{
    private $schoolManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schools:children-latefee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add latefee for each cild checked in after 6pm';

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

            $children = Child::with(['checkins' => function ($query) {
                $query->whereDate('created_at', today());
            }])->with(['checkin_totals' => function ($query) {
                $query->whereBetween('created_at', [startOfWeek(), endOfWeek()]);
            }]);

            foreach ($children as $child) {
                if ($child->todaysCheckin->pm_checkin_time !== null && $child->todaysCheckin->pm_checkout_time == null) {
                    $late_fee = $child->todaysCheckin->late_fee + 1;
                    $total_amount = $child->checkins_total->first()->total_amount + 10;
                    $child->todaysCheckin()->update([
                        'late_fee' => $late_fee
                    ]);
                    $child->weeklyTotal()->update([
                        'total_amount' => $total_amount
                    ]);
                }
            }

            $this->comment("Late fees added for {$school->name}");
        }
    }
}
