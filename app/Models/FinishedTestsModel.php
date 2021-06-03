<?php namespace App\Models;

use CodeIgniter\Model;

class FinishedTestsModel extends Model
{
    protected $table = 'finished_tests';
    protected $allowedFields = ['test_id', 'teacher_id', 'student_id', 'answers', 'grade', 'file'];

    public function getStudentFinishedTests($id = 0)
    {
        return $this->where('student_id', $id)->findAll();
    }

    public function getFinishedTest($id = 0, $student_id = 0)
    {
        return $this->where(['test_id' => $id, 'student_id' => $student_id])->asArray()->first();
    }

    public function getFinishedTestsByTeacher($id = 0)
    {
        return $this->where('teacher_id', $id)->findAll();
    }
}