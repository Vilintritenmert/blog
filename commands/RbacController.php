<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\Post;
use app\models\Comment;
use Faker;

/**
 * Class RbacController
 * @package app\commands
 */
class RbacController extends Controller
{
    /**
     * Create Roles and User
     */
    public function actionInit()
    {
        $auth=Yii::$app->authManager;

        $client=$auth->createRole('client');
        $auth->add($client);

        $author=$auth->createRole('author');
        $auth->add($author);

        $admin=$auth->createRole('admin');
        $auth->add($admin);

        $user = new User();
        $user->email = 'ad@min.com';
        $user->username = 'admin';
        $user->setPassword('123456');
        $user->save();

        $authorUser = new User();
        $authorUser->email = 'au@thor.com';
        $authorUser->username = 'author';
        $authorUser->setPassword('123456');
        $authorUser->save();

        $auth->assign($author, $authorUser->getId());

        $faker = Faker\Factory::create();

        /**
         * Generate Posts
         */
        foreach(range(0,100) as $index)
        {
            $post = new Post;
            $post->title = $faker->text(80);
            $post->description = $faker->text(rand(3000,5000));
            $post->short_description = $faker->text(150);
            $post->author_id = $authorUser->getId();
            $post->publicated = 1;
            $post->save();

            /**
             * Generate Comment
             */
            foreach(range(0, rand(3,10)) as $indexComment)
            {
                $comment = new Comment;
                $comment->name = $faker->name;
                $comment->email = $faker->email;
                $comment->text = $faker->text(rand(15,50));
                $comment->post_id = $post->id;
                $comment->save();
            }
        }

    }

}