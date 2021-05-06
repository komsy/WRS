<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property int $deliveryId
 * @property string $location
 * @property float $fee
 * @property int $createdBy
 * @property string $createdAt
 *
 * @property User $createdBy0
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['location', 'fee', 'createdBy'], 'required'],
            [['fee'], 'number'],
            [['createdBy'], 'integer'],
            [['createdAt'], 'safe'],
            [['location'], 'string', 'max' => 100],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['createdBy' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'deliveryId' => 'Delivery ID',
            'location' => 'Location',
            'fee' => 'Fee',
            'createdBy' => 'Created By',
            'createdAt' => 'Created At',
        ];
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
