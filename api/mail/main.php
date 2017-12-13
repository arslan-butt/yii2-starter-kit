<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
<!--    <style type="text/css">
        .heading {...}
        .list {...}
        .footer {...}
    </style>-->
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?php echo 'Hello,'; ?>
    <div class="body">
      
        <p><?php echo $contents; ?></p>
        <br></br>
    </div>
    <div class="footer">With kind regards, <?= Yii::$app->name ?> team</div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>