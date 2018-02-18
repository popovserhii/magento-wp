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
class Popov_Wp_Model_Post extends Mage_Core_Model_Abstract
{
    /**
     * @var Mage_Core_Model_Url
     */
    protected $_url;

    protected $_baseImageUrl = '/wp-content/uploads';

    protected $_createdTime;

    protected function _construct()
    {
        $this->_init('popov_wp/post');
    }

    public function getBaseUrl()
    {
        if (!$this->_url) {
            $this->_url = parse_url($this->getData('guid'));
        }

        return $this->_url['scheme'] . '://' . $this->_url['host'];
    }

    public function getBaseImageUrl()
    {
        return $this->getBaseUrl() . $this->_baseImageUrl;
    }

    public function getCreatedTime()
    {
        if (!$this->_createdTime) {
            $this->_createdTime = new DateTime($this->getData('post_data'));
        }

        return $this->_createdTime;
    }

    public function getImage()
    {
        if ($image = $this->getData('meta_value')) {
            $image = $this->getBaseImageUrl() . '/' . $image;
        }

        return $image;
    }

    public function getPostUrl()
    {
        return $this->getBaseUrl() . '/' . $this->getData('post_name');
    }

    public function getPostTitle()
    {
        return $this->getData('post_title');
    }

    public function getDay()
    {
        return $this->getCreatedTime()->format('j');
    }

    public function getMonthShort()
    {
        return $this->getCreatedTime()->format('M');
    }

    public function getPostExcerpt()
    {
        $truncated = Mage::helper('popov_base/string')
                ->create(strip_tags($this->getData('post_content')))
                ->truncateWord($length = '15') . '...';

        return $truncated;
    }
}