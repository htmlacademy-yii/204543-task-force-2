<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;
use app\models\Category;
use app\models\forms\TasksSearchForm;

$this->title = 'TaskForce: Новые задания';
?>
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>

       <!-- here ListView widget must be -->
       <?php  echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_new-tasks',
          ]); ?>

<!-- блок пагинации start
        <div class="pagination-wrapper">
            <ul class="pagination-list">
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">1</a>
                </li>
                <li class="pagination-item pagination-item--active">
                    <a href="#" class="link link--page">2</a>
                </li>
                <li class="pagination-item">
                    <a href="#" class="link link--page">3</a>
                </li>
                <li class="pagination-item mark">
                    <a href="#" class="link link--page"></a>
                </li>
            </ul>
        </div>
         блок пагинации end -->
    </div>

    <!-- блок выбора задач start -->
    <div class="right-column">
       <div class="right-card black">
          <div class="search-form">
              <?php $form = ActiveForm::begin([
                  'id' => 'search-task',
                  'method' => 'get',
                  'options' => [
                      'tag' => false,
                  ]
              ]); ?>
                <h4 class="head-card">Категории</h4>
                <div class="form-group">

                    <?= $form->field($modelForm, 'categories_id')->checkboxList($modelForm->getCategoriesList(),
                        [
                            'separator' => '<br>',
                            'item' => function ($index, $label, $name, $checked, $value) use ($modelForm) {
                                settype($modelForm->categories_id, 'array');
                                $checked = in_array($value, $modelForm->categories_id) ? ' checked' : '';
                                $input = "<input type=\"checkbox\" name=\"{$name}\" id=\"{$value}\" value=\"{$value}\"{$checked}>";
                                $label = "<label class=\"control-label\" for=\"{$value}\">{$label}</label>";
                                return "{$input}{$label}";
                            }
                        ])
                   ?>


                </div>


                <h4 class="head-card">Дополнительно</h4>
                <div class="form-group">
                    <?=Html::activeCheckbox($modelForm, 'noDoer',  [ 'checked' => false, 'class' => 'form-group', 'label' => false])?>
                    <?=Html::activeLabel($modelForm, 'noDoer')?>
                </div>

                <!-- Выбрать интеревал -->
                <h4 class="head-card">Период</h4>
                <div class="form-group">
                   <?=Html::activeDropDownList($modelForm, 'period', $modelForm->getPeriod(),
                        ['value' => $get['period']??'', 'encode' => true,]) ?>
                </div>
                <?=Html::button(Html::encode('Искать'), ['class' => 'button--blue', 'type' => 'submit'])?>
           <!--  <input type="button" class="button button--blue" value="Искать"> -->
            <?php $form = ActiveForm::end(); ?>
          </div>
       </div>
    </div>
    <!-- блок выбора задач end -->
