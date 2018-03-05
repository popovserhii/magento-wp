<?php

class Popov_Wp_Block_Last extends Mage_Core_Block_Template
{
    /**
     * @var Popov_Wp_Model_Post[]
     */
    protected $posts = [];

    public function getPosts()
    {
        if ($this->helper('popov_wp')->isEnabled() && !$this->posts) {
            $collection = Mage::getModel('popov_wp/post')->getCollection();

            $select = $collection->getSelect();

            $select->reset('columns');
            $select->columns('post_title');
            $select->columns('post_status');
            $select->columns('post_date');
            $select->columns('post_content');
            $select->columns('post_name');
            $select->columns(['post_guid' => 'guid']);
            $select->columns(['post_image' => '(SELECT `guid` FROM wp_posts WHERE id = m.meta_value)']);

            $select->joinLeft(
                ['m' => 'wp_postmeta'],
                'm.post_id = main_table.id',
                []
            );

            $select->where('main_table.post_status = ?', 'publish');
            $select->where('main_table.post_type = ?', 'post');
            $select->where('m.meta_key = ?', '_thumbnail_id');

            $select->limit($this->helper('popov_wp')->getNumberPostsOnHome());
            $select->order('post_date DESC');

            $this->posts = $collection;
        }

        return $this->posts;
    }
}