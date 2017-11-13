<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<section>
    <div class="container">
        <h1>Countries</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>
                    <p>ID</p>
                </th>
                <th>
                    <p>Country</p>
                </th>
                <th>
                    <p>Code</p>
                </th>
                <th>
                    <p>Population</p>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($countries as $country): ?>
                <tr>
                    <td><?= $country->id ?> . <?= $country->old_id ?></td>
                    <td><?= Html::encode("{$country->name}") ?></td>
                    <td><?= Html::encode("{$country->code2l}") ?></td>
                    <td> <?= $country->population ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</section>