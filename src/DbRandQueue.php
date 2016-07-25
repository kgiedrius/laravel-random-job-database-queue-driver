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
        $job = $this->database->table($this->table)
            ->lockForUpdate()
            ->where('queue', $this->getQueue($queue))
            ->where('reserved', 0)
            ->where('available_at', '<=', $this->getTime())
            ->orderBy('id', 'asc')
            ->first();

        return $job ? (object) $job : null;
    }
}
