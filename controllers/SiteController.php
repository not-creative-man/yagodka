<?php

namespace app\controllers;

use app\models\Cash;
use app\models\CashForm;
use app\models\Event;
use app\models\EventForm;
use app\models\EventToUser;
use app\models\IndexForm;
use app\models\SkillForm;
use app\models\Task;
use app\models\TaskForm;
use app\models\TaskToUser;
use app\models\JourneyForm;
use app\models\MeetingForm;
use app\models\Order;
use app\models\OrgForm;
use app\models\Post;
use app\models\Product;
use app\models\Rating;
use app\models\RatingForm;
use app\models\SMMForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\UserAttributes;
use app\models\RegistrationForm;
use app\models\UploadForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['register', 'login'],
                        'allow' => false,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['register', 'login', 'index', 'rating', 'events', 'event', 'profile', 'about'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function () {
                    return Yii::$app->response->redirect(['/site/index']);
                },
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new IndexForm();
        $member_count = User::find()->where(['status' => 1])->count();
        $event_count = Event::find()->where(['status' => 1])->count();
        $total_coverage = Event::find()->where(['status' => 1])->sum('coverage');

        return $this->render('index', [
            'model' => $model,
            'member_count' => $member_count,
            'event_count' => $event_count,
            'total_coverage' => $total_coverage
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $arr = UserAttributes::find()->where(['user_id' => Yii::$app->user->id])->all();
            if (!empty($arr)){
                return $this->goHome();}
            else
                return $this->redirect(['site/contact']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $arr = UserAttributes::find()->where(['user_id' => Yii::$app->user->id])->all();
            if (!empty($arr)){
                return $this->goHome();
            }
            else
                return $this->redirect(['site/contact']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        $attr = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
        $model->phone = $attr->phone ? $attr->phone : '';
        $model->isu = $attr->isu ? $attr->isu : '';
        $model->vk = $attr->vk ? $attr->vk : '';
        $model->email = $attr->email ? $attr->email :'';

        // $phone = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
        // $model->phone = $phone ? $phone->attribute_value : '';
        // $isu = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'isu'])->one();
        // $model->isu = $isu ? $isu->attribute_value : '';
        // $vk = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'vk'])->one();
        // $model->vk = $vk ? $vk->attribute_value : '';
        // $email = UserAttributes::find()->where(['user_id' => Yii::$app->user->identity->getId(), 'attribute_name' => 'email'])->one();
        // $model->email = $email ? $email->attribute_value :'';

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect([
                'site/profile',
                'uid' => Yii::$app->user->getId(),
            ]);
        }
        return $this->render('editcontact', [
            'model' => $model,
            'user' => Yii::$app->user->identity,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionProfile($uid)
    {

        $user = User::findIdentity($uid);
        $userattributes = $user->userAttributes;
        $ratingModel = new RatingForm;
        $сashModel = new CashForm;
        // $skillModel = new SkillForm;
        $events = $user->events;
        $tasks = $user->tasks;
        // $skills = $user->skills;

        if ($ratingModel->load(Yii::$app->request->post()) && $ratingModel->changeRating($uid)){
            $user = User::findIdentity($uid);
            $ratingModel = new RatingForm;
        }
        if ($сashModel->load(Yii::$app->request->post()) && $сashModel->changeСash($uid)){
            $user = User::findIdentity($uid);
            $сashModel = new CashForm;
        }
        // if ($skillModel->load(Yii::$app->request->post()) && $skillModel->changeSkill($uid)){
        //     $user = User::findIdentity($uid);
        //     $skillModel = new SkillForm;
        // }
        return $this->render('userinfo',
            [
                'user' => $user,
                'userattributes' => $userattributes,
                'ratingModel' => $ratingModel,
                'cashModel' => $сashModel,
                'events' => $events,
                'tasks' => $tasks,
                //'skills' => $skills
            ]);
    }

    public function actionRating()
    {
        $rating = User::find()->orderBy(['rating' => SORT_DESC])->all();
        foreach ($rating as $record) {
            if (!is_null($tmp = $record->rating())) {
                $record->rating = $record->rating();
                $record->save();
            }
        }
        $rating = User::find()->orderBy(['rating' => SORT_DESC])->all();

        return $this->render('rating',
            [
                'rating' => $rating,
            ]);
    }

    public function actionRegister() {
        $model = new RegistrationForm();
        $model->scenario = 'register';

        if ($model->load(Yii::$app->request->post()) && $model->register()){
            return $this->goBack();
        }
        $model->password = '';
        $model->password_repeat = '';

        return $this->render('register',[
            'model' => $model,
            'uid' => NULL,
        ]);
    }

    public function actionAddRating($uid) {
        $ratingModel = new RatingForm;
        if ($ratingModel->load(Yii::$app->request->post()) && $ratingModel->changeRating($uid)) {
            echo 1;
            //return $this->refresh();
        }
        //return $this->refresh();
        echo 2;
        var_dump(Yii::$app->request->post());
    }

    public function actionAddСash($uid) {
        $сashModel = new CashForm;
        if ($сashModel->load(Yii::$app->request->post()) && $сashModel->changeСash($uid)) {
            echo 1;
        }
        echo 2;
        var_dump(Yii::$app->request->post());
    }

    public function actionEvent($id) {
        $event = Event::findIdentity($id);
        return $this->render('event',
            [
                'event' => $event,
            ]);
    }

    public function actionMembers() {
        $users = User::find()->orderBy('status')->all();
        return $this->render('members',[
            'users' => $users
        ]);
    }

    public function actionConfirm($uid) {
        $user = User::findIdentity($uid);
        $user->status = !$user->status;
        $user->save();
        return $this->redirect(['site/members']);
    }

    public function actionUserrating($uid) {
        $rating = Rating::find()->where(['user_id' => $uid])->orderBy(['id' => SORT_DESC])->all();
        $user = User::findIdentity($uid);
        //var_dump($rating);
        //die;
        return $this->render('userrating', [
            'rating' => $rating,
            'user' => $user
        ]);
    }
    public function actionUsercash($uid) {
        $cash = Cash::find()->where(['user_id' => $uid])->orderBy(['id'=>SORT_DESC])->all();
        $user = User::findIdentity($uid);
        //var_dump($cash);
        //die;
        return $this->render('usercash', [
            'cash' => $cash,
            'user' => $user
        ]);
    }

    public function actionNewevent() {
        $model = new EventForm();

        $allusers = User::find()->Where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }
        $curators = [];
        foreach ($allusers as $user) {
            if ($user->role_id == 5) {
                $curators[$user->id] = $user->berry;
            }
        }
        if ($model->load(Yii::$app->request->post())){
            $model->backimage = UploadedFile::getInstance($model, 'backimage');
            if($model->register()){
                return $this->goBack();            
            }
        }
        return $this->render('newevent', [
            'model' => $model,
            'users' => $users,
            'curators' => $curators
        ]);
    }

    public function actionUpdateUserAttr(){
        $model = UserAttributes::find()->all();
        
        var_dump($model);
        return false;
    } 

//    public function actionAddorg($eid) {
//        $orgModel = new OrgForm();
//        $allusers = User::find()->where(['<>','id', Yii::$app->user->getId()])->andWhere(['status' => 1])->all();
//        $model = Event::findIdentity($eid);
//        $users = [];
//        foreach ($allusers as $user) {
//            $users[$user->id] = $user->userInitials();
//        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->register()){
//            //return $this->goBack();
//            echo '<pre>';
//            var_dump($this->orgs);
//            echo '</pre>';
//            die;
//        }
//
//        return $this->render('addorgs', [
//                'users' => $users,
//                'orgModel' => $orgModel,
//                'model' => $model
//            ]
//        );
//    }

    public function actionEvents(){
        $trueEvents = Event::find()->select('{{event}}.*')->where(['status' => 1])->orderBy(['id' => SORT_DESC])->all();
        $ucEvents = Event::find()->select('{{event}}.*')->where(['status' => 0])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('events', [
            'trueEvents' => $trueEvents,
            'ucEvents' => $ucEvents
        ]);
    }


    public function actionEditevent($eid){
        $event = Event::findIdentity($eid);
        $model = new EventForm();
        $team = $event->users;

        $allusers = User::find()->where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }
        $curators = [];
        foreach ($allusers as $user) {
            if ($user->role_id == 5) {
                $curators[$user->id] = $user->berry;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->change($eid)){
            return $this->redirect(['site/events', 'eid'=>$eid]);
        }

        foreach ($model->attributes as $key => $value) {
            if ($key == 'mainorg' || $key == 'curator' || $key == 'orgs' || $key == 'responsible' || $key == 'volunteer') continue;
            $model->$key = $event->$key;
        }

        foreach ($team as $member) {
            if (EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role == Event::ROLE_MANAGER)
                $model->mainorg[] = $member->id;
        }

        foreach ($team as $member) {
            if (EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role == Event::ROLE_CURATOR)
                $model->curator[] = $member->id;
        }

        foreach ($team as $member) {
            if (EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role == Event::ROLE_ORGANIZER)
                $model->orgs[] = $member->id;
            }

        foreach ($team as $member) {
            if (EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role == Event::ROLE_VOLUNTEER)
                $model->volunteer[] = $member->id;
        }

        foreach ($team as $member) {
            if (EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role == Event::ROLE_WORKER)
                $model->responsible[] = $member->id;
        }

        return $this->render('newevent', [
            'model' => $model,
            'users' => $users,
            'curators' => $curators
        ]);
    }

    public function actionDeleteEvent($eid) {
        EventToUser::deleteAll(['event_id' => $eid]);
        Event::deleteAll(['id' => $eid]);
        return $this->redirect(['site/events']);

    }
    public function actionConfirmevent($eid) {
        $event = Event::findIdentity($eid);
        if ($event->status) {
            $records = Rating::findAll(['service' => $eid]);
            foreach ($records as $record) {
                $record->delete();
            }
            $records = Cash::findAll(['service' => $eid]);
            foreach ($records as $record) {
                $record->delete();
            }
        } else {
            $team = $event->users;
            foreach ($team as $member) {
                $role = EventToUser::findOne(['user_id' => $member->id, 'event_id' => $eid])->role;

                $record = new Rating();
                $record->user_id = $member->id;
                $record->comment = $event->name.' - '.Rating::$role_names[$role];
                $record->count = Rating::$role_rating[$role];
                $record->service = $eid;
                $record->save();

                $record = new Cash();
                $record->user_id = $member->id;
                $record->comment = $event->name.' - '.Cash::$role_names[$role];
                $record->count = Cash::$role_rating[$role];
                $record->service = $eid;
                $record->save();
            }
        }
        $event->status = !$event->status;
        $event->save();
        return $this->redirect(['site/events']);
    }
    public function actionNewtask() {
        $model = new TaskForm();
        if ($model->load(Yii::$app->request->post()) && $model->register(Yii::$app->user->identity->getId())){
            return $this->goBack();
        }
        return $this->render('newtask', [
            'model' => $model,
        ]);
    }
    public function actionTask($id) {
        $task = Task::findIdentity($id);
        return $this->render('task',
            [
                'task' => $task,
            ]);
    }
    public function actionEditTask($tid) {
        $task = Task::findIdentity($tid);
        $model = new TaskForm();

        if ($model->load(Yii::$app->request->post()) && $model->change($tid)){
            return $this->redirect(['site/tasks', 'tid'=>$tid]);
        }

        foreach ($model->attributes as $key => $value) {
            $model->$key = $task->$key;
        }

        return $this->render('newtask', [
            'model' => $model,
        ]);
    }

    public function actionTasks(){
        $tasks = Task::find()->where( ['status' => 1] or ['status' => 0])->all(); //все задачи
        $didTasks = Task::find()->where(['status' => 1])->orderBy((['id' => SORT_DESC]))->all(); //завершенные задачи
        $newTasks = Task::find()->where(['status' => 0])->orderBy((['id' => SORT_DESC]))->all(); //свободные задачи

        $users = []; //все юзеры задействованные в задачах
        //проход по каждой задаче
        foreach ($tasks as $task) {
            //все свяязи юзер + ID задачи
            $usersToTask = TaskToUser::find()->where(['task_id' => $task->id])->all();
            $TaskUsers = [];
            //проход по каждой связи в пределах одной задачи
            foreach ($usersToTask as $record) {
                //поиск юзера по id
                $user = User::findOne(['id' => $record->user_id]);
                //заполнение массива юзеров в пределах одной задачи
                $TaskUsers[] = $user;
            }
            //добавление пары id задачи + users в этой задаче
            $users[$task->id] = $TaskUsers;
        }

        return $this->render('tasks', [
            'didTasks' => $didTasks,
            'newTasks' => $newTasks,
            'users' => $users,
        ]);
    }
    public function actionConfirmTask($tid) {
        $task = Task::findIdentity($tid);
        $team = $task->users;
        $revard = round($task->cash / count($team));
        foreach ($team as $member) {
            $record = new Rating();
            $record->user_id = $member->id;
            $record->comment = 'Выполнено задание: ' . $task->name;
            $record->count = $revard;
            $record->service = -1*$tid;
            $record->save();

            $record = new Cash();
            $record->user_id = $member->id;
            $record->comment = 'Выполнено задание: ' . $task->name;
            $record->count = $revard;
            $record->service = -1*$tid;
            $record->save();
        }
        $task->status = 1;
        $task->save();
        return $this->redirect(['site/tasks']);
    }
    public function actionRebutTask($tid) {
        $task = Task::findIdentity($tid);
        $task->status = 0;
        $task->save();
        $records = Rating::findAll(['service' => -1*$tid]);
        foreach ($records as $record) {
            $record->delete();
        }
        $records = Cash::findAll(['service' => -1*$tid]);
        foreach ($records as $record) {
            $record->delete();
        }
        return $this->redirect(['site/tasks']);
    }
    public function actionDeleteTask($tid){
        TaskToUser::deleteAll(['task_id' => $tid]);
        Task::deleteAll(['id' => $tid]);
        return $this->redirect(['site/tasks']);
    }
    public function actionConfirmTaskToUser($tid) {
        $task = Task::findIdentity($tid);
        $uid = Yii::$app->user->identity->id;

        $record = new TaskToUser();
        $record->user_id = $uid;
        $record->task_id = $tid;
        $record->cash = $task->cash;
        $record->save();
        return $this->redirect(['site/tasks']);
    }
    public function actionDisproveTaskToUser($tid) {
        $task = Task::findIdentity($tid);
        $uid = Yii::$app->user->identity->id;
        TaskToUser::deleteAll(['task_id' => $tid, 'user_id' => $uid]);
        return $this->redirect(['site/tasks']);
    }
    public function actionDeleteUserTask(array $ids) {
        $uid = $ids['uid'];
        $tid = $ids['tid'];
        TaskToUser::deleteAll(['task_id' => $tid, 'user_id' => $uid]);
        return $this->redirect(['site/tasks']);
    }

    public function actionEditUser($uid){
        $model = new RegistrationForm();
        $user = User::findOne(['id' => $uid]);
        $userAttr = UserAttributes::find()->where(['user_id' => $uid])->one();

        var_dump($userAttr->attributes);

        foreach ($model->attributes as $key => $value) {
            if ($key == 'password_repeat') continue;
            if ( $key == 'isu' || $key == 'phone' || $key == 'vk' ){
                $model->$key = $userAttr->$key;
            } else {
                $model->$key = $user->$key;
            }
        }

        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->update($uid)){
            return $this->redirect(['site/profile', 'uid' => $uid]);
        }

        return $this->render('register',[
            'model' => $model,
            'uid' => $uid,
        ]);
    }

    public function actionUploadAvatar($uid){
        $model = new UploadForm();
        $user = User::findIdentity($uid);

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->upload($uid)) {
                return $this->redirect(['site/profile', 'uid' => $uid]);;
            }
        }

        return $this->render('upload',[
            'model' => $model,
            'user' => $user,
        ]);
    }

    public function actionJourney() {
        $model = new JourneyForm();
        $allusers = User::find()->where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }

        if ($model->load(Yii::$app->request->post()) && $model->add()){
            return $this->redirect(['site/rating']);
        }

        return $this->render('journey',
            [
                'model' => $model,
                'users' => $users
            ]
        );
    }

    public function actionMeeting() {
        $model = new MeetingForm();
        $allusers = User::find()->where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }

        if ($model->load(Yii::$app->request->post()) && $model->add()){
            return $this->redirect(['site/rating']);
        }

        return $this->render('meeting',
            [
                'model' => $model,
                'users' => $users
            ]
        );
    }

    public function actionDeleteUser($uid) {
        $user = User::findIdentity($uid);
        try { //TODO ПЕРЕДЕЛАТЬ НОРМАЛЬНО
            $user->delete();
        }
        catch (\Exception $e) {
            return $this->redirect(['site/members']);
        }
        return $this->redirect(['site/members']);
    }

    public function actionSmm() {
        $allusers = User::find()->where(['status' => 1])->all();
        $users = [];
        foreach ($allusers as $user) {
            $users[$user->id] = $user->berry;
        }

        $model = new SMMForm;

        if ($model->load(Yii::$app->request->post()) && $model->addPost()){
            return $this->redirect(['site/rating']);
        }

        return $this->render('SMM',
            [
                'model' => $model,
                'users' => $users
            ]
        );
    }

    public function actionDryUser($uid){
        $user = User::findIdentity($uid);
        $user->status = 2;
        $user->save();
        return $this->redirect(['site/members']);
    }

    public function actionWetUser($uid){
        $user = User::findIdentity($uid);
        $user->status = 1;
        $user->save();
        return $this->redirect(['site/members']);
    }
}

?>