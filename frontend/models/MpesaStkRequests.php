<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "mpesaStkRequests".
 *
 * @property string $MerchantRequestID
 * @property string $phone
 * @property float $amount
 * @property string $reference
 * @property int $orderId
 * @property string $description
 * @property string $status
 * @property int $complete
 * @property string $CheckoutRequestID
 * @property int|null $userId
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Orders $order
 * @property User $user
 */
class MpesaStkRequests extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpesaStkRequests';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MerchantRequestID', 'phone', 'amount', 'reference', 'orderId', 'description', 'CheckoutRequestID'], 'required'],
            [['amount'], 'number'],
            [['orderId', 'complete', 'userId'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['MerchantRequestID', 'phone', 'reference', 'description', 'status', 'CheckoutRequestID'], 'string', 'max' => 191],
            [['MerchantRequestID'], 'unique'],
            [['CheckoutRequestID'], 'unique'],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orderId' => 'orderId']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MerchantRequestID' => 'Merchant Request ID',
            'phone' => 'Phone',
            'amount' => 'Amount',
            'reference' => 'Reference',
            'orderId' => 'Order ID',
            'description' => 'Description',
            'status' => 'Status',
            'complete' => 'Complete',
            'CheckoutRequestID' => 'Checkout Request ID',
            'userId' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
