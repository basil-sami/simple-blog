<?php
class BlogPostController extends Controller
{
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['BlogPost'])) {
            $model->attributes = $_POST['BlogPost'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function loadModel($id)
    {
        $model = BlogPost::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function actionCreate()
    {
        $model = new BlogPost;

        if (isset($_POST['BlogPost'])) {
            $model->attributes = $_POST['BlogPost'];
            $model->user_id = Yii::app()->user->id; // Set the user_id to the logged-in user
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Post created successfully.');
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->user->id !== $model->user_id && !Yii::app()->user->isAdmin) {
            throw new CHttpException(403, 'You are not authorized to delete this post.');
        }

        if ($model->delete()) {
            Yii::app()->user->setFlash('success', 'Post deleted successfully.');
        } else {
            Yii::app()->user->setFlash('error', 'Unable to delete the post.');
        }

        $this->redirect(array('index'));
    }

    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'login' action
                'actions' => array('index', 'view', 'create', 'update', 'like', 'delete','comment','realTimeBlogPosts'),
                'users' => array('*'),
            ),
            array('allow', // allow all users to view posts
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated users to create posts
                'actions' => array('create'),
                'users' => array('*'),
                'expression' => 'Yii::app()->user->email_verified', // restrict to verified users only
            ),
            array('allow', // allow authenticated users to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionRealTimeBlogPosts()
    {$criteria = new CDbCriteria;
        $criteria->select = 't.id, t.title, t.content, u.username, COUNT(c.id) AS comment_count';
        $criteria->join = 'LEFT JOIN users u ON t.user_id = u.id LEFT JOIN comments c ON t.id = c.blog_post_id';
        $criteria->group = 't.id';
        $criteria->having = 'COUNT(c.id) >= 1';
        
        // Subquery to get users with at least 2 blog posts
        $subquery = "(SELECT user_id
                     FROM blog_posts
                     GROUP BY user_id
                     HAVING COUNT(id) >= 2)";
        
        $criteria->addCondition('u.id IN (' . $subquery . ')');
        
        // Now you can use $criteria to fetch the results using CActiveRecord methods like findAll(), find(), etc.
        
        
    
        // Using CActiveDataProvider to fetch data
        $dataProvider = new CActiveDataProvider('BlogPost', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 10,  // Adjust as needed
            ),
        ));
    
        // Render the view with the data provider
        $this->render('realTimeBlogPosts', array(
            'dataProvider' => $dataProvider,
        ));
    }
    

        
        
        

    
        // Render a partial view or JSON response
     
    public function actionIndex()
    {
        $model = new BlogPost('search');
        $model->unsetAttributes();  // Clear any default values

        if (isset($_GET['BlogPost'])) {
            $model->attributes = $_GET['BlogPost'];
        }

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $model->search(),
        ));
    }

  // controllers/BlogPostController.php

public function actionView($id)
{
    $post = $this->loadModel($id); // Load the post model
    $newComment = new Comment; // Create a new comment model

    if (isset($_POST['Comment'])) {
        $newComment->attributes = $_POST['Comment'];
        $newComment->user_id = Yii::app()->user->id; // Assign current user ID
        $newComment->blog_post_id = $post->id; // Assign blog post ID

        if ($newComment->save()) {
            Yii::app()->user->setFlash('success', 'Comment posted successfully!');
            $this->refresh(); // Refresh the page to display new comment
        }
    }

    // Fetch comments related to the current post
    $comments = Comment::model()->findAllByAttributes(array('blog_post_id' => $post->id));

    $this->render('view', array(
        'model' => $post,
        'newComment' => $newComment,
        'comments' => $comments,
    ));
}


    public function actionSearch()
    {
        $criteria = new CDbCriteria;
        if (isset($_GET['query'])) {
            $criteria->addSearchCondition('title', $_GET['query'], true, 'OR');
            $criteria->addSearchCondition('content', $_GET['query'], true, 'OR');
        }
        $dataProvider = new CActiveDataProvider('BlogPost', array(
            'criteria' => $criteria,
        ));
        $this->render('search', array('dataProvider' => $dataProvider));
    }

    public function actionCreateBlogPost()
    {
        if (!Yii::app()->user->isGuest) {
            $userId = Yii::app()->user->id;
            $user = User::model()->findByPk($userId);
            if ($user !== null && $user->isVerified()) {
                // User's email is verified, proceed with blog post creation
                $model = new BlogPost;
                // Handle form submission and save blog post
                if (isset($_POST['BlogPost'])) {
                    $model->attributes = $_POST['BlogPost'];
                    if ($model->save()) {
                        Yii::app()->user->setFlash('success', 'Blog post created successfully.');
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
                $this->render('create', array('model' => $model));
            } else {
                // User's email is not verified, handle accordingly
                Yii::app()->user->setFlash('error', 'Please verify your email to create a blog post.');
                $this->redirect(array('site/index')); // Redirect to home page or login page
            }
        } else {
            $this->redirect(array('site/login')); // Redirect to login page if user is not logged in
        }
    }

    public function isVerified()
    {
        return $this->email_verified == 1; // Adjust condition based on your database schema
    }

    public function actionLike()
    {
        if (Yii::app()->request->isPostRequest) {
            $postId = Yii::app()->request->getPost('id');
            
            // Logging incoming data
            Yii::log('Post ID: ' . $postId, 'info');

            if (!$postId) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid post ID.']);
                Yii::app()->end();
            }

            // Example logic to toggle like status
            $post = BlogPost::model()->findByPk($postId);
            if ($post) {
                $user = Yii::app()->user->id;
                $like = Like::model()->findByAttributes(['post_id' => $postId, 'user_id' => $user]);
                if ($like) {
                    $like->delete();
                    echo json_encode(['status' => 'unliked']);
                } else {
                    $newLike = new Like();
                    $newLike->post_id = $postId;
                    $newLike->user_id = $user;
                    if ($newLike->save()) {
                        echo json_encode(['status' => 'liked']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to like post.']);
                    }
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Post not found.']);
            }
            Yii::app()->end();
        } else {
            throw new CHttpException(400, 'Invalid request method.');
        }
    }
    // controllers/BlogPostController.php

public function actionComment($id)
{
   $post = $this->loadModel($id); // Load the blog post model

   $newComment = new Comment;

   if (isset($_POST['Comment'])) {
       $newComment->attributes = $_POST['Comment'];
       $newComment->user_id = Yii::app()->user->id; // Assign current user ID
       $newComment->blog_post_id = $post->id; // Assign blog post ID

       if ($newComment->save()) {
           Yii::app()->user->setFlash('success', 'Comment posted successfully!');
           $this->refresh(); // Refresh the page to display new comment
       } else {
           Yii::app()->user->setFlash('error', 'Failed to post comment.');
       }
   }

   $comments = Comment::model()->findAllByAttributes(array('blog_post_id' => $post->id));

   $this->render('view', array(
       'model' => $post,
       'newComment' => $newComment,
       'comments' => $comments,
   ));
}

}
