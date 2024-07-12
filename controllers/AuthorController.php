<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\Author;
use app\models\Forms\AuthorForm;
use app\services\Author\AuthorService;
use DateTime;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
final class AuthorController extends Controller
{
    protected AuthorService $service;

    public function __construct($id, $module, AuthorService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'top'],
                            'roles' => ['?']
                        ],
                        [
                            'allow' => true,
                            'actions' => ['create', 'update', 'delete'],
                            'roles' => ['@']
                        ],
                    ]
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Author models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Author model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): string
    {
        $model = $this->service->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'booksDataProvider' => new ActiveDataProvider([
                'query' => $model->getBooks(),
                'pagination' => [
                    'pageSize' => 50
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ]
                ],
            ])
        ]);
    }

    /**
     * Creates a new Author model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws \yii\web\HttpException
     */
    public function actionCreate(AuthorForm $form)
    {
        if ($this->request->isPost && $form->validate()) {
            $author = $this->service->createFromForm($form);
            return $this->redirect(['view', 'id' => $author->id]);

        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Top ten authors by Year
     * @param $year
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionTop($year = null): string
    {
        if ($year === null) {
            $year = (int) (new DateTime('now'))->format('Y');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Author::find()->getTopTenByYear($year),
            'pagination' => [
                'pageSize' => 10
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, AuthorForm $form)
    {
        if ($this->request->isPost && $form->validate()) {
            $author = $this->service->updateFromForm((int) $id, $form);
            return $this->redirect(['view', 'id' => $author->id]);
        }

        $model = $this->service->findModel((int) $id);
        $form->setAttributes($model->toArray());

        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * Deletes an existing Author model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): Response
    {
        $this->service->delete((int) $id);

        return $this->redirect(['index']);
    }
}
