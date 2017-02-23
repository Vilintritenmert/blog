<?php

namespace app\controllers;

use app\models\CommentForm;
use Yii;
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Post;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ResetPasswordForm;
use app\models\PasswordResetRequestForm;
use app\models\ContactForm;
use yii\data\Pagination;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'only' =>['logout','signup','login'],
                'rules'=>[
                    [
                        'actions'=>['logout'],
                        'allow'  =>true,
                        'roles'  =>['@'],
                    ],
                    [
                        'actions'=>['signup', 'login'],
                        'allow' =>true,
                        'roles' => ['?']
                    ]
                ],
            ],
            'verbs' =>[
                'class'  =>VerbFilter::className(),
                'actions'=>[
                    'logout'=>['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'  =>[
                'class'=>'yii\web\ErrorAction',
            ],
            'captcha'=>[
                'class'          =>'yii\captcha\CaptchaAction',
                'fixedVerifyCode'=>YII_ENV_TEST? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays main page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query      =Post::find();
        $postsOnPage=12;

        $pages=new Pagination([
            'defaultPageSize'=>$postsOnPage,
            'totalCount'     =>$query->count(),
        ]);

        $posts=$query->orderBy('name')
                     ->offset($pages->offset)
                     ->limit($pages->limit)
                     ->andWhere(['publicated'=>1])
                     ->orderBy('created_at')
                     ->all();

        return $this->render('index', [
            'posts'=>$posts,
            'pages'=>$pages,
        ]);
    }


    /**
     * Displays Post.
     *
     * @return string
     */
    public function actionView($id)
    {
        $post=$this->findModel($id);

        $model=new CommentForm();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->user->getIsGuest() && $model->validate() && $model->save()) {
            return $this->refresh();
        } else {

            return $this->render('view', [
                'post'       =>$post,
                'commentForm'=>$model,
            ]);
        }
    }


    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model=new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model'=>$model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model=new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user=$model->signup()) {
                if (Yii::$app->getUser()
                             ->login($user)
                ) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model'=>$model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model=new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error',
                    'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model'=>$model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model=new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model'=>$model,
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model=new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params[ 'adminEmail' ])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', [
            'model'=>$model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model=Post::find()
                   ->where(['id'=>$id])
                   ->andWhere(['publicated'=>1])
                   ->one();

        if ($model) {

            return $model;
        } else {

            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
