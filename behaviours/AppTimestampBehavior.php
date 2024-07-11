<?php

namespace app\behaviours;

use DateTime;
use yii\behaviors\TimestampBehavior;

class AppTimestampBehavior extends TimestampBehavior
{
    protected function getValue($event)
    {
        if ($this->value === null) {
            return (new DateTime('now'))->format('Y-m-d H:i:s');
        }

        return parent::getValue($event);
    }
}
