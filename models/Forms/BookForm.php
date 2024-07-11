<?php
declare(strict_types=1);

namespace app\models\Forms;

use app\models\Author;
use app\models\Traits\ValidateIsbnTrait;
use yii\web\UploadedFile;

final class BookForm extends BaseInputForm
{
    use ValidateIsbnTrait;

    public ?string $title = null;
    public ?string $isbn = null;
    public ?int $year = null;
    /**
     * @var null|array
     */
    public $author_ids = null;
    public ?string $description = null;
    /**
     * @var UploadedFile
     */
    public $titleImage = null;

    public function init(): void
    {
        parent::init();
        $this->titleImage = UploadedFile::getInstance($this, 'titleImage');
    }

    public function rules(): array
    {
        return [
            [['title', 'isbn', 'year', 'author_ids'], 'required', 'on' => 'create'],
            [['title'], 'string', 'max' => 256],
            ['isbn', 'validateIsbn'],
            ['description', 'safe'],
            ['year', 'integer', 'min' => 999, 'max' => 9999],
            ['author_ids', 'default', 'value' => null],
            ['author_ids', 'exist', 'allowArray' => true, 'targetClass' => Author::class, 'targetAttribute' => 'id'],
            ['titleImage', 'file', 'extensions' => ['png', 'jpg', 'gif', 'jpeg'], 'maxSize' => 20*1024*1024]
        ];
    }
}
