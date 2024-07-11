<?php
declare(strict_types=1);

namespace app\models\Query;

use yii\db\ActiveQuery;
use yii\db\Expression;

final class AuthorQuery extends ActiveQuery
{
    public function getTopTenByYear(int $year): self
    {
        $this->select(['authors.*', new Expression('COUNT(books.id) as cnt')])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->having(['>', 'cnt', 0])
            ->orderBy(['cnt' => SORT_DESC])
            ->limit(10);
        return $this;
    }
}
