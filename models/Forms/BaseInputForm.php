<?php
declare(strict_types=1);

namespace app\models\Forms;

use Yii;
use yii\base\Model;

class BaseInputForm extends Model
{
    public function init(): void
    {
        $this->load(Yii::$app->request->post());
        parent::init();
    }
}
