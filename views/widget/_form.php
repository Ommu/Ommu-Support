<?php
/**
 * Support Widgets (support-widget)
 * @var $this yii\web\View
 * @var $this app\modules\support\controllers\WidgetController
 * @var $model app\modules\support\models\SupportWidget
 * @var $form yii\widgets\ActiveForm
 *
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-support
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @created date 20 September 2017, 13:11 WIB
 * @contact (+62)856-299-4114
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\redactor\widgets\Redactor;
use app\modules\support\models\SupportContactCategory;

$redactorOptions = [
	'imageManagerJson' => ['/redactor/upload/image-json'],
	'imageUpload'	  => ['/redactor/upload/image'],
	'fileUpload'	   => ['/redactor/upload/file'],
	'plugins'		  => ['clips', 'fontcolor','imagemanager']
];
?>

<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'form-horizontal form-label-left',
		//'enctype' => 'multipart/form-data',
	],
]); ?>

<?php 
	$data = ArrayHelper::map(SupportContactCategory::find()->all(), 'cat_id', 'name');
	echo $form
	->field($model, 'cat_id', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}</div>'])
	->dropDownList($data, ['prompt' => 'Pilih Cat'])
	->label($model->getAttributeLabel('cat_id'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); 
?>

<?php echo $form->field($model, 'widget_source', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12">{input}{error}</div>'])
	->textarea(['rows'=>2,'rows'=>6])
	->widget(Redactor::className(), ['clientOptions' => $redactorOptions])
	->label($model->getAttributeLabel('widget_source'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'publish', ['template' => '{label}<div class="col-md-9 col-sm-9 col-xs-12 checkbox">{input}{error}</div>'])
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('publish'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>