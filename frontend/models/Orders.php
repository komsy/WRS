<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "orders".
 *
 * @property int $orderId
 * @property int $userId
 * @property string $orderStatus
 * @property string $createdAt
 *
 * @property Deliveryrecord[] $deliveryrecords
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
            [['userId', 'orderStatus'], 'required'],
            [['userId'], 'integer'],
            [['createdAt'], 'safe'],
            [['orderStatus'], 'string', 'max' => 50],
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
            'orderStatus' => 'Order Status',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Deliveryrecords]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeliveryrecords()
    {
        return $this->hasMany(Deliveryrecord::className(), ['orderId' => 'orderId']);
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
}
