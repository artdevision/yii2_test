<?php
declare(strict_types=1);

namespace app\services\Book;

use app\models\Author;
use app\models\Forms\BookForm;
use app\models\Book;
use app\services\AbstractService;
use Ramsey\Uuid\Uuid;
use Throwable;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

final class BookService extends AbstractService
{

    /**
     * @param BookForm $form
     * @throws HttpException
     */
    public function createFromForm(Model $form): Book
    {
        $model = new Book();
        $model->setAttributes($form->toArray());

        $this->uploadTitleImage($model, $form);

        try {
            $model->save(false);
            $model->refresh();
            if (!empty($form->author_ids)) {
                $this->saveAuthors($model, $form->author_ids);
                $model->trigger(Book::EVENT_BOOK_CREATED);
            }
        } catch (Throwable $exception) {
            throw new HttpException(500, 'Could not save Book');
        }

        return $model;
    }

    /**
     * @throws HttpException
     */
    public function updateFromForm(int $id, Model $form): ActiveRecord
    {
        try {
            $model = $this->findModel($id);

            $this->uploadTitleImage($model, $form);
            $model->setAttributes($form->toArray());
            $model->save(false);
            if (!empty($form->author_ids)) {
                $this->saveAuthors($model, $form->author_ids);
            }
            $model->refresh();
        } catch (Throwable $exception) {
            throw new HttpException(500, 'Could not save Book');
        }

        return $model;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findModel(int $id): Book
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested model does not exist.');
    }

    public function getAuthorsList(): array
    {
        return ArrayHelper::map(
            Author::find()->orderBy(['lastname' => SORT_ASC])->all(),
            'id',
            'fullname'
        );
    }

    protected function saveAuthors(Book $model, array $authorIds = []): void
    {
        $model->unlinkAll('authors', true);
        foreach ($authorIds as $authorId) {
            $model->link('authors', Author::findOne($authorId));
        }
    }

    protected function uploadTitleImage(Book $model, BookForm $form): void
    {
        if ($form->titleImage !== null) {
            $filePath = '@app/web/uploads/' . Uuid::uuid4() . '.' . $form->titleImage->extension;
            if ($form->titleImage->saveAs($filePath)) {
                $model->setAttribute('title_img', $filePath);
            }
        }
    }
}
