<?php

namespace app\controllers;

use app\forms\CardForm;
use app\lib\Controller;
use Yii;
use app\models\Card;
use app\models\CardSearch;
use yii\db\Exception;
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
//      'newNames' => [ // todo: doesn't work - todo list inside
//        'class' => ActionRenameBehavior::class,
//        'newNamesArr' => [
//          'create' => 'new',
//          'update' => 'edit',
//        ]
//      ]
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
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Card model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionNew()
  {
    $cardForms = [new CardForm];

    if ($post = Yii::$app->request->post()) {
      $cards = Card::createMultiple(Card::class);

      if (Card::loadMultiple($cards, $post) && Card::validateMultiple($cards)) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
          foreach ($cards as $card) {
            /**
             * @var $card Card
             */
            if (!$card->save()) {
              $transaction->rollBack();
              break;
            }
          }
        } catch (Exception $exception) {
          $transaction->rollBack();
        }

        $transaction->commit();
        Yii::$app->session->setFlash('success', 'The cards are created successfully!');
        return $this->redirect('edit');
      }
    }

    return $this->render('new', [
      'cardForms' => $cardForms
    ]);
  }

  /**
   * Updates an existing Card model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionEdit($id)
  {
    /**todo:
     * ***edit one***
     * if $_POST has CardForm
     * createMultiple
     * loadMultiple
     * save every object by foreach with transaction
     */

    $card = $this->findModel($id);
    $form = new CardForm($card);



//    if ($form->load(Yii::$app->request->post()) && $form->validate()) {
//      if ($card->fill($form->attributes)) {
//        return $this->render('view', ['model' => $card]);
//      }
//    }
//
//    return $this->render('edit', [
//      'cardForm' => $form,
//    ]);
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
}
