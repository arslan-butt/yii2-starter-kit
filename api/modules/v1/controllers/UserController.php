<?php

namespace api\modules\v1\controllers;

use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use api\modules\v1\models\search\UserSearch;
use Yii;
use api\modules\v1\models\Login;
use api\modules\v1\models\SignupForm;
use common\models\UserProfile;
use api\modules\v1\models\ChangePassWord;
use api\modules\v1\models\PasswordResetRequestForm;
use api\modules\v1\models\EditProfile;
use backend\models\LoginForm;
use yii\web\BadRequestHttpException;


class UserController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'only' => ['change-password', 'profile', 'logout', 'edit-profile', 'index', 'view'],
            'authMethods' => [
                [
                    'class' => HttpBasicAuth::className(),
                    'auth' => function ($username, $password) {
                        $user = User::findByLogin($username);
                        if (!$user) {
                            return null;
                        }
                        return $user->validatePassword($password) ? $user : null;
                    },
                ],
                HttpBearerAuth::className(),
                QueryParamAuth::className()
            ]
        ];
        return $behaviors;
    }

    /**
     * @api {POST} /user/login
     * 01. Login
     * @apiName login
     * @apiGroup Users
     * @apiDescription
     * Login a specific User model and generate new authentication token (set via `X-Access-Token` response header).
     *
     * @apiParam {String} email    User email address
     * @apiParam {String} password User password
     *
     * @apiSuccessExample {json} 200 Success response (example):
     * {
     * "id": 7,
     * "username": "saleperson1",
     * "access_token": "YQVAUGT8Fd6MC5_xzs-xE1AZ50aeYR7y5qnsdD11",
     * "oauth_client_user_id": null,
     * "email": "saleperson@demo.com",
     * "status": 2,
     * "logged_at": 1494235518
     * }
     *
     *
     *
     * @apiErrorExample {json} 400 Bad Request (example):
     * {
     *   "message": "Invalid login credentials.",
     *   "errors": {
     *     "password": "Invalid password."
     *   }
     * }
     */

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->apilogin()) {
            $user = $model->getUser();
            return $user->toArray([], ['settings']);
        }
        //throw new BadRequestHttpException(Yii::t('app', 'Invalid login credentials.'));
        Yii::$app->response->statusCode = 400;
        $message = Yii::t('app', 'Invalid login credentials.');
        $errors = $model->getFirstErrors();
        return [
            'message' => $message,
            'errors' => $errors,
        ];
    }

    public function actionCreate()
    {
    }

    public function actionSocialLogin()
    {
    }

    /**
     * @api {PUT} /user/reset
     * 01. Password Reset
     * @apiName reset
     * @apiGroup Users
     * @apiDescription
     * Reset user password.
     *
     * @apiParam {String} old_password  User old password
     * @apiParam {String} new_password  User new password
     * @apiParam {integer} user_id  Login user id
     *
     *
     *  * @apiSuccessExample {json} 200 Success response (example):
     * {
     *  "message": "Password updated successfully.",
     * }
     *
     *
     * @apiErrorExample {json} 400 Bad Request (example):
     * {
     *   "message": "Invalid old password.",
     *   "errors": {
     *     "Old password is incorrect"
     *   }
     * }
     *
     * @Author <engr.arslanbutt@gmail.com> Arslan Butt
     */
    public function actionReset()
    {
        $model = new ChangePassWord();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($model->validate()) {
            $user = User::findOne($model->user_id);
            $user->setPassword($model->new_password);
            if ($user->save(false)) {
                $message = Yii::t('app', 'Password updated successfully.');
                return [
                    'message' => $message,
                ];
            }
        } else {
            $message = Yii::t('app', 'Invalid old password.');
            $errors = $model->getFirstErrors();
            return [
                'message' => $message,
                'errors' => $errors,
            ];
        }
    }

    public function actionForgotPassword()
    {
        $model = new PasswordResetRequestForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($model->validate()) {
            $model->sendEmail();
            return $model->user;
        } else {
            return $model;
        }
    }

    public function actionPasswordActivate()
    {

    }

    public function actionPasswordRecover()
    {

    }

    public function actionProfile()
    {
        return User::findOne(Yii::$app->user->id);
    }

    public function actionEditProfile()
    {
        $model = new EditProfile();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($model->validate()) {
            $file_name = Yii::$app->getSecurity()->generateRandomString();
            $file_path = Yii::getAlias('@storage/web/source/');
            $image_val = \yii\web\UploadedFile::getInstance($model, "pic");
            if ($image_val) {
                $fullpath = $file_path . $file_name . '.' . $image_val->extension;
                $image_val->saveAs($fullpath);
                $model->pic = $file_name . '.' . $image_val->extension;
            }
            $profile = UserProfile::find()->where(['user_id' => Yii::$app->user->id])->one();
            $profile->firstname = $model->name;
            if ($model->pic):
                $profile->avatar_path = $model->pic;
            endif;
            $profile->save(false);
            return $profile;
        } else {
            return $model;
        }
    }

    public function actionLogout()
    {

    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        return $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $model;
    }

    public function findModel($id)
    {
        $model = User::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }
        return $model;
    }

}
