<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "orderitems".
 *
 * @property int $orderItemsId
 * @property int $orderId
 * @property int $productId
 * @property int $withCan
 * @property int $quantity
 * @property int $total
 *
 * @property Product $product
 * @property Orders $order
 */
class Orderitems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orderitems';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderId', 'productId', 'withCan', 'quantity', 'total'], 'required'],
            [['orderId', 'productId', 'withCan', 'quantity', 'total'], 'integer'],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productId' => 'productId']],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orderId' => 'orderId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderItemsId' => 'Order Items ID',
            'orderId' => 'Order ID',
            'productId' => 'Product ID',
            'withCan' => 'With Can',
            'quantity' => 'Quantity',
            'total' => 'Total',
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

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['orderId' => 'orderId']);
    }
     public function getCans()
    {
        return $this->hasMany(Cans::className(), ['productId' => 'productId']);
    }
}
