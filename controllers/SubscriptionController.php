<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\Forms\SubscriptionForm;
use app\services\Subscription\SubscriptionService;
use yii\web\Controller;
use yii\web\HttpException;

final class SubscriptionController extends Controller
{
    protected SubscriptionService $service;

    public function __construct($id, $module, SubscriptionService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws HttpException
     */
    public function actionSubscribe($author_id, SubscriptionForm $form)
    {
        $form->author_id = (int) $author_id;
        if ($this->request->isPost && $form->validate()) {
            $this->service->createFromForm($form);
            return $this->redirect('/author/index');
        }

        return $this->render('subscribe', [
            'model' => $form,
        ]);
    }
}
