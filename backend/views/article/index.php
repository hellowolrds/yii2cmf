<?php

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content-header') ?>
<?= $this->title . ' ' . Html::a('发布文章', ['create'], ['class' => 'btn btn-primary btn-flat btn-xs']) ?>
<?php $this->endBlock() ?>
<div class="article-index">
    <div class="box box-primary">
        <div class="box-body"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <?= GridView::widget([
                'id' => 'article-grid',
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => \yii\grid\CheckboxColumn::className()],
                    'id',
                    [
                        'attribute' => 'title',
                        'value' => function($model) {
                            return Html::a($model->title, Yii::$app->config->get('SITE_URL') . '/' . $model->id . '.html', ['target' => '_blank', 'no-iframe' => '1']);
                        },
                        'format' => 'raw',
                        'enableSorting' => false
                    ],
                    [
                        'attribute' => 'module',
                        'value' => function($model) {
                            return array_get(\common\models\ArticleModule::getTypeEnum(), $model->module);
                        },
                        'enableSorting' => false
                    ],
                    'category',
                    [
                        'label' => '标签',
                        'value' => function ($model) {
                            $html = '';
                            foreach ($model->tags as $tag) {
                                $html .= ' <span class="label label-' . $tag->level . '">' . $tag->name . '</span>';
                            }
                            return $html;
                        },
                        'format' => 'raw'
                    ],
                    'trueView',
                    [
                        'class' => 'backend\widgets\grid\SwitcherColumn',
                        'attribute' => 'is_top'
                    ],
                    [
                        'class' => 'backend\widgets\grid\SwitcherColumn',
                        'attribute' => 'status'
                    ],
                    'user_id:admin',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}'
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
