<?php

namespace Sanbt\Jobs\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Department post mysql resource
 */
class Department extends AbstractDb
{

    const DEPARTMENT_ID = 'entity_id';
    
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init('sanbt_department', 'entity_id');
    }

}