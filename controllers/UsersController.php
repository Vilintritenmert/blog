<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use app\models\User;
use app\models\UserSearch;
use app\models\Invite;

class UsersController extends Controller
{
    /**
     * Default Actions
     *
     * @var string
     */
    public $defaultAction='index';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules'=>[
                    [
                        'allow'        =>true,
                        'actions'      =>['index','invite','update'],
                        'matchCallback'=>function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        },
                    ],
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
            'error'=>[
                'class'=>'yii\web\ErrorAction',
            ],
        ];
    }

      /**
     * Send Invite to user
     * @return mixed
     */
    public function actionInvite()
    {
        $model=new Invite;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('invite', [
                'model'=>$model,
            ]);
        }
    }


    /**
     * Show List Users
     */
    public function actionIndex()
    {
        $searchModel =new UserSearch();
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' =>$searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model=$this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if(Yii::$app->request->post('author'))
            {
                $model->setRoleAuthor();
            } else {
                $model->setRoleClient();
            }

            return $this->redirect(['update', 'id'=>$model->id]);
        } else {
            return $this->render('update', [
                'model'=>$model,
            ]);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model=User::findOne($id);

        if ($model) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
