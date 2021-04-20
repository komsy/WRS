<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $productId
 * @property string $productName
 * @property int $quantity
 * @property int $unitPrice
 * @property int $discount
 * @property string $imagePath
 * @property int $createdBy
 * @property string $createdAt
 *
 * @property Cans[] $cans
 * @property Orderitems[] $orderitems
 * @property User $createdBy0
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productName', 'quantity', 'unitPrice', 'discount', 'imagePath', 'createdBy'], 'required'],
            [['quantity', 'unitPrice', 'discount', 'createdBy'], 'integer'],
            [['createdAt'], 'safe'],
            [['productName', 'imagePath'], 'string', 'max' => 255],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productId' => 'Product ID',
            'productName' => 'Product Name',
            'quantity' => 'Quantity',
            'unitPrice' => 'Unit Price',
            'discount' => 'Discount',
            'imagePath' => 'Image Path',
            'createdBy' => 'Created By',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Cans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCans()
    {
        return $this->hasMany(Cans::className(), ['productId' => 'productId']);
    }

    /**
     * Gets query for [[Orderitems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderitems()
    {
        return $this->hasMany(Orderitems::className(), ['productId' => 'productId']);
    }

    /**
     * Gets query for [[CreatedBy0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }
}
