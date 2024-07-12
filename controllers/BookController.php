<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\Book;
use app\models\Forms\BookForm;
use app\services\Book\BookService;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BookController implements the CRUD actions for Book model.
 */
final class BookController extends Controller
{
    protected BookService $service;

    public function __construct($id, $module, BookService $service, $config = [])
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
                            'actions' => ['index', 'view'],
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
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
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
     * Displays a single Book model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): string
    {
        $model = $this->service->findModel((int) $id);
        return $this->render('view', [
            'model' => $this->service->findModel((int) $id),
            'authorsDataProvider' => new ActiveDataProvider([
                'query' => $model->getAuthors(),
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     * @throws HttpException|InvalidConfigException
     */
    public function actionCreate(BookForm $form)
    {
        if ($this->request->isPost && $form->validate()) {
            $book = $this->service->createFromForm($form);
            return $this->redirect(['view', 'id' => $book->id]);
        }

        return $this->render('create', [
            'model' => $form,
            'authors' => $this->service->getAuthorsList(),
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws HttpException|InvalidConfigException
     */
    public function actionUpdate($id, BookForm $form)
    {
        if ($this->request->isPost && $form->validate()) {
            $this->service->updateFromForm((int) $id, $form);
            return $this->redirect(['view', 'id' => $id]);
        }

        $model = $this->service->findModel((int) $id);
        $form->setAttributes(array_merge(
            $model->toArray(['isbn', 'title', 'description', 'year']),
            [
                'author_ids' => ArrayHelper::getColumn(
                    $model->getAuthors()->select('id')->all(),
                    'id'
                )
            ]
        ));

        return $this->render('update', [
            'model' => $form,
            'authors' => $this->service->getAuthorsList(),
        ]);
    }

    /**
     * Deletes an existing Book model.
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
