<?php
declare(strict_types=1);

namespace app\behaviours;

use app\handlers\CreateBookEventHandler;
use app\models\Book;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\base\InvalidConfigException;

class CreatedBookBehavior extends Behavior
{
    protected CreateBookEventHandler $bookEventHandler;

    /**
     * @throws InvalidConfigException
     */
    public function __construct($config = [])
    {
        $this->bookEventHandler = Yii::createObject(CreateBookEventHandler::class);
        parent::__construct($config);
    }

    public function events(): array
    {
        return [
            Book::EVENT_BOOK_CREATED => 'handle',
        ];
    }

    public function handle(Event $event): void
    {
        $this->bookEventHandler->handle($event);
    }
}
