<?php

namespace App\Console\Commands;

use App\School;
use App\Invitation;
use App\Services\SchoolManager;
use Illuminate\Console\Command;

class SchoolInvitationClear extends Command
{
    private $schoolManager;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schools:daily-invitation-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears invitations where they have registered';

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
        foreach  ($schools as $school) {
            $this->schoolManager->setSchool($school);
            $invitations = Invitation::where('registered_at', '!=', null)->get();
            foreach ($invitations as $invitation) {
                $invitation->delete();
            }
            $this->comment('Invitations Deleted');
        }
    }
}
