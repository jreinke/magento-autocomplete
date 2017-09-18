<?php
/**
 * @category    Bubble
 * @package     Bubble_Autocomplete
 * @version     1.1.2
 * @copyright   Copyright (c) 2015 BubbleShop (https://www.bubbleshop.net)
 */
class Bubble_Autocomplete_ProductController extends Mage_Core_Controller_Front_Action
{
    /**
     * Retrieve all products from current store as JSON
     */
    public function jsonAction()
    {
        $cacheId = 'bubble_autocomplete_' . Mage::app()->getStore()->getId();
        $data = Mage::app()->loadCache($cacheId);
        if (!$data) {
            $collection = Mage::getModel('catalog/product')->getCollection();
            $collection->addAttributeToSelect('sku');
            $collection->addAttributeToSelect('name');
            $collection->addAttributeToSelect('price');
            $collection->addAttributeToSelect('min_price');
            $collection->addAttributeToSelect('final_price');
            $collection->addAttributeToSelect('url_path');
            $collection->addAttributeToSelect('image');

            Mage::dispatchEvent('bubble_autocomplete_product_collection_init', array('collection' => $collection));

            $newArray = array();
            // Convert to JSON
            $jsonData = json_encode($collection->getData());
            $decoded = json_decode($jsonData);
            foreach ($decoded as $d) {
                if (!property_exists($d, 'sku') ||
                    !property_exists($d, 'name') ||
                    !property_exists($d, 'price') ||
                    !property_exists($d, 'min_price') ||
                    !property_exists($d, 'final_price') ||
                    !property_exists($d, 'url_path') ||
                    !property_exists($d, 'image')
                ) {
                    continue;
                }
                $newArray[] = array(
                    'sku' => $d->sku,
                    'name' => $d->name,
                    'price' => $d->price,
                    'min_price' => $d->min_price,
                    'final_price' => $d->final_price,
                    'image' => $d->image,
                    'url_key' => $d->url_path
                );
            }

            $finalJson = json_encode($newArray);

            $lifetime = Mage::helper('bubble_autocomplete')->getCacheLifetime();
            Mage::app()->saveCache($finalJson, $cacheId, array('block_html'), $lifetime);
        }

        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody($data);
    }
}
