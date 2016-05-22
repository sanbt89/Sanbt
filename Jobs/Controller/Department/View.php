<?php

namespace Sanbt\Jobs\Controller\Department;

class View extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Sanbt\Jobs\Model\Department
     */
    protected $_model;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Sanbt\Jobs\Model\Department $model
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Sanbt\Jobs\Model\Department $model
    )
    {
        $this->_model = $model;
        parent::__construct($context);
    }

    public function execute()
    {
        // Get param id
        $id = $this->getRequest()->getParam('id');
        $model = $this->_model;

        // No id, redirect
        if(empty($id)){
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $model->load($id);
        // Model not exists with this id, redirect
        if (!$model->getId()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/');
        }

        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}