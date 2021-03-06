<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2018 Serhii Popov
 * This source file is subject to The MIT License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category Popov
 * @package Popov_Wp
 * @author Serhii Popov <popow.serhii@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License (MIT)
 */
class Popov_Wp_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function isEnabled()
    {
        return Mage::getStoreConfig('popov_wp/settings/enable');
    }

    public function getSiteUrl()
    {
        return Mage::getStoreConfig('popov_wp/settings/site_url');
    }

    public function getTopName()
    {
        return Mage::getStoreConfig('popov_wp/settings/top_links_name');
    }

    public function getPosition()
    {
        return Mage::getStoreConfig('popov_wp/settings/top_links_position');
    }

    public function getNumberPostsOnHome()
    {
        return Mage::getStoreConfig('popov_wp/settings/number_posts_on_home');
    }
}