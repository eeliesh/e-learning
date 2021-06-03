<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'email', 'password', 'role', 'is_teacher', 'teacher_id'];

    public function getUser($username = '')
    {
        return $this->asArray()->where(['username' => $username])->first();
    }

    public function getUserById($id = 0)
    {
        return $this->asArray()->where(['id' => $id])->first();
    }

    public function getUsers()
    {
        return $this->findAll();
    }

    public function getUsername($id = 0)
    {
        if ($id == 0) {
            return 'Unknown';
        } else {
            return $this->asArray()->where(['id' => $id])->first()['username'];
        }
    }

    public function getTeacher($id = 0)
    {
        return $this->asArray()->where(['id' => $id, 'is_teacher' => 1])->first();
    }

    public function getStudents()
    {
        return $this->where('is_teacher', 0)->findAll();
    }

    public function getStudentsByTeacher($id = 0)
    {
        return $this->where('teacher_id', $id)->findAll();
    }
}