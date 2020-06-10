<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property string $code
 * @property integer $num_code
 * @property string $name
 * @property string $name_ru
 * @property string $name_rs
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'num_code'], 'required'],
            [['num_code'], 'integer'],
            [['code'], 'string', 'max' => 3],
            [['name', 'name_ru', 'name_rs'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'num_code' => 'Num Code',
            'name' => 'Name',
            'name_ru' => 'Name Ru',
            'name_rs' => 'Name Rs',
        ];
    }
	
	public function getCourse()
	{
        return $this->hasOne(Courses::className(), ['ccy' => 'code']);
	}

	public function getSymbol()
	{
        switch ($this->code) {
        	case 'USD':
        		$symbol = '$';
        		break;
        	case 'EUR':
        		$symbol = '€';
        		break;
        	case 'GBP':
        		$symbol = '£';
        		break;
        	case 'CHF':
        		$symbol = '₣';
        		break;
        	case 'RUB':
        		$symbol = '₽';
        		break;
        	case 'AED':
        		$symbol = 'Dh';
        		break;
        	case 'AZH':
        		$symbol = '₼';
        		break;
        	case 'CUP':
        		$symbol = '₱';
        		break;
        	case 'CZK':
        		$symbol = 'Kč';
        		break;
        	case 'HRK':
        		$symbol = 'Kn';
        		break;
        	case 'LKR':
        		$symbol = 'Rs';
        		break;
        	default:
        		$symbol = '¤';
        }
        return $symbol;
	}

}
