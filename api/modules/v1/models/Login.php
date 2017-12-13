<?php

namespace api\modules\v1\models;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class Login extends Model
{

    public $email;
    public $password;
    public $username;
    private $user = false;

    public function rules()
    {
        return [
            // email and password are both required
       
            [['email','password'], 'filter', 'filter'=>'strtolower'],
            [['username', 'password'], 'required'],
          
            //['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'email'    => Yii::t('backend', 'Email'),
            'username'    => Yii::t('backend', 'User name'),
            'password' => Yii::t('backend', 'Password'),
                //'rememberMe' => Yii::t('backend', 'Remember Me')
        ];
    }

    public function validatePassword()
    {
            $userobj = $this->getUser();
            if (!$userobj || !$userobj->validatePassword($this->password))
            {
                $this->addError('password', Yii::t('api', 'Incorrect username or password.'));
                return false;
            }else
            {
                return true;
            }
    }

    public function getUser_old()
    {
        if ($this->user === false)
        {
            $this->user =  Master::find()->where(['email'=>$this->email])->orWhere(['username'=>$this->email])->andWhere(['!=','status',3])->one();
        }
        return $this->user;
    }
    
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()
                ->andWhere(['or', ['username'=>$this->username], ['email'=>$this->username]])
                ->one();
        }

        return $this->user;
    }
}
