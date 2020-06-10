<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "courses".
 *
 * @property integer $id
 * @property integer $currency_id
 * @property string $date_courses
 * @property string $ccy
 * @property string $base_ccy
 * @property string $buy
 * @property string $sale
 */
class Courses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_id'], 'integer'],
            [['date_courses'], 'safe'],
            [['ccy', 'base_ccy'], 'required'],
            [['ccy', 'base_ccy'], 'string', 'max' => 3],
            [['buy', 'sale'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'currency_id' => 'Currency ID',
            'date_courses' => 'Date Courses',
            'ccy' => 'CCY',
            'base_ccy' => 'Base CCY',
            'buy' => 'Buy',
            'sale' => 'Sale',
        ];
    }

	public static function loadCoursesJson($url)
	{
		$arrContextOptions = [
		    "ssl"=> [
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		    ],
		];  
		$content = file_get_contents($url, false, stream_context_create($arrContextOptions));
		
		$courses = json_decode($content);
		$time = date('Y-m-d H:i:s', $courses->timestamp);
		$update = date('Y-m-d H:i:s');
		$baseEUR = $courses->rates->EUR;
		$result = true; 
		foreach ($courses->rates as $k => $v) {
			$currency = Currency::find()->where(['code' => $k])->one();
			$model = self::find()->where(['ccy' => $k])->one();
			if (!$model) {
				$model = new Courses;
				$model->ccy = $k;
				$model->base_ccy = 'EUR';
			}
			$model->currency_id = $currency->id;
			$model->date_courses = $time;
			$model->date_update = $update;
			$model->rate = round($v / $baseEUR, 6);
			if (!$model->save()) $result = $model->errors;
		}
		return $result;
	}

}
