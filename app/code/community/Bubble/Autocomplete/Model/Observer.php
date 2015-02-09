<?php
/**
 * Bubble Autocomplete Observer.
 *
 * @category    Bubble
 * @package     Bubble_Autocomplete
 * @version     1.1.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_Autocomplete_Model_Observer
{
    /**
     * Attached to: bubble_autocomplete_product_collection_init
     *
     * This is the default collection initialization.
     * Feel free to add some fields by observing the event too or to disable this
     * one and add your custom logic.
     *
     * @link http://www.bubblecode.net/en/2012/01/21/disable-an-event-observer-defined-by-default-in-magento/
     *
     * @param Varien_Event_Observer $observer
     */
    public function onProductCollectionInit(Varien_Event_Observer $observer)
    {
        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = $observer->getEvent()->getCollection();
        $collection->addAttributeToFilter('name', array('notnull' => true))
            ->addAttributeToFilter('image', array('notnull' => true))
            ->addAttributeToFilter('url_path', array('notnull' => true))
            ->addStoreFilter()
            ->addPriceData()
            ->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInSiteIds());
    }
}