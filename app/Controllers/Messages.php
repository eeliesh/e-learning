<?php namespace App\Controllers;
use App\Models\MessagesModel;
use App\Models\MessageRepliesModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;

class Messages extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function index()
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            $messagesModel = new MessagesModel();
            $usersModel = new UsersModel();

            $data['title'] = 'Mesaje';
            $authorUnreadMessages = $messagesModel->getAuthorUnreadMessages(userId());
            $authorReadMessages = $messagesModel->getAuthorReadMessages(userId());
            $sentMessages = $messagesModel->getSentMessages(userId());
            $recipientUnreadMessages = $messagesModel->getRecipientUnreadMessages(userId());
            $recipientReadMessages = $messagesModel->getRecipientReadMessages(userId());

            $finalUnreadMessages = $finalReadMessages = $finalSentMessages = array();
            if (!empty($authorUnreadMessages)) {
                foreach ($authorUnreadMessages as $message) {
                    $message['author_name'] = $usersModel->getUsername($message['author_id']);
                    array_push($finalUnreadMessages, $message);
                }
            }
            if (!empty($authorReadMessages)) {
                foreach ($authorReadMessages as $message) {
                    $message['author_name'] = $usersModel->getUsername($message['author_id']);
                    array_push($finalReadMessages, $message);
                }
            }
            if (!empty($sentMessages)) {
                foreach ($sentMessages as $message) {
                    $message['recipient_name'] = $usersModel->getUsername($message['recipient_id']);
                    array_push($finalSentMessages, $message);
                }
            }
            if (!empty($recipientUnreadMessages)) {
                foreach ($recipientUnreadMessages as $message) {
                    $message['author_name'] = $usersModel->getUsername($message['author_id']);
                    array_push($finalUnreadMessages, $message);
                }
            }
            if (!empty($recipientReadMessages)) {
                foreach ($recipientReadMessages as $message) {
                    $message['author_name'] = $usersModel->getUsername($message['author_id']);
                    array_push($finalReadMessages, $message);
                }
            }
            $data['unread_messages'] = $finalUnreadMessages;
            $data['read_messages'] = $finalReadMessages;
            $data['sent_messages'] = $finalSentMessages;
            $data['user_unread_messages'] = userUnreadMessages();

            echo view('templates/header.php', $data);
            echo view('messages/index.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function create()
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            $messagesModel = new MessagesModel();
            $usersModel = new UsersModel();

            $data['title'] = 'Mesaj Nou';
            $data['user_unread_messages'] = userUnreadMessages();

            if (! $this->validate([
                'recipient' => 'required|is_not_unique[users.username]',
                'title' => 'required|min_length[3]|max_length[255]',
                'message' => 'required|min_length[3]'
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('messages/create.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $recipientId = $usersModel->getUser($this->request->getVar('recipient'))['id'];
                $messageBody = str_replace(PHP_EOL, '<br>', $this->request->getVar('message'));
                $messageBody = htmlentities($messageBody);

                $timeNow = date('Y-m-d H:i:s', time());

                $messagesModel->save([
                    'author_id' => userId(),
                    'recipient_id' => $recipientId,
                    'title' => $this->request->getVar('title'),
                    'body' => $messageBody,
                    'author_read' => 1,
                    'recipient_read' => 0,
                    'author_read_on' => $timeNow,
                ]);

                $data['action_message'] = 'Mesajul a fost trimis cu succes.';

                echo view('templates/header.php', $data);
                echo view('message.php', $data);
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

        if (isLoggedIn()) {
            $messagesModel = new MessagesModel();
            $messageRepliesModel = new MessageRepliesModel();
            $usersModel = new UsersModel();

            $data['message'] = $messagesModel->getMessage($id);

            if (empty($data['message'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a fost găsit mesajul cu ID-ul ' . $id);
            }

            if ($data['message']['author_id'] == userId() || $data['message']['recipient_id'] == userId()) {
                $data['message']['author_name'] = $usersModel->getUsername($data['message']['author_id']);
                $data['message']['recipient_name'] = $usersModel->getUsername($data['message']['recipient_id']);
                $data['user_unread_messages'] = userUnreadMessages();

                if ($data['message']['author_id'] == userId()) {
                    $data['title'] = 'Mesaj către ' . $data['message']['recipient_name'];
                } else {
                    $data['title'] = 'Mesaj de la ' . $data['message']['author_name'];
                }

                $data['message']['body'] = html_entity_decode($data['message']['body']);

                if ($data['message']['recipient_read'] == 0 && userId() == $data['message']['recipient_id']) {
                    $readTime = date('Y-m-d H:i:s', time());
                    $messagesModel->where('id', $id)->set(['recipient_read' => 1, 'recipient_read_on' => $readTime])->update();
                } else if ($data['message']['author_read'] == 0 && userId() == $data['message']['author_id']) {
                    $readTime = date('Y-m-d H:i:s', time());
                    $messagesModel->where('id', $id)->set(['author_read' => 1, 'author_read_on' => $readTime])->update();
                }

                if ($data['message']['author_id'] == userId()) {
                    $data['message']['read_on'] = $data['message']['recipient_read_on'];
                } else {
                    $data['message']['read_on'] = $data['message']['author_read_on'];
                }

                $replies = $messageRepliesModel->getMessageReplies($data['message']['id']);
                $finalReplies = array();
                if (!empty($replies)) {
                    foreach ($replies as $reply) {
                        $reply['author_name'] = $usersModel->getUsername($reply['author_id']);
                        array_push($finalReplies, $reply);
                    }
                }
                $data['replies'] = $finalReplies;

                if (! $this->validate([
                    'reply' => 'required|min_length[3]'
                ]))
                {
                    echo view('templates/header.php', $data);
                    echo view('messages/view.php', $data);
                    echo view('templates/footer.php', $data);
                } else {
                    $messageBody = str_replace(PHP_EOL, '<br>', $this->request->getVar('reply'));
                    $messageBody = htmlentities($messageBody);

                    $messageRepliesModel->save([
                        'message_id' => $data['message']['id'],
                        'author_id' => userId(),
                        'body' => $messageBody,
                    ]);

                    if ($data['message']['author_id'] == userId()) {
                        $messagesModel->where('id', $data['message']['id'])->set(['recipient_read' => 0, 'recipient_read_on' => 'Necitit'])->update();
                    } else {
                        $messagesModel->where('id', $data['message']['id'])->set(['author_read' => 0, 'author_read_on' => 'Necitit'])->update();
                    }

                    header('Location: ' . base_url('mesaj' . '/' . $data['message']['id']));
                    exit;
                }
            } else {
                header('Location: ' . base_url('mesaje'));
                exit;
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function delete($id = 0)
    {
        $session = \Config\Services::session();

        if (isLoggedIn()){
            $messagesModel = new MessagesModel();

            $data['message'] = $messagesModel->getMessage($id);

            if (empty($data['message'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a fost găsit mesajul cu ID-ul ' . $id);
            }

            if (userId() == $data['message']['author_id'] || userId() == $data['message']['recipient_id']) {
                $messagesModel->where('id', $data['message']['id'])->delete();
                $messagesModel->purgeDeleted();
                header('Location: ' . base_url('mesaje'));
                exit;
            } else {
                header('Location: ' . base_url());
                exit;
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }
}