<?php namespace App\Controllers;
use App\Models\ResourcesModel;
use CodeIgniter\Controller;

class Pages extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function home()
    {
        $session = \Config\Services::session();
        $postsModel = new ResourcesModel();

        $data['page_title'] = 'Electro Study';
        $data['masthead_bg'] = 'bg.jpg';
        $data['page_desc'] = 'Gestionează Activitățile Didactice cu Ușurință';
        $data['title'] = 'Acasă';
        $data['latest_posts'] = $postsModel->getLatestPosts();
        $data['user_unread_messages'] = userUnreadMessages();

        echo view('templates/header.php', $data);
        echo view('home.php', $data);
        echo view('templates/footer.php', $data);
    }
}