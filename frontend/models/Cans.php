<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cans".
 *
 * @property int $canId
 * @property int $productId
 * @property string $type
 * @property int $amount
 *
 * @property Product $product
 */
class Cans extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productId', 'type', 'amount'], 'required'],
            [['productId', 'amount'], 'integer'],
            [['type'], 'string', 'max' => 100],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productId' => 'productId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'canId' => 'Can ID',
            'productId' => 'Product ID',
            'type' => 'Type',
            'amount' => 'Amount',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['productId' => 'productId']);
    }
}
