<?php namespace App\Controllers;
use App\Models\ResourcesModel;
use App\Models\UsersModel;
use App\Models\SubjectsModel;
use App\Models\StudentPostsModel;
use CodeIgniter\Controller;

class StudentPosts extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function index($id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $studentPostsModel = new StudentPostsModel();
            $usersModel = new UsersModel();
            $postsModel = new ResourcesModel();

            $posts = $studentPostsModel->getStudentPostByPost($id);
            $data['original_post_id'] = $id;
            $data['post_title'] = $postsModel->getPost($id)['title'];
            $finalPosts = array();
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $post['student_name'] = $usersModel->getUserById($post['student_id'])['username'];
                    array_push($finalPosts, $post);
                }
            }
            $data['posts'] = $finalPosts;

            $data['title'] = 'Încărcări Studenți';
            $data['user_unread_messages'] = userUnreadMessages();

            echo view('templates/header.php', $data);
            echo view('posts/students.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function view($id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $studentPostsModel = new StudentPostsModel();
            $usersModel = new UsersModel();
            $postsModel = new ResourcesModel();

            $data['post'] = $studentPostsModel->getStudentPost($id);

            if (empty($data['post'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsită postarea cu ID-ul #' . $id);
            }

            $data['post']['student_name'] = $usersModel->getUserById($data['post']['student_id'])['username'];
            $data['title'] = 'Postare de la ' . $data['post']['student_name'];
            $data['post']['post_name'] = $postsModel->getPost($data['post']['post_id'])['title'];
            $data['post']['description'] = html_entity_decode($data['post']['description']);
            $data['user_unread_messages'] = userUnreadMessages();

            echo view('templates/header.php', $data);
            echo view('posts/student.php', $data);
            echo view('templates/footer.php', $data);

        } else {
            header('Location: ' . base_url());
            exit;
        }
    }
}