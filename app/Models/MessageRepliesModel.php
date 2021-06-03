<?php namespace App\Models;
use CodeIgniter\Model;

class MessageRepliesModel extends Model
{
    protected $table = 'message_replies';
    protected $allowedFields = ['message_id', 'author_id', 'body'];

    public function getMessageReplies($id = 0)
    {
        return $this->where('message_id', $id)->findAll();
    }
}