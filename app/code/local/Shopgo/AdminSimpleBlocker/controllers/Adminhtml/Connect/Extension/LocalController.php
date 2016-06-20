<?php
 /**
 * ShopGo
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category    Shopgo
 * @package     Shopgo_AdminSimpleBlocker
 * @copyright   Copyright (c) 2016 ShopGo. (http://www.shopgo.me)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Local Magento Connect controller
 *
 * @category    Shopgo
 * @package     Shopgo_AdminSimpleBlocker
 * @author      Ammar <ammar@shopgo.me>
 */
require_once Mage::getModuleDir('controllers', 'Mage_Connect') . DS . 'Adminhtml' . DS . 'Extension'. DS . 'LocalController.php';

class Shopgo_AdminSimpleBlocker_Adminhtml_Connect_Extension_LocalController extends Mage_Connect_Adminhtml_Extension_LocalController
{
    /**
     * Redirect to Magento Connect
     *
     */
    public function indexAction()
    {
        //@TODO: For some reason, the controller is not overridden correctly,
        // and this function is not working.
        // Will look into it later.
        if (Mage::helper('adminsimpleblocker')->isUserAllowed()) {
            $url = Mage::getBaseUrl('web') . 'downloader/?return=' . urlencode(Mage::getUrl('adminhtml'));
            $this->getResponse()->setRedirect($url);
        } else {
            $this->deniedAction();
        }
    }
}
