<?php

namespace app\services;

use Throwable;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

abstract class AbstractService {

    abstract public function createFromForm(Model $form): ActiveRecord;

    abstract public function findModel(int $id): ActiveRecord;

    public function updateFromForm(int $id, Model $form): ActiveRecord
    {
        try {
            $model = $this->findModel($id);
            $model->setAttributes($form->toArray());
            $model->save(false);
            $model->refresh();
        } catch (Throwable $exception) {
            throw new HttpException(500, 'Could not save Model');
        }


        return $model;
    }

    /**
     * @throws NotFoundHttpException|Throwable|StaleObjectException
     */
    public function delete(int $id): void
    {
        $this->findModel($id)->delete();
    }
}
