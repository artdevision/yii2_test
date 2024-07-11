<?php
declare(strict_types=1);

namespace app\services\Author;

use app\models\Author;
use app\services\AbstractService;
use Throwable;
use yii\base\Model;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

final class AuthorService extends AbstractService
{
    /**
     * @throws HttpException
     */
    public function createFromForm(Model $form): Author
    {
        $model = new Author();
        $model->setAttributes($form->toArray());

        try {
            $model->save(false);
            $model->refresh();
        } catch (Throwable $exception) {
            throw new HttpException(500, 'Could not save Author');
        }

        return $model;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findModel(int $id): Author
    {
        if (($model = Author::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested model does not exist.');
    }
}
