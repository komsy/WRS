<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property int $userId
 * @property string $fullName
 * @property string $address1
 * @property string $address2
 * @property int $contactNumber
 * @property string $createdAt
 */
class Customers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'fullName', 'address1', 'address2', 'contactNumber'], 'required'],
            [['userId', 'contactNumber'], 'integer'],
            [['createdAt'], 'safe'],
            [['fullName'], 'string', 'max' => 255],
            [['address1', 'address2'], 'string', 'max' => 100],
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
            'fullName' => 'Full Name',
            'address1' => 'Address1',
            'address2' => 'Address2',
            'contactNumber' => 'Contact Number',
            'createdAt' => 'Created At',
        ];
    }
}
