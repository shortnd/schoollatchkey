<?php

namespace App\Jobs;

use App\User;
use App\ChildParent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ChildParentDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $parent = ChildParent::where('user_id', $this->user->id)->first();
        } catch(\Exception $e) {
            Log::emergency('ChildParentDelete Error ' . $e);
        }
        Log::info("{$this->user->name} parent account deleted");
        $parent->delete();
    }
}
