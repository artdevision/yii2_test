<?php

namespace app\models;

use DateTime;
use yii\web\IdentityInterface;
use Yii;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $access_token
 * @property string $auth_key
 * @property string $email
 * @property array $subscriptions
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
final class User extends BaseModel implements IdentityInterface
{
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['email', 'email'],
            [['auth_key', 'access_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function setPassword(string $value): void
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($value);
    }
}
