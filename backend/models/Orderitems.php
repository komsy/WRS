<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orderitems".
 *
 * @property int $orderItemsId
 * @property int $orderId
 * @property int $userId
 * @property int $productId
 * @property int $withCan
 * @property int $quantity
 * @property int $total
 *
 * @property Orders $order
 * @property Product $product
 * @property User $user
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
            [['orderId', 'userId', 'productId', 'withCan', 'quantity', 'total'], 'required'],
            [['orderId', 'userId', 'productId', 'withCan', 'quantity', 'total'], 'integer'],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orderId' => 'orderId']],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productId' => 'productId']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
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
            'userId' => 'User ID',
            'productId' => 'Product ID',
            'withCan' => 'With Can',
            'quantity' => 'Quantity',
            'total' => 'Total',
        ];
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
