<?php

namespace KGiedrius\Queue\Connectors;

use KGiedrius\Queue\DbRandQueue;
use Illuminate\Queue\Connectors\DatabaseConnector;

class DbRandConnector extends DatabaseConnector
{

    /**
     * Establish a queue connection.
     *
     * @param array $config
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new DbRandQueue(
			$this->connections->connection(array_get($config, 'connection')),
			$config['table'],
			$config['queue'],
			array_get($config, 'expire', 60),
            array_get($config, 'binary', 'php'),
            array_get($config, 'binary_args', ''),
            array_get($config, 'connection_name', '')
		);
    }
}
