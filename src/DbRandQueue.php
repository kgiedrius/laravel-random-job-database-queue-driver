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
        $query = $this->database->table($this->table)
            ->lockForUpdate()
            ->where('reserved', 0)
            ->where('available_at', '<=', $this->getTime())
            ->orderBy('priority', 'desc');

        if ($queue != 'default') {
            $query = $query->where('queue', '=', $queue);
        }

        $job = $query->first();

        return $job ? (object)$job : null;
    }

    protected function buildDatabaseRecord($queue, $payload, $availableAt, $attempts = 0)
    {
        return [
            'queue'        => $queue,
            'attempts'     => $attempts,
            'reserved'     => 0,
            'reserved_at'  => null,
            'available_at' => $availableAt,
            'created_at'   => $this->getTime(),
            'priority'     => rand(1, 10000),
            'payload'      => $payload,
        ];
    }

}
