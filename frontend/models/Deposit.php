<?php

namespace frontend\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "deposit".
 *
 * @property int $transId
 * @property string|null $MerchantRequestId
 * @property int $orderId
 * @property float $transAmount
 * @property int|null $phoneCode
 * @property int $mpesaNumber
 * @property string $details
 * @property string|null $reciept
 * @property string $transDate
 * @property int $createdBy
 * @property int|null $status
 *
 * @property Orders $order
 * @property User $createdBy0
 */
class Deposit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deposit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderId', 'transAmount', 'mpesaNumber', 'details', 'createdBy'], 'required'],
            [['orderId', 'phoneCode', 'mpesaNumber', 'createdBy', 'status'], 'integer'],
            [['transAmount'], 'number'],
            [['details'], 'string'],
            [['transDate'], 'safe'],
            [['MerchantRequestId', 'reciept'], 'string', 'max' => 100],
            [['orderId'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['orderId' => 'orderId']],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'transId' => 'Trans ID',
            'MerchantRequestId' => 'Merchant Request ID',
            'orderId' => 'Order ID',
            'transAmount' => 'Trans Amount',
            'phoneCode' => 'Phone Code',
            'mpesaNumber' => 'Mpesa Number',
            'details' => 'Details',
            'reciept' => 'Reciept',
            'transDate' => 'Trans Date',
            'createdBy' => 'Created By',
            'status' => 'Status',
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
     * Gets query for [[CreatedBy0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(User::className(), ['id' => 'createdBy']);
    }
}
