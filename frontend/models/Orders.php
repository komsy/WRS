<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "orders".
 *
 * @property int $orderId
 * @property int $userId
 * @property int $totalAmount
 * @property string $orderStatus
 * @property string $createdAt
 * @property int $createdBy
 *
 * @property Orderitems[] $orderitems
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'totalAmount', 'createdBy'], 'required'],
            [['userId', 'totalAmount', 'createdBy'], 'integer'],
            [['createdAt'], 'safe'],
            [['orderStatus'], 'string', 'max' => 200],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'orderId' => 'Order ID',
            'userId' => 'User ID',
            'totalAmount' => 'Total Amount',
            'orderStatus' => 'Order Status',
            'createdAt' => 'Created At',
            'createdBy' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Orderitems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderitems()
    {
        return $this->hasMany(Orderitems::className(), ['orderId' => 'orderId']);
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
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['productId' => 'productId']);
    }
}
