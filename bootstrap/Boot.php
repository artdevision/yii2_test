<?php
declare(strict_types=1);

namespace app\bootstrap;

use app\models\Forms\AuthorForm;
use app\models\Forms\BookForm;
use app\models\Forms\SubscriptionForm;
use Yii;
use yii\base\BootstrapInterface;
use yiidreamteam\smspilot\Api;

class Boot implements BootstrapInterface
{

    public function bootstrap($app): void
    {
        Yii::$container->set(AuthorForm::class);
        Yii::$container->set(BookForm::class);
        Yii::$container->set(SubscriptionForm::class);
        Yii::$container->setSingleton(Api::class, function($app) {
            $api = new Api(Yii::$app->params['smsPilotApiKey']);
            $api->sandbox = (bool) Yii::$app->params['smsPilotSandbox'];
            return $api;
        });
    }
}
