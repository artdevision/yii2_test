<?php
declare(strict_types=1);

namespace app\services\Subscription;

use app\models\Book;
use app\models\Forms\SubscriptionForm;
use app\models\Subscription;
use app\services\AbstractService;
use Exception;
use Throwable;
use yii\base\Model;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yiidreamteam\smspilot\Api;

final class SubscriptionService extends AbstractService
{
    protected Api $client;

    public function __construct(Api $client)
    {
        $this->client = $client;
    }

    /**
     * @param SubscriptionForm $form
     * @throws HttpException
     */
    public function createFromForm(Model $form): Subscription
    {
        $model = new Subscription();
        $model->setAttributes($form->toArray());

        if (Subscription::findOne(['phone' => $form->phone, 'author_id' => $form->author_id]) !== null) {
            throw new HttpException(409, 'You are already subscribed on this aouthor');
        }

        try {
            $model->save(false);
            $model->refresh();
        } catch (Throwable $exception) {
            throw new HttpException(500, 'Could not save Subscription');
        }

        return $model;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function findModel(int $id): Subscription
    {
        if (($model = Subscription::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested model does not exist.');
    }

    /**
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function sendSubscriptionNotification($id, Book $book): void
    {
        $subscription = $this->findModel($id);

        $this->client->send(
            $subscription->phone,
            sprintf(
                'New book %s from %s is available',
                $book->title,
                $subscription->author->fullname,
            )
        );
    }
}
