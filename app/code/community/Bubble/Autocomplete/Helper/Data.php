<?php
/**
 * Bubble Autocomplete Helper.
 *
 * @category    Bubble
 * @package     Bubble_Autocomplete
 * @version     1.1.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_Autocomplete_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEnabled($store = null)
    {
        return Mage::getStoreConfigFlag('bubble_autocomplete/general/enable', $store);
    }

    public function getLimit($store = null)
    {
        return (int) Mage::getStoreConfig('bubble_autocomplete/general/limit', $store);
    }

    public function getMinLength($store = null)
    {
        return (int) Mage::getStoreConfig('bubble_autocomplete/general/min_length', $store);
    }

    public function getCacheLifetime($store = null)
    {
        return (int) Mage::getStoreConfig('bubble_autocomplete/general/cache_lifetime', $store);
    }

    public function getUseLocalStorage($store = null)
    {
        return Mage::getStoreConfigFlag('bubble_autocomplete/general/use_local_storage', $store);
    }

    public function getJsPriceFormat()
    {
        return Mage::app()->getLocale()->getJsPriceFormat();
    }

    public function getBaseUrl()
    {
        return Mage::app()->getStore()->getBaseUrl();
    }

    public function getBaseUrlMedia()
    {
        return Mage::getSingleton('catalog/product_media_config')->getBaseMediaUrl();
    }
}