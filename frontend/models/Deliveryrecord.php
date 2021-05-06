<?php

namespace frontend\models;

use Yii;
use common\models\User; 

/**
 * This is the model class for table "deliveryrecord".
 *
 * @property int $id
 * @property int $userId
 * @property int $orderId
 * @property int $deliveryId
 * @property string $fullName
 * @property string $address
 * @property string $postalCode
 * @property string $city
 * @property string $deliveryStatus
 * @property string $createdAt
 *
 * @property Delivery $delivery
 * @property User $user
 * @property Orders $order
 */
class Deliveryrecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deliveryrecord';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'orderId', 'deliveryId', 'fullName', 'address', 'postalCode', 'city'], 'required'],
            [['userId', 'orderId', 'deliveryId'], 'integer'],
            [['createdAt'], 'safe'],
            [['fullName', 'address', 'city'], 'string', 'max' => 100],
            [['postalCode', 'deliveryStatus'], 'string', 'max' => 50],
            [['deliveryId'], 'exist', 'skipOnError' => true, 'targetClass' => Delivery::className(), 'targetAttribute' => ['deliveryId' => 'deliveryId']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orderId' => 'orderId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'orderId' => 'Order ID',
            'deliveryId' => 'Delivery ID',
            'fullName' => 'Full Name',
            'address' => 'Address',
            'postalCode' => 'Postal Code',
            'city' => 'City',
            'deliveryStatus' => 'Delivery Status',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Delivery]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(Delivery::className(), ['deliveryId' => 'deliveryId']);
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

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['orderId' => 'orderId']);
    }
}
