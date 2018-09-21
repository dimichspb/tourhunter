<?php
namespace app\models\user;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $access_token
 * @property string $auth_key
 * @property float $balance
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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
            [['username', 'access_token', 'auth_key'], 'required'],
            [['balance'], 'number'],
            [['username'], 'string', 'max' => 64],
            [['access_token', 'auth_key'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['access_token'], 'unique'],
            [['auth_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'username' => \Yii::t('app', 'Username'),
            'access_token' => \Yii::t('app', 'Access Token'),
            'auth_key' =>\Yii::t('app', 'Balance'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    /**
     * Generates access token
     */
    public function generateAccessToken()
    {
        $this->access_token = \Yii::$app->security->generateRandomString();
    }

    /**
     * Increase balance
     * @param $amount
     */
    public function increaseBalance($amount)
    {
        $this->balance = $this->balance + $amount;
    }

    /**
     * Decrease balance
     * @param $amount
     */
    public function decreaseBalance($amount)
    {
        $this->balance = $this->balance - $amount;
    }
}
