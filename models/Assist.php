<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Assist extends Model
{

    public static function getItems(string $tableName): array
    {
        return ActiveRecord::find()
            ->from($tableName)
            ->select('title')
            ->indexBy('id')
            ->column();
    }

    public static function getColsItems(string $tableName): array
    {

        return (new \yii\db\Query())
            ->from($tableName)
            ->indexBy('id')
            ->all();
    }
}
