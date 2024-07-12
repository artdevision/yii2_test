<?php
declare(strict_types=1);

namespace app\handlers;

use app\jobs\SendSubcriptionNotificationJob;
use app\models\Book;
use app\models\Subscription;
use Throwable;
use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;

#[\AllowDynamicProperties]
final class CreateBookEventHandler
{
    public static function handle(Event $event): void
    {
        if ($event->sender instanceof Book) {
            /** @var Book $book */
            $book = $event->sender;
            try {
                $subscriptions = Subscription::find()->where([
                    'in',
                    'author_id',
                    ArrayHelper::getColumn($book->authors, 'id')
                ])->all();

                foreach ($subscriptions as $subscription) {
                    Yii::$app->queue->push(new SendSubcriptionNotificationJob(
                        $subscription->id,
                        $book
                    ));
                }
            } catch (Throwable $exception) {
                Yii::trace($exception->getTrace());
            }
        }
    }
}
