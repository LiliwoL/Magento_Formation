<?php

namespace FormationMagento\ChangeCustomerPasswordBackend\Block\Adminhtml\Customer;

use Magento\Backend\Block\Template;

/**
 * phpcs:ignore Magento2.Legacy.Copyright.FoundCopyrightMissingOrWrongFormat
 * Class PasswordChange for block
 */
class PasswordChange extends Template
{
    /**
     * Get current customer id
     *
     * @return int
     */
    public function getCustomerId(): int
    {
        return (int)$this->getRequest()->getParam('id');
    }
}
