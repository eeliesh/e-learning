<?php namespace App\Models;
use CodeIgniter\Model;

class SubjectsModel extends Model
{
    protected $table = 'subjects';
    protected $allowedFields = ['name'];

    public function getSubjects()
    {
        return $this->findAll();
    }

    public function getSubject($id = 0)
    {
        return $this->where('id', $id)->asArray()->first();
    }
}