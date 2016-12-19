<?php
$this->title = $subject;
?>
<p><?= nl2br($orders->answer_text) ?></p>
<br/>
<br/>
<hr>
<p><?= Yii::$app->formatter->asDatetime($orders->time, 'medium') ?> Вы писали:</p>
<p>
    <?php foreach(explode("\n", $orders->text) as $line) echo '> '.$line.'<br/>'; ?>
</p>