<?php

namespace Sanbt\Jobs\Cron;

class DisableJobs
{
    /**
     * @var \Sanbt\Jobs\Model\Job
     */
    protected $_job;

    /**
     * @param \Sanbt\Jobs\Model\Job $job
     */
    public function __construct(
        \Sanbt\Jobs\Model\Job $job
    ) {
        $this->_job = $job;
    }

    /**
     * Disable jobs which date is less than the current date
     *
     * @return void
     */
    public function execute()
    {
        $nowDate = date('Y-m-d');
        $jobsCollection = $this->_job->getCollection()
            ->addFieldToFilter('date', array ('lt' => $nowDate));

        foreach($jobsCollection AS $job) {
            $job->setStatus($job->getDisableStatus());
            $job->save();
        }
    }
}