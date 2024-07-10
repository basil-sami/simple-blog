<?php
class PostController extends Controller
{
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to access 'index' and 'view' actions
                'actions' => array('index', 'view','comment', ),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to access 'comment' and 'like' actions
                'actions' => array('comment', 'like'),
                'users' => array('@'),
            ),
            array('deny',  // deny all users from accessing other actions by default
                'users' => array('*'),
            ),
        );
    }
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    public function actionOptimizedList()
    {
        $criteria = new CDbCriteria;
        $criteria->select = 'id, title, author_id';
        $criteria->with = array('comments', 'author');
        $criteria->together = true;
        $criteria->condition = 'comments_count > 0 AND author.blogs_count > 1';
        $criteria->order = 'create_time DESC';

        $posts = Post::model()->findAll($criteria);

        $this->render('optimized_list', array('posts' => $posts));
    }
    public function actionCreate()
    {
        $model = new Post;

        if(isset($_POST['Post']))
        {
            $model->attributes = $_POST['Post'];
            if($model->save())
            {
                // Handle successful save
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = Post::model()->findByPk($id);

        if(isset($_POST['Post']))
        {
            $model->attributes = $_POST['Post'];
            if($model->save())
            {
                // Handle successful update
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id)
    {
        $model = Post::model()->findByPk($id);
        if($model !== null)
        {
            $model->delete();
            // Handle successful deletion
        }
        // Redirect to index or other page
    }

    public function actionView($id)
    {
        $model = Post::model()->findByPk($id);
        if($model === null)
        {
            // Handle post not found error
        }
        $this->render('view', array('model' => $model));
    }
    public function actionComment()
    {
        if (isset($_POST['Comment'])) {
            $comment = new Comment();
            $comment->attributes = $_POST['Comment'];
            $comment->user_id = Yii::app()->user->isGuest ? null : Yii::app()->user->id; // Allow anonymous comments

            if ($comment->save()) {
                Yii::app()->user->setFlash('success', 'Comment added successfully.');
            } else {
                Yii::app()->user->setFlash('error', 'Unable to add comment.');
            }
            $this->redirect(array('post/view', 'id' => $comment->post_id));
        }
    }
}
