<?php

namespace backend\controllers;

use Yii;
use backend\models\Delivery;
use backend\models\DeliverySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;

/**
 * DeliveryController implements the CRUD actions for Delivery model.
 */
class DeliveryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionRecords()
    {   
        $model = new Delivery();
        if ($model->load(Yii::$app->request->post()))
        {
            
         $model->save();
        return $this->redirect(['delivery/records']);
        } 
        return $this->render('records', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Delivery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['delivery/records']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing delivery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionKomsy($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['delivery/records']);
    }

    /**
     * Finds the delivery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return delivery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Delivery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
