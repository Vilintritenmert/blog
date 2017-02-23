<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use app\models\Post;
use app\models\PostSearch;

class DashboardController extends Controller
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
                        'actions'      =>['index', 'create', 'update', 'delete', 'view'],
                        'matchCallback'=>function ($rule, $action) {
                            $user=Yii::$app->user->identity;

                            if ($user && ($user->isAdmin() || $user->isAuthor())){
                                return true;
                            } else {
                                return $action->controller->redirect('dashboard/client');
                            }
                        },
                    ],
                    [
                        'allow'        =>true,
                        'actions'      =>['client'],
                        'matchCallback'=>function ($rule, $action) {
                            $roles=array_keys(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId()));

                            return in_array('client', $roles);
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
     * Displays main page.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel =new PostSearch();
        $dataProvider=$searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' =>$searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Page for client need invite from admin
     */
    public function actionClient()
    {
        return $this->render('client');
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model=new Post;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id'=>$model->id]);
        } else {
            return $this->render('create', [
                'model'=>$model,
            ]);
        }
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
            return $this->redirect(['view', 'id'=>$model->id]);
        } else {
            return $this->render('update', [
                'model'=>$model,
            ]);
        }
    }

    /**
     * Show Post
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $post=$this->findModel($id);

        return $this->render('view', [
            'post'=>$post,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)
             ->delete();

        return $this->redirect(['index']);
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
        if (($model=Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
