<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $isBan
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Cashier[] $cashiers
 * @property Customers[] $customers
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['isBan', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'isBan' => 'Is Ban',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[Cashiers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCashiers()
    {
        return $this->hasMany(Cashier::className(), ['userId' => 'id']);
    }

    /**
     * Gets query for [[Customers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customers::className(), ['userId' => 'id']);
    }
}
