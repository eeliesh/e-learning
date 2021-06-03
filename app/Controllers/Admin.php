<?php namespace App\Controllers;
use App\Models\UsersModel;
use App\Models\ResourcesModel;
use App\Models\TestsModel;
use App\Models\SubjectsModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function index()
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $usersModel = new UsersModel();
            $coursesModel = new ResourcesModel();
            $testsModel = new TestsModel();

            $data['title'] = 'Admin Panel';
            $data['users_count'] = $usersModel->countAll();
            $data['courses_count'] = $coursesModel->countAll();
            $data['tests_count'] = $testsModel->countAll();
            $data['user_unread_messages'] = userUnreadMessages();

            echo view('templates/header.php', $data);
            echo view('admin/index.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function subjects()
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $subjectsModel = new SubjectsModel();

            $data['title'] = 'Modifică Materii';
            $data['subjects'] = $subjectsModel->getSubjects();
            $data['user_unread_messages'] = userUnreadMessages();

            if (! $this->validate([
                'subject_name' => 'required|min_length[3]|max_length[100]|is_unique[subjects.name]',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('admin/subjects.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $subjectsModel->save([
                    'name' => $this->request->getVar('subject_name'),
                ]);

                header('Location: ' . base_url('materii'));
                exit;
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function deleteSubject($id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $subjectsModel = new SubjectsModel();

            $subject = $subjectsModel->getSubject($id);

            if (empty($subject)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsită materia respectivă.');
            }

            $subjectsModel->where('id', $id)->delete();
            $subjectsModel->purgeDeleted();

            header('Location: ' . base_url('materii'));
            exit;
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }
}