<?php

class Popov_Wp_Block_Last extends Mage_Core_Block_Template
{
    protected $posts = array();

    /**
     * @return \Popov_Wp_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('popov_wp');
    }

    public function getPosts()
    {
        if ($this->getHelper()->isEnabled() && !$this->posts) {
            $collection = Mage::getModel('popov_wp/post')->getCollection()
                ->setOrder('post_date', 'desc')
            ;

            $select = $collection->getSelect();
            $select->limit(5);

            $select->joinLeft(
                ['wm1' => 'wp_postmeta'],
                'wm1.post_id = main_table.id AND wm1.meta_value IS NOT NULL AND wm1.meta_key = "_thumbnail_id"'
            /*array(
                "{$tableJoinAlias}.Name AS configurable_name",
            )*/
            );

            $select->joinLeft(
                ['wm2' => 'wp_postmeta'],
                'wm1.meta_value = wm2.post_id AND wm2.meta_key = "_wp_attached_file" AND wm2.meta_value IS NOT NULL'
            /*array(
                "{$tableJoinAlias}.Name AS configurable_name",
            )*/
            );

            $select->where('main_table.post_status = ?', 'publish');
            $select->where('main_table.post_type = ?', 'post');
            //Zend_Debug::dump([count($collection), $collection->getFirstItem()->getData()]);
            //die(__METHOD__);
            /*if ($this->_helper()->getEnabled()) {
                return $this->setData('blog_widget_recent_count', $this->getBlocksCount())->renderView();
            }*/

            $this->posts = $collection;
        }
        
        return $this->posts;
    }

    /*protected function _toHtml()
    {
        return __METHOD__;
    }*/

    /*public function getRecent()
    {
        $collection = Mage::getModel('blog/blog')->getCollection()
            ->addPresentFilter()
            ->addEnableFilter(Smartwave_Blog_Model_Status::STATUS_ENABLED)
            ->addStoreFilter()
            ->setOrder('created_time', 'desc')
        ;

        if ($this->getBlogCount()) {
            $collection->setPageSize($this->getBlogCount());
        } else {
            $collection->setPageSize(Mage::helper('blog')->getRecentPage());
        }

        if ($collection && $this->getData('categories')) {
            $collection->addCatsFilter($this->getData('categories'));
        }
        foreach ($collection as $item) {
            $item->setAddress($this->getBlogUrl($item->getIdentifier()));
        }
        return $collection;
    }*/
}