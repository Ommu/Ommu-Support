<?php
/**
 * SupportContacts
 *
 * SupportContacts represents the model behind the search form about `ommu\support\models\SupportContacts`.
 *
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @link https://github.com/ommu/mod-support
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @created date 20 September 2017, 12:59 WIB
 * @contact (+62)856-299-4114
 *
 */

namespace ommu\support\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ommu\support\models\SupportContacts as SupportContactsModel;
//use ommu\support\models\SupportContactCategory;

class SupportContacts extends SupportContactsModel
{
	// Variable Search	
	public $contactCategory_search;
	public $creation_search;
	public $modified_search;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'publish', 'cat_id', 'creation_id', 'modified_id'], 'integer'],
            [['contact_name', 'creation_date', 'modified_date', 'updated_date',
				'contactCategory_search', 'creation_search', 'modified_search'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Tambahkan fungsi beforeValidate ini pada model search untuk menumpuk validasi pd model induk. 
	 * dan "jangan" tambahkan parent::beforeValidate, cukup "return true" saja.
	 * maka validasi yg akan dipakai hanya pd model ini, semua script yg ditaruh di beforeValidate pada model induk
	 * tidak akan dijalankan.
	 */
	public function beforeValidate() {
		return true;
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = SupportContactsModel::find()->alias('t');
		$query->joinWith(['contactCategory contactCategory', 'creation creation', 'modified modified']);

		// add conditions that should always apply here
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$attributes = array_keys($this->getTableSchema()->columns);
		$attributes['contactCategory_search'] = [
			'asc' => ['contactCategory.name' => SORT_ASC],
			'desc' => ['contactCategory.name' => SORT_DESC],
		];
		$attributes['creation_search'] = [
			'asc' => ['creation.displayname' => SORT_ASC],
			'desc' => ['creation.displayname' => SORT_DESC],
		];
		$attributes['modified_search'] = [
			'asc' => ['modified.displayname' => SORT_ASC],
			'desc' => ['modified.displayname' => SORT_DESC],
		];
		$dataProvider->setSort([
			'attributes' => $attributes,
			'defaultOrder' => ['id' => SORT_DESC],
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			't.id' => $this->id,
			't.cat_id' => isset($params['contactCategory']) ? $params['contactCategory'] : $this->cat_id,
            'cast(t.creation_date as date)' => $this->creation_date,
            't.creation_id' => isset($params['creation']) ? $params['creation'] : $this->creation_id,
            'cast(t.modified_date as date)' => $this->modified_date,
            't.modified_id' => isset($params['modified']) ? $params['modified'] : $this->modified_id,
            'cast(t.updated_date as date)' => $this->updated_date,
        ]);

		if(isset($params['trash']))
			$query->andFilterWhere(['NOT IN', 't.publish', [0,1]]);
		else {
			if(!isset($params['publish']) || (isset($params['publish']) && $params['publish'] == ''))
				$query->andFilterWhere(['IN', 't.publish', [0,1]]);
			else
				$query->andFilterWhere(['t.publish' => $this->publish]);
		}

        $query->andFilterWhere(['like', 't.contact_name', $this->contact_name])
            ->andFilterWhere(['like', 'contactCategory.name', $this->contactCategory_search])
            ->andFilterWhere(['like', 'creation.displayname', $this->creation_search])
            ->andFilterWhere(['like', 'modified.displayname', $this->modified_search]);

		return $dataProvider;
	}
}
