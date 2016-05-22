<?php

namespace Sanbt\Jobs\Model\ResourceModel\Department;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = \Sanbt\Jobs\Model\Department::DEPARTMENT_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Sanbt\Jobs\Model\Department', 'Sanbt\Jobs\Model\ResourceModel\Department');
    }

}