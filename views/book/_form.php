<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\forms\BookForm $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $authors */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isbn')->widget(\yii\widgets\MaskedInput::class, [
            'mask' => '999-9-999-99999-9'
    ]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'titleImage')->fileInput() ?>

    <?= $form->field($model, 'author_ids')->dropDownList($authors, ['multiple'=>'multiple']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
