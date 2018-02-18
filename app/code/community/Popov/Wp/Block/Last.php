<?php

class Popov_Wp_Block_Last extends Mage_Core_Block_Template
{
    /**
     * @var Popov_Wp_Model_Post[]
     */
    protected $posts = array();

    /**
     * @return Popov_Wp_Helper_Data
     */
    public function getHelper()
    {
        return Mage::helper('popov_wp');
    }

    public function getPosts()
    {
        if ($this->getHelper()->isEnabled() && !$this->posts) {
            $collection = Mage::getModel('popov_wp/post')->getCollection()
                ->setOrder('post_date', 'desc');

            $select = $collection->getSelect();
            $select->limit($this->getHelper()->getNumberPostsOnHome());

            $select->joinLeft(
                ['wm1' => 'wp_postmeta'],
                'wm1.post_id = main_table.id AND wm1.meta_value IS NOT NULL AND wm1.meta_key = "_thumbnail_id"'
            );

            $select->joinLeft(
                ['wm2' => 'wp_postmeta'],
                'wm1.meta_value = wm2.post_id AND wm2.meta_key = "_wp_attached_file" AND wm2.meta_value IS NOT NULL'
            );

            $select->where('main_table.post_status = ?', 'publish');
            $select->where('main_table.post_type = ?', 'post');

            $this->posts = $collection;
        }
        
        return $this->posts;
    }
}