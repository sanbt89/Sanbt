<?php

namespace Sanbt\Jobs\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Department post mysql resource
 */
class Job extends AbstractDb
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init('sanbt_job', 'entity_id');
    }

    public function getEnableStatus() {
        return 1;
    }

    public function getDisableStatus() {
        return 0;
    }
    
}