# Laravel 5 Random Job Queue Driver

Just like the database queue driver, but process jobs in random order.

### Install

Require the latest version of this package with Composer

    composer require KGiedrius/laravel-random-job-database-queue-driver:"1.x"

Add the Service Provider to the providers array in config/app.php

    KGiedrius\Queue\RandomDatabaseJobServiceProvider::class,

You need to create the migration table for queues and run it.

    $ php artisan queue:table
    $ php artisan migrate

In config/queue.php.

    'default' => 'DbRand',

    'connections' => array(
        'DbRand' => array(
            'driver' => 'DbRand',
            'table' => 'jobs',
            'queue' => 'default',
            'expire' => 60,
        ),
        ...
    }


For more info see http://laravel.com/docs/queues

