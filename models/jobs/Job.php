<?php

namespace app\models\jobs;

/**
 * Interface Job
 * @package app\models\jobs
 */
abstract class Job
{
    use JobDispatcher;

    abstract public function handle();
}
