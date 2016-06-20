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
 * Helper data
 *
 * @category    Shopgo
 * @package     Shopgo_AdminSimpleBlocker
 * @author      Ammar <ammar@shopgo.me>
 */
class Shopgo_AdminSimpleBlocker_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Admin usernames with full access
     *
     * @var array
     */
    protected $fullAccessAdminUsers = array(
        '-'
    );

    /**
     * Blocked resources
     *
     * @var array
     */
    protected $blockedResources = array(
        'admin/system/tools/backup',
        'admin/system/tools/compiler',
        'admin/system/extensions/custom',
        'admin/system/config/advanced'
    );

    /**
     * Blocked admin menu items names
     *
     * @var array
     */
    protected $blockedAdminMenuItemsNames = array(
        'extensions', 'tools'
    );

    /**
     * Blocked admin menu items actions
     *
     * @var array
     */
    protected $blockedAdminMenuItemsActions = array(
        'adminhtml/system_backup',
        'adminhtml/extension_local'
    );

    /**
     * Check whether admin user has access
     *
     * @return bool
     */
    public function isUserAllowed()
    {
        $result = false;
        $fullAccessAdminUsers = array_flip($this->fullAccessAdminUsers);

        switch (true) {
            case isset($fullAccessAdminUsers['*']):
                $result = true;
                break;
            case isset($fullAccessAdminUsers['-']):
                $result = false;
                break;
            default:
                $user = Mage::getSingleton('admin/session')->getUser();
                if ($user) {
                    $result = $user && isset($fullAccessAdminUsers[$user->getUsername()]);
                }
        }

        return $result;
    }

    /**
     * Check whether a resource is blocked
     *
     * @param string $resource
     * @return bool
     */
    public function isBlockedResource($resource)
    {
        $blockedResources = array_flip($this->blockedResources);

        return (!$this->isUserAllowed()) && isset($blockedResources[$resource]);
    }

    /**
     * Check whether admin menu item is blocked
     *
     * @param string $itemName
     * @param Varien_Simplexml_Element $item
     * @return bool
     */
    public function isBlockedAdminMenuItem($itemName = '', $item = null)
    {
        $result = false;

        switch (true) {
            case isset($itemName):
                $blockedAdminMenuItems = array_flip($this->blockedAdminMenuItemsNames);

                if (isset($blockedAdminMenuItems[$itemName])) {
                    $result = true;
                    break;
                }
            case $item && isset($item->action):
                $blockedAdminMenuItems = array_flip($this->blockedAdminMenuItemsActions);
                $result = isset($blockedAdminMenuItems[(string)$item->action]);

                break;
        }

        return (!$this->isUserAllowed()) && $result;
    }
}
