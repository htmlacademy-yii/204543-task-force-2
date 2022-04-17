<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\forms\TasksSearchForm;
use app\services\TasksSearchService;
use app\models\Category;
use Carbon\Carbon;
use app\models\Task;



class TasksController extends Controller
{


    public function actionIndex() : string
    {
       $modelForm = new TasksSearchForm();

        if (Yii::$app->request->get()) {
            $modelForm->load(Yii::$app->request->get());
        }

        $tasksSearch = new TasksSearchService();
        $dataProvider = $tasksSearch->tasksSearch($modelForm);

       /* "<pre>";
        var_dump($modelForm->period);
        "</pre>";

        "<pre>";
        var_dump(strtotime((new Carbon)->now()->subHours(12)));
        "</pre>";*/

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'modelForm' => $modelForm,
            ]);
    }

}

