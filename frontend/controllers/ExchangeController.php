<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;

class ExchangeController extends Controller {

    public function actionGetExchangeRates()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($keyAccess == \Yii::$app->params['keyAccess']) { //Filter out unauthorized requests
			$result = \common\models\Courses::loadCoursesJson(\Yii::$app->params['urlExchangeRates']);
			return ['result' => $result];
        } else {
        	return ['result' => false, 'error' => 'Wrong key access!'];
        }
    }
}
