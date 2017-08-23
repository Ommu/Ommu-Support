<?php
/**
 * Support Feedback View Histories (support-feedback-view-history)
 * @var $this ViewController
 * @var $model SupportFeedbackViewHistory
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 23 August 2017, 17:21 WIB
 * @link https://github.com/ommu/mod-support
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Support Feedback View Histories'=>array('manage'),
		$model->id,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo Utility::flashSuccess(Yii::app()->user->getFlash('success'));
?>
<?php //end.Messages ?>

<?php $this->widget('application.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'id',
			'value'=>$model->id,
		),
		array(
			'name'=>'view_id',
			'value'=>$model->view_id ? $model->view->column_name_relation : '-',
		),
		array(
			'name'=>'view_date',
			'value'=>!in_array($model->view_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->view_date, true) : '-',
		),
		array(
			'name'=>'view_ip',
			'value'=>$model->view_ip,
			//'value'=>$model->view_ip ? $model->view_ip : '-',
		),
	),
)); ?>

<div class="box">
</div>
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>