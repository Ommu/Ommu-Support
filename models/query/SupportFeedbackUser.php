<?php
/**
 * SupportFeedbackUser
 *
 * This is the ActiveQuery class for [[\ommu\support\models\SupportFeedbackUser]].
 * @see \ommu\support\models\SupportFeedbackUser
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2019 OMMU (www.ommu.co)
 * @created date 25 January 2019, 15:12 WIB
 * @link https://github.com/ommu/mod-support
 *
 */

namespace ommu\support\models\query;

class SupportFeedbackUser extends \yii\db\ActiveQuery
{
	/*
	public function active()
	{
		return $this->andWhere('[[status]]=1');
	}
	*/

	/**
	 * {@inheritdoc}
	 */
	public function published() 
	{
		return $this->andWhere(['publish' => 1]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function unpublish() 
	{
		return $this->andWhere(['publish' => 0]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deleted() 
	{
		return $this->andWhere(['publish' => 2]);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\support\models\SupportFeedbackUser[]|array
	 */
	public function all($db = null)
	{
		return parent::all($db);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\support\models\SupportFeedbackUser|array|null
	 */
	public function one($db = null)
	{
		return parent::one($db);
	}
}
