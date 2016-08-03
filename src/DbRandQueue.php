<?php
namespace KGiedrius\Queue;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use Illuminate\Queue\DatabaseQueue;
use Illuminate\Queue\Jobs\DatabaseJob;
use Symfony\Component\Process\Process;

class DbRandQueue extends DatabaseQueue
{
    protected function getNextAvailableJob($queue)
    {
        $orderBy = config('database.default') == 'sqlite' ? 'random()' : 'rand()';



        $job = $this->database->table($this->table)
            ->lockForUpdate()
            // ->where('queue', $this->getQueue($queue))
            ->where('reserved', 0)
            ->where('available_at', '<=', $this->getTime())
            ->orderByRaw($orderBy)
            ->first();

        if ($job) echo $job->queue.':'.$job->id.';';


        return $job ? (object)$job : null;
    }
}
