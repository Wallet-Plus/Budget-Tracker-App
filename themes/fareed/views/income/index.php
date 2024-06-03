
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\components\CustomLinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Income');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="py-3 mb-4"><span class="text-muted fw-light"><?= Html::encode($this->title) ?>/</span> <?= Html::encode($this->title) ?></h4>

  <!-- Basic Layout & Basic with Icons -->
  <div class="row">
    <!-- Basic Layout -->
    <div class="col-xxl">
      <div class="card mb-4">
      <?php if (Yii::$app->session->hasFlash('success') || Yii::$app->session->hasFlash('error') ) { ?> 
        <div class="card-body">
          <?php if (Yii::$app->session->hasFlash('success')): ?>
              <div class="alert alert-success alert-dismissible" role="alert">
                  <?= Yii::$app->session->getFlash('success') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>

          <?php if (Yii::$app->session->hasFlash('error')): ?>
              <div class="alert alert-danger alert-dismissible" role="alert">
                  <?= Yii::$app->session->getFlash('error') ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>
        </div>
        <?php } ?>

        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0"><?= Html::encode($this->title) ?></h5>
          <small class="text-muted float-end">
          <?= Html::a(Yii::t('app', ' <button type="button" class="btn btn-primary">
              <span class="tf-icons bx bx-plus me-1"></span>Add '.Html::encode($this->title).'
            </button>'), ['create'], ['class' => 'btn']) ?>           
          </small>
        </div>


        <div class="card-body">
          <div class="table-responsive text-nowrap">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'expense_name',
                    [
                      'attribute' => 'amount',
                      'value' => function ($data) {
                          // Format the amount using the provided script
                          $formattedAmount = number_format((float)$data->amount, 2, '.', '');
                          $formattedAmountWithPrefix = 'Rs. ' . preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $formattedAmount);
                          return $formattedAmountWithPrefix;
                      },
                    ],
                    'date_of_transaction',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update} {delete}',
                        'urlCreator' => function ($action, \app\models\Expense $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id_expense' => $model->id_expense]);
                        },
                        'buttons' => [
                          'update' => function ($url, $model, $key) {
                              return Html::a('<button class="btn btn-sm btn-icon"><i class="bx bx-edit"></i></button>', $url, [
                                  'title' => Yii::t('app', 'Update'),
                                  'data-pjax' => '0',
                              ]);
                          },
                          'delete' => function ($url, $model, $key) {
                              return Html::a('<button class="btn btn-sm btn-icon delete-record"><i class="bx bx-trash"></i></button>', $url, [
                                  'title' => Yii::t('app', 'Delete'),
                                  'data' => [
                                      'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                      'method' => 'post',
                                  ],
                              ]);
                          },
                      ],
                    ],
                ],
                'tableOptions' => ['class' => 'table table-hover'],
                'pager' => [
                  'class' => \app\components\CustomLinkPager::class,
                ],
            ]); ?>

          </div>
        </div>

      </div>
    </div>

  </div>
</div>