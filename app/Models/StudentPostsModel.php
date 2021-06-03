<?php namespace App\Models;
use CodeIgniter\Model;

class StudentPostsModel extends Model
{
    protected $table = 'student_posts';
    protected $allowedFields = ['post_id', 'student_id', 'description', 'file'];

    public function getStudentPost($id = 0)
    {
        return $this->where('id', $id)->asArray()->first();
    }

    public function getStudentPostByPost($id = 0)
    {
        return $this->where('post_id', $id)->findAll();
    }
}