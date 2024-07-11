<?php
declare(strict_types=1);

namespace app\jobs;

use app\models\Book;
use app\services\Subscription\SubscriptionService;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\queue\JobInterface;
use yii\web\NotFoundHttpException;

class SendSubcriptionNotificationJob extends BaseObject implements JobInterface
{
    private ?int $subscriptionId;
    private ?Book $book;

    protected SubscriptionService $service;

    /**
     * @throws InvalidConfigException
     */
    public function __construct(int $subscriptionId, Book $book, $config = [])
    {
        $this->service = Yii::createObject(SubscriptionService::class);
        $this->subscriptionId = $subscriptionId;
        $this->book = $book;
        parent::__construct($config);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function execute($queue): void
    {
        $this->service->sendSubscriptionNotification($this->subscriptionId, $this->book);
    }
}
