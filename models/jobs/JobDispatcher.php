<?php

namespace app\models\jobs;

/**
 * Class JobDispatcher
 * @package app\models\jobs
 */
trait JobDispatcher
{

    /**
     * @param Job $job
     * @return mixed
     */
    public function dispatch(Job $job)
    {
        return $job->handle();
    }
}
