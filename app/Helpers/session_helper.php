<?php
use App\Models\UsersModel;
use App\Models\MessagesModel;

function isLoggedIn()
{
    if ((isset($_SESSION['el_user_id']) && isset($_SESSION['el_user_name'])) || (isset($_COOKIE['el_user_id']) && isset($_COOKIE['el_user_name']))) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if (isLoggedIn()) {
        $usersModel = new UsersModel();
        $userName = '';

        if (isset($_SESSION['el_user_name'])) {
            $userName = $_SESSION['el_user_name'];
        } else if (isset($_COOKIE['el_user_name'])) {
            $userName = $_COOKIE['el_user_name'];
        }

        $userRole = $usersModel->getUser($userName)['role'];

        if ($userRole == 'Admin') {
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function userName()
{
    if (isLoggedIn()) {
        if (isset($_SESSION['el_user_name'])) {
            return $_SESSION['el_user_name'];
        } else if (isset($_COOKIE['el_user_name'])) {
            return $_COOKIE['el_user_name'];
        }
    }
    return 'Unknown';
}

function userId()
{
    if (isLoggedIn()) {
        if (isset($_SESSION['el_user_id'])) {
            return $_SESSION['el_user_id'];
        } else if (isset($_COOKIE['el_user_id'])) {
            return $_COOKIE['el_user_id'];
        }
    }
    return 0;
}

function studentTeacherId()
{
    if (isLoggedIn()) {
        $usersModel = new UsersModel();
        $user = $usersModel->getUser(userName());
        return $user['teacher_id'];
    }
    return 0;
}

function shuffle_assoc(&$array) {
    $keys = array_keys($array);
    shuffle($keys);
    $new = array();
    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }
    $array = $new;
    return true;
}

function userUnreadMessages()
{
    if (isLoggedIn()) {
        $messagesModel = new MessagesModel();
        $authorUnreadMessages = $messagesModel->getAuthorUnreadMessages(userId());
        $recipientUnreadMessages = $messagesModel->getRecipientUnreadMessages(userId());
        $finalUnreadMessages = array();
        if (!empty($authorUnreadMessages)) {
            foreach ($authorUnreadMessages as $message) {
                array_push($finalUnreadMessages, $message);
            }
        }
        if (!empty($recipientUnreadMessages)) {
            foreach ($recipientUnreadMessages as $message) {
                array_push($finalUnreadMessages, $message);
            }
        }
        return count(array_filter($finalUnreadMessages));
    } else {
        return 0;
    }
}