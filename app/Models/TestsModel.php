<?php namespace App\Models;

use CodeIgniter\Model;

class TestsModel extends Model
{
    protected $table = 'tests';
    protected $allowedFields = ['title', 'teacher_id', 'questions', 'answers', 'questions_count', 'start_time', 'end_time', 'question_limit'];

    public function getTests()
    {
        return $this->findAll();
    }

    public function getTest($id)
    {
        return $this->where('id', $id)->asArray()->first();
    }
}