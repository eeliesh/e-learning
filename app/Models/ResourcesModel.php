<?php namespace App\Models;
use CodeIgniter\Model;

class ResourcesModel extends Model
{
    protected $table = 'posts';
    protected $allowedFields = ['title', 'author_id', 'description', 'file', 'subject_id', 'category'];

    public function getPost($id = 0)
    {
        return $this->asArray()->where(['id' => $id])->first();
    }

    public function getPosts()
    {
        return $this->orderBy('posted_on', 'desc')->findAll();
    }

    public function getLatestPosts()
    {
        return $this->orderBy('posted_on', 'desc')->findAll('6');
    }

    public function getCourses($id = 0)
    {
        return $this->orderBy('posted_on', 'desc')->where(['category' => 'Curs', 'subject_id' => $id])->findAll();
    }

    public function getSeminars($id = 0)
    {
        return $this->orderBy('posted_on', 'desc')->where(['category' => 'Seminar', 'subject_id' => $id])->findAll();
    }

    public function getLabs($id = 0)
    {
        return $this->orderBy('posted_on', 'desc')->where(['category' => 'Laborator', 'subject_id' => $id])->findAll();
    }

    public function getProjects($id = 0)
    {
        return $this->orderBy('posted_on', 'desc')->where(['category' => 'Proiect', 'subject_id' => $id])->findAll();
    }
}