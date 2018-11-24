<?php

namespace app\controllers;

use app\forms\CardForm;
use app\lib\Controller;
use app\models\Package;
use Yii;
use app\models\Card;
use app\models\CardSearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Card models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new CardSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Card model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    $model = $this->findModel($id);
    if ($model->creator_id === Yii::$app->user->identity->getId()) {
      return $this->render('view', [
        'model' => $model,
      ]);
    }

    return $this->redirect('index');
  }

  /**
   * Creates a new Card model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionNew()
  {
    $cards = [new Card];

    if ($post = Yii::$app->request->post()) {
      $preparation = Card::prepareMultiple($post);
      if ($cards = $preparation['cards'] && $this->saveMultiple($preparation)) {
        return $this->redirect(['edit']);
      }
    }

    return $this->render('new', [
      'cards' => $cards
    ]);
  }

  /**
   * Updates an existing Card model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionEdit($id = null)
  {
    $playerId = Yii::$app->user->identity->getId();
    $cards = Card::find()->where(['creator_id' => $playerId])->all();

    if ($post = Yii::$app->request->post()) {
      $preparation = Card::prepareMultiple($post, $cards);

      if ($this->saveMultiple($preparation)) {
        $cards = Card::find()->where(['creator_id' => $playerId])->all(); // reassigning for farther rendering new list of cards
      }
    }

    if ($id) {
      if (Card::findOne(['id' => $id])->creator_id === $playerId) {
        return $this->render('edit', [
          'cards' => [Card::findOne(['id' => $id])]
        ]);
      }
      return $this->redirect('index');
    } elseif (empty($cards)) {
      return $this->redirect('new');
    }

    return $this->render('edit', [
      'cards' => $cards
    ]);
  }

  /**
   * Deletes an existing Card model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  public function actionMassDelete()
  {
    if (!Yii::$app->request->isAjax) {
      throw new BadRequestHttpException('Only ajax!');
    }

    $ids = Yii::$app->request->post('ids');

    if ($ids && is_array($ids)) {
      foreach ($ids as $id) {
        Card::findOne(['id' => $id])->delete();
      }
    }

    return $this->redirect('index');
  }

  /**
   * Finds the Card model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Card the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Card::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }

  /**
   * @param array $preparation
   * @return bool
   */
  private function saveMultiple(array $preparation): bool
  {
    $transaction = Yii::$app->db->beginTransaction();

    if ($preparation['oldIds']) {
      $newIds = ArrayHelper::map($preparation['cards'], 'id', 'id');
      $deletedIds = array_diff($preparation['oldIds'], $newIds);
      Card::deleteAll(['id' => $deletedIds]);
    }

    foreach ($preparation['cards'] as $card) {
      /** @var $card Card */
      if (!$card->save()) {
        $transaction->rollBack();
        Yii::$app->session->setFlash('danger', 'Cards were not saved! Something went wrong');
        return false;
      }
    }
    $transaction->commit();
    Yii::$app->session->setFlash('success', 'Cards are saved!');

    return true;
  }

}
