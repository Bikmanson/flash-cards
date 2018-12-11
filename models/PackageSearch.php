<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Package;

/**
 * PackageSearch represents the model behind the search form of `app\models\Package`.
 */
class PackageSearch extends Package
{
  /**
   * {@inheritdoc}
   */
  public function rules()
  {
    return [
      [['id', 'created_at', 'updated_at'], 'integer'],
      ['creator_id', 'string', 'max' => 50],
      [['name'], 'safe'],
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
   * Creates data provider instance with search query applied
   *
   * @param array $params
   *
   * @return ActiveDataProvider
   */
  public function search($params)
  {
    $query = Package::find();

    // add conditions that should always apply here

    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    $this->load($params);

    if (!$this->validate()) {
      // uncomment the following line if you do not want to return any records when validation fails
      // $query->where('0=1');
      return $dataProvider;
    }

    // grid filtering conditions
//    $query->andFilterWhere([
//      'id' => $this->id,
//      'created_at' => $this->created_at,
//      'updated_at' => $this->updated_at,
//    ]);

    if($this->creator_id){
      $players = Player::find()->where(['like', 'username', $this->creator_id])->all();

      if(empty($players)){
        $query->andWhere(['creator_id' => 0]); // no one
      }

      foreach ($players as $player) {
        /** @var $player Player */
        $query->andWhere(['creator_id' => $player->id]);
      }
    }

    $query->andFilterWhere(['like', 'name', $this->name]);

    return $dataProvider;
  }
}
