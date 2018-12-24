<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'ชื่อผู้ใช้งาน : ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้งานระบบ', 'url' => ['index']];

?>
<div class="user-view">
    <div class="alert alert-success alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> 
        <strong> 
            <h4>
                <?= Html::a('<i class="glyphicon glyphicon-edit"></i> แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
                <?=Html::a('<i class="glyphicon glyphicon-trash"></i> ลบ', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-flat',
                    'data' => [
                        'confirm' => 'คุณแน่ใจหรือว่าต้องการลบรายการนี้หรือไม่ ?',
                        'method' => 'post',
                        ],
                    ])
                ?>
            </h4> ! 
        </strong> <?= Html::encode($this->title) ?>
    </div>
    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                'id',
                'full_name',
                'cid',
                'hospcode',
                'username',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'email:email',
                'user_role.role_desc',
                'user_status.status_desc',
                'created_at',
                'updated_at',
                ],
            ]) ?>
        </div>
    </div>
</div>
<?= \bluezed\scrollTop\ScrollTop::widget() ?>