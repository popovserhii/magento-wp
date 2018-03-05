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

    //protected $_imageUrlFormat = '/wp-content/uploads/%s/%s-400x240.%s';
    protected $_imageUrlFormat = '%s/%s-400x240.%s';

    protected $_createdTime;

    protected function _construct()
    {
        $this->_init('popov_wp/post');
    }

    public function getBaseUrl()
    {
        if (!$this->_url) {
            $this->_url = parse_url($this->getData('post_guid'));
        }

        return $this->_url['scheme'] . '://' . $this->_url['host'];
    }

    public function getImageUrlFormat()
    {
        return /*$this->getBaseUrl() . */$this->_imageUrlFormat;
    }

    public function getCreatedTime()
    {
        if (!$this->_createdTime) {
            $this->_createdTime = new DateTime($this->getData('post_date'));
        }

        return $this->_createdTime;
    }

    public function getImage()
    {
        //return $image = $this->getData('post_image');
        if ($image = $this->getData('post_image')) {
            $pathInfo = pathinfo($image);
            $image = sprintf(
                $this->getImageUrlFormat(),
                $pathInfo['dirname'],
                $pathInfo['filename'],
                $pathInfo['extension']
            );
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