<?php namespace App\Models;
use CodeIgniter\Model;

class MessagesModel extends Model
{
    protected $table = 'messages';
    protected $allowedFields = ['author_id', 'recipient_id', 'title', 'body', 'author_read', 'recipient_read', 'author_read_on', 'recipient_read_on'];

    public function getAuthorUnreadMessages($id = 0)
    {
        return $this->where(['author_id' => $id, 'author_read' => 0])->findAll();
    }

    public function getAuthorReadMessages($id = 0)
    {
        return $this->where(['author_id' => $id, 'is_read' => 1])->findAll();
    }

    public function getRecipientUnreadMessages($id = 0)
    {
        return $this->where(['recipient_id' => $id, 'recipient_read' => 0])->findAll();
    }

    public function getRecipientReadMessages($id = 0)
    {
        return $this->where(['recipient_id' => $id, 'recipient_read' => 1])->findAll();
    }

    public function getSentMessages($id = 0)
    {
        return $this->where(['author_id' => $id])->findAll();
    }

    public function getMessage($id = 0)
    {
        return $this->where('id', $id)->asArray()->first();
    }
}