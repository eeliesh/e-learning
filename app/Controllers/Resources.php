<?php namespace App\Controllers;
use App\Models\ResourcesModel;
use App\Models\UsersModel;
use App\Models\SubjectsModel;
use App\Models\StudentPostsModel;
use CodeIgniter\Controller;

class Resources extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function index()
    {
        $session = \Config\Services::session();

        $postsModel = new ResourcesModel();
        $subjectsModel = new SubjectsModel();

        $data['title'] = 'Resurse';
        $subjects = $subjectsModel->getSubjects();
        $finalSubjects = array();

        foreach ($subjects as $subject) {
            $subject['courses'] = $postsModel->getCourses($subject['id']);
            $subject['seminars'] = $postsModel->getSeminars($subject['id']);
            $subject['labs'] = $postsModel->getLabs($subject['id']);
            $subject['projects'] = $postsModel->getProjects($subject['id']);
            array_push($finalSubjects, $subject);
        }

        $data['subjects'] = $finalSubjects;
        $data['user_unread_messages'] = userUnreadMessages();

        echo view('templates/header.php', $data);
        echo view('posts/index.php', $data);
        echo view('templates/footer.php', $data);
    }

    public function create()
    {
        $session = \Config\Services::session();
        $postsModel = new ResourcesModel();
        $subjectsModel = new SubjectsModel();

        if (isAdmin()) {
            $data['title'] = 'Postare Nouă';
            $data['subjects'] = $subjectsModel->getSubjects();
            $data['user_unread_messages'] = userUnreadMessages();

            if (! $this->validate([
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[3]',
                'file' => 'uploaded[file]|max_size[file,30720]|ext_in[file,pdf,ppt,pptx,doc,docx,zip]',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('posts/create.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $post = $this->request->getFile('file');
                $postName = $post->getName();
                $post->move(ROOTPATH . 'public/uploads/posts');

                $authorId = userId();
                $postDesc = str_replace(PHP_EOL, '<br>', $this->request->getVar('description'));
                $postDesc = htmlentities($postDesc);

                $postsModel->save([
                    'title' => $this->request->getVar('title'),
                    'author_id' => $authorId,
                    'description' => $postDesc,
                    'file' => $postName,
                    'subject_id' => $this->request->getVar('subject'),
                    'category' => $this->request->getVar('category'),
                ]);

                echo view('templates/header.php', $data);
                echo view('success.php', $data);
                echo view('templates/footer.php', $data);
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function view($id = 0)
    {
        $session = \Config\Services::session();
        $postsModel = new ResourcesModel();
        $usersModel = new UsersModel();
        $subjectsModel = new SubjectsModel();
        $studentPostsModel = new StudentPostsModel();

        $data['post'] = $postsModel->getPost($id);

        if (empty($data['post'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsită postarea cu ID-ul #' . $id);
        }

        $data['user_unread_messages'] = userUnreadMessages();

        $data['title'] = $data['post']['title'];
        $data['post']['description'] = html_entity_decode($data['post']['description']);
        $data['post']['author_name'] = $usersModel->getUsername($data['post']['author_id']);
        $data['post']['subject_name'] = $subjectsModel->getSubject($data['post']['subject_id'])['name'];

        if ($data['post']['category'] != 'Laborator' && $data['post']['category'] != 'Proiect') {
            echo view('templates/header.php', $data);
            echo view('posts/view.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            if (! $this->validate([
                'description' => 'required|min_length[3]',
                'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,zip,pdf,ppt,pptx,doc,docx]',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('posts/view.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $description = str_replace(PHP_EOL, '<br>', $this->request->getVar('description'));
                $description = htmlentities($description);

                $file= $this->request->getFile('file');
                $fileName = $file->getName();
                $file->move(ROOTPATH . 'public/uploads/students');

                $studentPostsModel->save([
                    'post_id' => $data['post']['id'],
                    'student_id' => userId(),
                    'description' => $description,
                    'file' => $fileName,
                ]);

                $data['action_message'] = 'Fișierul a fost trimis cu succes.';

                echo view('templates/header.php', $data);
                echo view('message.php', $data);
                echo view('templates/footer.php', $data);
            }
        }
    }

    public function edit($id = 0)
    {
        $session = \Config\Services::session();
        $postsModel = new ResourcesModel();
        $subjectsModel = new SubjectsModel();

        if (isAdmin()) {
            $data['post'] = $postsModel->getPost($id);

            if (empty($data['post'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsită postarea cu ID-ul #' . $id);
            }

            $data['post']['description'] = html_entity_decode($data['post']['description']);
            $data['post']['description'] = str_replace('<br>', PHP_EOL, $data['post']['description']);
            $data['subjects'] = $subjectsModel->getSubjects();
            $data['title'] = 'Editează Postare #' . $data['post']['id'];
            $data['user_unread_messages'] = userUnreadMessages();

            if (! $this->validate([
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[3]',
                'file' => 'uploaded[file]|max_size[file,30720]|ext_in[file,pdf,ppt,pptx,doc,docx,zip]',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('posts/edit.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $postDesc = str_replace(PHP_EOL, '<br>', $this->request->getVar('description'));
                $postDesc = htmlentities($postDesc);

                $updateData = [
                    'title' => $this->request->getVar('title'),
                    'description' => $postDesc,
                    'subject_id' => $this->request->getVar('subject'),
                    'category' => $this->request->getVar('category'),
                ];

                if (!empty($_FILES['file']['name'])) {
                    $post = $this->request->getFile('file');
                    $updateData['file'] = $post->getName();
                    $post->move(ROOTPATH . 'public/uploads/posts');
                }

                $postsModel->update($id, $updateData);

                echo view('templates/header.php', $data);
                echo view('success.php', $data);
                echo view('templates/footer.php', $data);
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function delete($id = 0)
    {
        $session = \Config\Services::session();
        $postsModel = new ResourcesModel();

        if (isAdmin()) {
            $data['post'] = $postsModel->getPost($id);

            if (empty($data['post'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsită postarea cu ID-ul #' . $id);
            }

            $postsModel->where('id', $id)->delete();
            $postsModel->purgeDeleted();

            echo view('templates/header.php', $data);
            echo view('success.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function search()
    {
        $session = \Config\Services::session();
        $postsModel = new ResourcesModel();

        $data['title'] = 'Caută Postări';
        $data['user_unread_messages'] = userUnreadMessages();

        if (! $this->validate([
            'search_word' => 'required|min_length[1]|max_length[30]',
        ]))
        {
            echo view('templates/header.php', $data);
            echo view('posts/search.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            $searchWord = strtolower($this->request->getVar('search_word'));
            $allPosts = $postsModel->getPosts();
            $finalPosts = array();

            if (!empty($allPosts)) {
                foreach ($allPosts as $post) {
                    $post['title'] = strtolower($post['title']);
                    $post['title'] = str_replace(',', '', $post['title']);
                    $post['exploded_title'] = explode(' ', $post['title']);
                    if (in_array($searchWord, $post['exploded_title'])) {
                        array_push($finalPosts, $post);
                    }
                }
            }

            $data['posts'] = $finalPosts;

            echo view('templates/header.php', $data);
            echo view('posts/search.php', $data);
            echo view('templates/footer.php', $data);
        }
    }
}