<?php namespace App\Controllers;
use App\Models\UsersModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function register()
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            header('Location: ' . base_url());
            exit;
        } else {
            $usersModel = new UsersModel();
            $data['title'] = 'Înregistrare';

            if (! $this->validate([
                'username' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
                'email' => 'required|is_unique[users.email]',
                'password' => 'required',
                'confirm_password' => 'required|matches[password]',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('users/register.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $passHash = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

                $usersModel->save([
                    'username' => $this->request->getVar('username'),
                    'email' => $this->request->getVar('email'),
                    'password' => $passHash,
                    'role' => 'Student',
                ]);

                $data['action_message'] = "Ai fost înregistrat cu succes. Acum te poți autentifica <a href='" . base_url('autentificare') . "'>AICI</a>";

                echo view('templates/header.php', $data);
                echo view('message.php', $data);
                echo view('templates/footer.php', $data);
            }
        }
    }

    public function login()
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            header('Location: ' . base_url());
            exit;
        } else {
            $usersModel = new UsersModel();
            $data['title'] = 'Autentificare';

            if (! $this->validate([
                'username' => 'required|is_not_unique[users.username]',
                'password' => 'required',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('users/login.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $loggedInUser = $usersModel->getUser($this->request->getVar('username'));

                if (password_verify($this->request->getVar('password'), $loggedInUser['password'])) {
                    $session->set('el_user_id', $loggedInUser['id']);
                    $session->set('el_user_name', $loggedInUser['username']);

                    if (isset($_POST['remember_me'])) {
                        setcookie('el_user_id', $loggedInUser['id'], time() + (86400 * 30), '/');
                        setcookie('el_user_name', $loggedInUser['username'], time() + (86400 * 30), '/');
                    }

                    $data['action_message'] = 'Ai fost autentificat cu succes.';

                    echo view('templates/header.php', $data);
                    echo view('message.php', $data);
                    echo view('templates/footer.php', $data);
                } else {
                    $data['password_error'] = 'You entered a wrong password.';

                    echo view('templates/header.php', $data);
                    echo view('users/login.php', $data);
                    echo view('templates/footer.php', $data);
                }
            }
        }
    }

    public function logout()
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            $session->remove('el_user_id');
            $session->remove('el_user_name');
            if (isset($_COOKIE['el_user_id'])) {
                unset($_COOKIE['el_user_id']);
                setcookie('el_user_id', null, -1, '/');
            }
            if (isset($_COOKIE['el_user_name'])) {
                unset($_COOKIE['el_user_name']);
                setcookie('el_user_name', null, -1, '/');
            }
            $session->destroy();
        }
        header('Location: ' . base_url());
        exit;
    }

    public function teacher($id = 0)
    {
        $session = \Config\Services::session();
        $usersModel = new UsersModel();

        if (isAdmin()) {
            $data['teacher'] = $usersModel->getTeacher($id);

            if (empty($data['teacher'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Utilizatorul respectiv nu este profesor.');
            }

            $data['title'] = 'Adaugă Studenți';
            $data['students'] = $usersModel->getStudents();
            $data['user_unread_messages'] = userUnreadMessages();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                foreach ($data['students'] as $student) {
                    if (in_array($student['id'], $this->request->getVar('students'))) {
                        $usersModel->where('id', $student['id'])->set(['teacher_id' => $id])->update();
                    } else {
                        $usersModel->where('id', $student['id'])->set(['teacher_id' => 0])->update();
                    }
                }

                echo view('templates/header.php', $data);
                echo view('success.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                echo view('templates/header.php', $data);
                echo view('teacher/edit.php', $data);
                echo view('templates/footer.php', $data);
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function students()
    {
        $session = \Config\Services::session();
        $usersModel = new UsersModel();

        if (isAdmin()) {
            if (isset($_SESSION['el_user_name'])) {
                $teacher = $usersModel->getTeacher($_SESSION['el_user_id']);
            } else if (isset($_COOKIE['el_user_name'])) {
                $teacher = $usersModel->getTeacher($_COOKIE['el_user_id']);
            }

            if (empty($teacher)) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Utilizatorul respectiv nu este profesor.');
            }

            $data['title'] = 'Studenți';
            $data['students'] = $usersModel->getStudentsByTeacher($teacher['id']);
            $data['user_unread_messages'] = userUnreadMessages();

            echo view('templates/header.php', $data);
            echo view('teacher/students.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function all()
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $usersModel = new UsersModel();

            $data['title'] = 'Toți Utilizatorii';
            $data['users'] = $usersModel->getUsers();
            $data['user_unread_messages'] = userUnreadMessages();

            echo view('templates/header.php', $data);
            echo view('users/all.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function role($id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $usersModel = new UsersModel();

            $data['title'] = 'Schimbă Rol';
            $data['user'] = $usersModel->getUserById($id);
            $data['user_unread_messages'] = userUnreadMessages();

            if (empty($data['user'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Utilizatorul respectiv nu există.');
            }

            if ($data['user']['role'] == 'Admin') {
                $updateData = [
                    'role' => 'Student',
                    'is_teacher' => 0
                ];
            } else if ($data['user']['role'] == 'Student') {
                $updateData = [
                    'role' => 'Admin',
                    'is_teacher' => 1
                ];
            }

            $usersModel->update($id, $updateData);

            $data['action_message'] = 'Rolul utilizatorului respectiv a fost modificat cu succes.';

            echo view('templates/header.php', $data);
            echo view('message.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }
}