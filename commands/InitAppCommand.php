<?php
declare(strict_types=1);

namespace app\commands;

use app\models\User;
use yii\console\Controller;

class InitAppCommand extends Controller
{
    /**
     * @throws \yii\db\Exception
     */
    public function actionIndex(): void
    {
        $usersData = [
            [
                'username' => 'admin',
                'password' => 'admin',
            ],
            [
                'username' => 'demo',
                'password' => 'demo',
            ]
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user->setAttributes($userData);
            $user->setPassword($userData['password']);
            $user->save(false);
        }
    }
}
