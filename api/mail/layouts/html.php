<?php
/**
 * @var $this yii\web\View
 */

use api\assets\APIAsset;
use common\models\TimelineEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\helpers\Html;
$bundle = APIAsset::register($this);
?>
<?php $this->beginContent('@app/mail/layouts/base.php'); ?>
    <div class="box">
        <div class="box-body" id="main-content">
            <?php echo $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>
