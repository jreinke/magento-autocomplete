<?php
/**
 * @category    Bubble
 * @package     Bubble_Autocomplete
 * @version     1.0.0
 * @copyright   Copyright (c) 2014 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_Autocomplete_ProductController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieve all products from current store as JSON
     */
    public function jsonAction()
    {
        $cacheId = 'bubble_autocomplete_' . Mage::app()->getStore()->getId();
        if (false === ($data = Mage::app()->loadCache($cacheId))) {
            $collection = Mage::getModel('catalog/product')->getCollection()
                ->addAttributeToFilter('name', array('notnull' => true))
                ->addAttributeToFilter('image', array('notnull' => true))
                ->addAttributeToFilter('url_path', array('notnull' => true))
                ->addStoreFilter()
                ->addPriceData()
                ->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInSiteIds());

            Mage::dispatchEvent('bubble_autocomplete_product_collection', array('collection' => $collection));

            $data = json_encode($collection->getData());

            $lifetime = Mage::helper('bubble_autocomplete')->getCacheLifetime();
            Mage::app()->saveCache($data, $cacheId, array('block_html'), $lifetime);
        }

        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody($data);
    }
}
