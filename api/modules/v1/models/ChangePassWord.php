<?php
    namespace api\modules\v1\models;
   
    use Yii;
    use yii\base\Model;
    use common\models\User;
   
    class ChangePassWord extends Model
    {
        public $old_password;
        public $new_password;
        public $user_id;
        
        public function rules(){
            return [
                [['old_password','new_password'], 'filter', 'filter'=>'strtolower'],
                [['old_password','new_password','user_id'],'required'],
                [['user_id'],'integer'],
                [['old_password','user_id'],'findPasswords'],
                //['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }

        /**
         * Function to check old password is match or not
         * @param $attribute
         * @param $params
         * @return bool
         * @Author <engr.arslanbutt@gmail.com> Arslan Butt
         */
        public function findPasswords($attribute, $params)
        {
            $user = User::findOne($this->user_id);
            if(!$user->validatePassword($this->old_password))
            {
                //$this->addError($attribute, Yii::t('app','Old password is incorrect'));
                $this->addError(Yii::t('app','Old password is incorrect'));
                return false;
            }else
            {
                return true;
            }
        }
       
        public function attributeLabels(){
            return [
                'old_password'=>Yii::t('app','Old Password'),
                'new_password'=>Yii::t('app','New Password'),
                'user_id'=>Yii::t('app','User'),
                //'repeatnewpass'=>'Repeat New Password',
            ];
        }
    } 