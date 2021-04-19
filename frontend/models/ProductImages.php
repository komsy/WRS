<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "productImages".
 *
 * @property int $imageId
 * @property string $imagePath
 * @property int $productId
 * @property string $createdAt
 *
 * @property Product $product
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productImages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['imagePath', 'productId'], 'required'],
            [['productId'], 'integer'],
            [['createdAt'], 'safe'],
            [['imagePath'], 'string', 'max' => 255],
            [['productId'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['productId' => 'productId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'imageId' => 'Image ID',
            'imagePath' => 'Image Path',
            'productId' => 'Product ID',
            'createdAt' => 'Created At',
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
}
