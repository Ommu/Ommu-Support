<?php
/**
 * SupportFeedbackView
 * version: 0.0.1
 *
 * This is the model class for table "ommu_support_feedback_view".
 *
 * The followings are the available columns in table "ommu_support_feedback_view":
 * @property string $view_id
 * @property integer $publish
 * @property string $feedback_id
 * @property string $user_id
 * @property integer $views
 * @property string $view_date
 * @property string $view_ip
 * @property string $modified_date
 * @property string $modified_id
 * @property string $updated_date
 *
 * The followings are the available model relations:
 * @property SupportFeedbacks $feedbacks
 * @property SupportFeedbackViewHistory[] $feedbackViewHistories

 * @copyright Copyright (c) 2017 ECC UGM (ecc.ft.ugm.ac.id)
 * @link http://ecc.ft.ugm.ac.id
 * @author Arifin Avicena <avicenaarifin@gmail.com>
 * @created date 25 September 2017, 14:10 WIB
 * @contact (+62)857-2971-9487
 *
 */

namespace app\modules\support\models;

use Yii;
use yii\helpers\Url;
use app\modules\user\models\Users;
use app\libraries\grid\GridView;

class SupportFeedbackView extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_support_feedback_view';
	}

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('ecc4');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['publish', 'feedback_id', 'user_id', 'views', 'modified_id'], 'integer'],
			[['feedback_id', 'user_id'], 'required'],
			[['view_date', 'modified_date', 'updated_date', 'view_ip', 'modified_id'], 'safe'],
			[['view_ip'], 'string', 'max' => 20],
			[['feedback_id'], 'exist', 'skipOnError' => true, 'targetClass' => SupportFeedbacks::className(), 'targetAttribute' => ['feedback_id' => 'feedback_id']],
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFeedbacks()
	{
		return $this->hasOne(SupportFeedbacks::className(), ['feedback_id' => 'feedback_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFeedbackViewHistories()
	{
		return $this->hasMany(SupportFeedbackViewHistory::className(), ['view_id' => 'view_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'view_id' => Yii::t('app', 'View'),
			'publish' => Yii::t('app', 'Publish'),
			'feedback_id' => Yii::t('app', 'Feedback'),
			'user_id' => Yii::t('app', 'User'),
			'views' => Yii::t('app', 'Views'),
			'view_date' => Yii::t('app', 'View Date'),
			'view_ip' => Yii::t('app', 'View Ip'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'feedbacks_search' => Yii::t('app', 'Feedbacks'),
			'user_search' => Yii::t('app', 'User'),
			'modified_search' => Yii::t('app', 'Modified'),
		];
	}
	
	/**
	 * Set default columns to display
	 */
	public function init() 
	{
		parent::init();

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class'  => 'yii\grid\SerialColumn',
		];
		$this->templateColumns['feedbacks_search'] = [
			'attribute' => 'feedbacks_search',
			'value' => function($model, $key, $index, $column) {
				return $model->feedbacks->displayname;
			},
		];
		$this->templateColumns['user_search'] = [
			'attribute' => 'user_search',
			'value' => function($model, $key, $index, $column) {
				return isset($model->user) ? $model->user->displayname : '-';
			},
		];
		$this->templateColumns['views'] = 'views';
		$this->templateColumns['view_date'] = [
			'attribute' => 'view_date',
			'filter'	=> \yii\jui\DatePicker::widget([
				'dateFormat' => 'yyyy-MM-dd',
				'attribute' => 'view_date',
				'model'	 => $this,
			]),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->view_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00']) ? Yii::$app->formatter->format($model->view_date, 'date'/*datetime*/) : '-';
			},
			'format'	=> 'html',
		];
		$this->templateColumns['view_ip'] = 'view_ip';
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'filter'	=> \yii\jui\DatePicker::widget([
				'dateFormat' => 'yyyy-MM-dd',
				'attribute' => 'modified_date',
				'model'	 => $this,
			]),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'date'/*datetime*/) : '-';
			},
			'format'	=> 'html',
		];
		$this->templateColumns['modified_search'] = [
			'attribute' => 'modified_search',
			'value' => function($model, $key, $index, $column) {
				return isset($model->modified) ? $model->modified->displayname : '-';
			},
		];
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'filter'	=> \yii\jui\DatePicker::widget([
				'dateFormat' => 'yyyy-MM-dd',
				'attribute' => 'updated_date',
				'model'	 => $this,
			]),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->updated_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00']) ? Yii::$app->formatter->format($model->updated_date, 'date'/*datetime*/) : '-';
			},
			'format'	=> 'html',
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'filter' => GridView::getFilterYesNo(),
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['publish', 'id'=>$model->primaryKey]);
					return GridView::getPublish($url, $model->publish);
				},
				'contentOptions' => ['class'=>'center'],
				'format' => 'raw',
			];
		}
	}

	public function insertFeedbackView($feedback_id)
	{
		$user_id = Yii::$app->user->id;
		$feedback_view = SupportFeedbackView::find()->where(['feedback_id' => $feedback_id, 'user_id' => $user_id])->one();

		if($feedback_view == null) {
			$feedback_view = new SupportFeedbackView;
			$feedback_view->feedback_id = $feedback_id;
			$feedback_view->user_id = $user_id;
			$feedback_view->view_ip = Yii::$app->request->userIP;
		} else {
			$feedback_view->views = $feedback_view->views+1;
		}
		$feedback_view->save();
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if(!$this->isNewRecord)
				$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : '0';
			// Create action
		}
		return true;
	}

}
