<?php

namespace app\components;

use yii\base\Widget;
use app\models\Post;

/**
 * Widget for Post view
 *
 * Class PostViewWidget
 */
class PostViewWidget extends Widget
{
    public $post;

    /**
     * Initialization
     */
    public function init()
    {
        $this->post?: new Post;

        return parent::init();
    }

    /**
     * Run widget
     *
     * @return string
     */
    public function run()
    {
        return $this->render('view',
            [
                'post'=>$this->post
            ]);
    }
}