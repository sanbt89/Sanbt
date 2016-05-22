<?php

namespace Sanbt\Jobs\Model\ResourceModel\Job;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = \Sanbt\Jobs\Model\Job::JOB_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Sanbt\Jobs\Model\Job', 'Sanbt\Jobs\Model\ResourceModel\Job');
    }

    /**
     * Retrieve the collection
     *
     * @param $job
     * @param $department
     * @return $this
     */
    public function addStatusFilter($job, $department){
        $this->addFieldToSelect('*')
            ->addFieldToFilter('status', $job->getEnableStatus())
            ->join(
                array('department' => $department->getResource()->getMainTable()),
                'main_table.department_id = department.'.$department->getIdFieldName(),
                array('department_name' => 'name')
            );

        // AND
        $this->addFieldToSelect('*')
            ->addFieldToFilter('status', array('eq' => $job->getEnableStatus()))
            ->addFieldToFilter('date', array('gt' => date('Y-m-d')));

        // OR
        $this->addFieldToSelect('*')
            ->addFieldToFilter(
                array(
                    'status',
                    'date'
                ),
                array(
                    array('eq' => $job->getEnableStatus()),
                    array('gt' => date('Y-m-d'))
                )
            );

        // LEFT JOIN
        $this->addFieldToSelect('*')
            ->addFieldToFilter('status', $job->getEnableStatus())
            ->getSelect()
            ->joinLeft(
                array('department' => $department->getResource()->getMainTable()),
                'main_table.department_id = department.'.$department->getIdFieldName(),
                array('department_name' => 'name')
            );

        // status is equal to 1, name is like '%sample%' or it's date is greater than equal today
        $this->addFieldToSelect('*')
            ->addFieldToFilter('status', $job->getEnableStatus())
            ->addFieldToFilter(
                array(
                    'name',
                    'date'
                ),
                array(
                    array('like' => '%Sample%'),
                    array('gteq' => date('Y-m-d'))
                )
            )
            ->getSelect()
            ->joinLeft(
                array('department' => $department->getResource()->getMainTable()),
                'main_table.department_id = department.'.$department->getIdFieldName(),
                array('department_name' => 'name')
            );

        // status is equal to 1, or status is equal to 0 and the date is greater than equal today
        // or the ID is greater than equal to 0 and, whether the date is less than today, whether department name is like '%mar%'
        $this->addFieldToSelect('*')
            ->getSelect()
            ->joinLeft(
                array('department' => $department->getResource()->getMainTable()),
                'main_table.department_id = department.'.$department->getIdFieldName(),
                array('department_name' => 'name')
            )
            ->where('main_table.status = ?', $job->getEnableStatus())
            ->orWhere('main_table.status = ? AND main_table.date >= '.date('Y-m-d'), $job->getDisableStatus())
            ->orWhere('main_table.'.$job->getIdFieldName().' > 0 && (main_table.date < '.date('Y-m-d').' || department.name LIKE "%mar%")');


        return $this;
    }
}