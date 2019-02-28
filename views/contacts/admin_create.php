<?php
/**
 * Support Contacts (support-contacts)
 * @var $this app\components\View
 * @var $this ommu\support\controllers\ContactsController
 * @var $model ommu\support\models\SupportContacts
 * @var $form app\components\ActiveForm
 *
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @link https://github.com/ommu/mod-support
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @created date 20 September 2017, 12:59 WIB
 * @contact (+62)856-299-4114
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\MenuContent;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Support Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Back To Manage'), 'url' => Url::to(['index']), 'icon' => 'table'],
];
?>

<div class="col-md-12 col-sm-12 col-12">
	<div class="x_panel">
		<div class="x_title">
			<h2><?php echo Html::encode($this->title); ?></h2>
			<?php if($this->params['menu']['content']):
			echo MenuContent::widget(['items' => $this->params['menu']['content']]);
			endif;?>
			<ul class="nav navbar-right panel_toolbox">
				<li><a href="#" title="<?php echo Yii::t('app', 'Toggle');?>" class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				<li><a href="#" title="<?php echo Yii::t('app', 'Close');?>" class="close-link"><i class="fa fa-close"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			<?php echo $this->render('_form', [
				'model' => $model,
			]); ?>
		</div>
	</div>
</div>