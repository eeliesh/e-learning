<?php namespace App\Controllers;
use App\Models\TestsModel;
use App\Models\FinishedTestsModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;

class Tests extends Controller
{
    public function __construct()
    {
        helper('session');
    }

    public function index()
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            $usersModel = new UsersModel();
            $testsModel = new TestsModel();
            $finishedTestsModel = new FinishedTestsModel();

            $data['title'] = 'Evaluare';
            $data['teacher'] = $usersModel->getTeacher(userId());
            $data['user_unread_messages'] = userUnreadMessages();

            $allTests = $testsModel->getTests();

            if (!empty($data['teacher'])) {
                $teacherTests = array();
                if (!empty($allTests)) {
                    foreach ($allTests as $test) {
                        if ($test['teacher_id'] == userId()) {
                            $test['author_name'] = $usersModel->getUsername($test['teacher_id']);
                            array_push($teacherTests, $test);
                        }
                    }
                }
                $data['teacher_tests'] = $teacherTests;
            } else {
                $studentTests = $finishedTestsModel->getStudentFinishedTests(userId());
                $incomingTests = $finishedTests = $finishedTestsArr = array();
                if (!empty($studentTests)) {
                    foreach ($studentTests as $studentTest) {
                        array_push($finishedTestsArr, $studentTest['test_id']);
                    }
                }
                if (!empty($allTests)) {
                    foreach ($allTests as $test) {
                        if ($test['teacher_id'] == studentTeacherId()) {
                            if (!in_array($test['id'], $finishedTestsArr)) {
                                $test['author_name'] = $usersModel->getUsername($test['teacher_id']);
                                array_push($incomingTests, $test);
                            } else {
                                $test['author_name'] = $usersModel->getUsername($test['teacher_id']);
                                array_push($finishedTests, $test);
                            }
                        }
                    }
                }
                $data['incoming_tests'] = $incomingTests;
                $data['finished_tests'] = $finishedTests;
            }

            echo view('templates/header.php', $data);
            echo view('tests/index.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url('autentificare'));
            exit;
        }
    }

    public function start()
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $data['title'] = 'Creare Test';
            $data['user_unread_messages'] = userUnreadMessages();

            if (! $this->validate([
                'questions_number' => 'required|is_natural|is_natural_no_zero'
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('tests/start.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $session->set('questions_number', $this->request->getVar('questions_number'));
                header('Location: ' . base_url('test/creare'));
                exit;
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function create()
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            if (!isset($_SESSION['questions_number'])) {
                header('Location: ' . base_url('test/creare/inceput'));
                exit;
            } else {
                $testsModel = new TestsModel();

                $data['title'] = 'Creare Test';
                $data['user_unread_messages'] = userUnreadMessages();

                if (! $this->validate([
                    'title' => 'required|min_length[3]|max_length[255]'
                ]))
                {
                    echo view('templates/header.php', $data);
                    echo view('tests/create.php', $data);
                    echo view('templates/footer.php', $data);
                } else {
                    $questionsArr = $answersArr = array();

                    for ($i = 1; $i <= $_SESSION['questions_number']; $i++) {
                        $questionName = 'question_' . $i;
                        $questionsArr[$i] = $this->request->getVar($questionName);
                        $answerName = 'answer_' . $i;
                        $answersArr[$i] = str_replace(PHP_EOL, ',', $this->request->getVar($answerName));
                    }

                    $questions = serialize($questionsArr);
                    $answers = serialize($answersArr);

                    $startTime = $this->request->getVar('start_year') . '-' . $this->request->getVar('start_month') . '-' . $this->request->getVar('start_day');
                    $startTime = $startTime . ' ' . $this->request->getVar('start_hour') . ':' . $this->request->getVar('start_minute') . ':00';

                    $endTime = $this->request->getVar('end_year') . '-' . $this->request->getVar('end_month') . '-' . $this->request->getVar('end_day');
                    $endTime = $endTime . ' ' . $this->request->getVar('end_hour') . ':' . $this->request->getVar('end_minute') . ':00';

                    $testsModel->save([
                        'title' => $this->request->getVar('title'),
                        'teacher_id' => userId(),
                        'questions' => $questions,
                        'answers' => $answers,
                        'questions_count' => $_SESSION['questions_number'],
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'question_limit' => $this->request->getVar('question_limit'),
                    ]);

                    unset($_SESSION['questions_number']);

                    echo view('templates/header.php', $data);
                    echo view('success.php', $data);
                    echo view('templates/footer.php', $data);
                }
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function view($id = 0, $question = 0)
    {
        $session = \Config\Services::session();

        if (isLoggedIn()) {
            $testsModel = new TestsModel();
            $usersModel = new UsersModel();
            $finishedTestsModel = new FinishedTestsModel();

            $data['test'] = $testsModel->getTest($id);

            if (empty($data['test'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsit testul cu ID-ul #' . $id);
            }

            $data['title'] = $data['test']['title'];
            $data['test']['author_name'] = $usersModel->getUsername($data['test']['teacher_id']);
            $data['test']['questions'] = unserialize($data['test']['questions']);
            shuffle_assoc($data['test']['questions']);
            $data['user_unread_messages'] = userUnreadMessages();

            $doneTests = $finishedTestsModel->getStudentFinishedTests(userId());
            $doneTestsArr = array();
            if (!empty($doneTests)) {
                foreach ($doneTests as $test) {
                    array_push($doneTestsArr, $test['test_id']);
                }
            }

            if (in_array($id, $doneTestsArr)) {
                $data['finished_test'] = $finishedTestsModel->getFinishedTest($id, userId());
                $data['finished_test']['answers'] = unserialize($data['finished_test']['answers']);

                echo view('templates/header.php', $data);
                echo view('tests/done.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $timeNow = date('Y-m-d H:i:s', time());

                if (!isAdmin() && ($timeNow > $data['test']['end_time'])) {
                    $data['action_message'] = "Timpul testului respectiv a expirat și nu îl mai poți susține.<br>Acesta s-a sfârșit pe: " . $data['test']['end_time'];

                    echo view('templates/header.php', $data);
                    echo view('message.php', $data);
                    echo view('templates/footer.php', $data);
                } else if (!isAdmin() && ($timeNow < $data['test']['start_time'])) {
                    $data['action_message'] = "Testul încă nu a început.<br>Acesta va fi activ pe: " . $data['test']['start_time'];

                    echo view('templates/header.php', $data);
                    echo view('message.php', $data);
                    echo view('templates/footer.php', $data);
                } else {
                    if (!isset($_SESSION['ongoing_test'])) {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['begin_test'])) {
                            $_SESSION['ongoing_test'] = true;
                            header('Location: ' . base_url('test' . '/' . $id . '/intrebare/' . array_rand($data['test']['questions'])));
                            exit;
                        } else {
                            echo view('templates/header.php', $data);
                            echo view('tests/begin.php', $data);
                            echo view('templates/footer.php', $data);
                        }
                    } else if (isset($_SESSION['ongoing_test']) && $_SESSION['ongoing_test'] == true) {
                        if (array_key_exists($question, $data['test']['questions'])) {
                            $answers = unserialize($data['test']['answers']);
                            $finalAnswers = array();

                            $count = 0;
                            foreach ($answers as $answer) {
                                $count++;
                                $finalAnswers[$count] = explode(',', $answer);
                            }

                            $data['test']['answers'] = $finalAnswers;
                            $data['test']['question_id'] = $question;

                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['next_question'])) {
                                $_SESSION['question_' . $question] = $question;
                                $_SESSION['answer_' . $question] = $this->request->getVar('answer');
                                unset($data['test']['questions'][$question]);
                                header('Location: ' . base_url('test' . '/' . $id . '/intrebare/' . array_rand($data['test']['questions'], 1)));
                                exit;
                            } else {
                                if (!isset($_SESSION['question_' . $question])) {
                                    if ($data['test']['question_limit'] != 0) {
                                        $_SESSION['question_' . $question] = $question;
                                        $_SESSION['answer_' . $question] = 'Fără răspuns (timpul limită a expirat).';
                                        header( "refresh:" . $data['test']['question_limit'] . ";url=" .  base_url('test' . '/' . $id . '/intrebare/' . array_rand($data['test']['questions'], 1)));
                                    }

                                    echo view('templates/header.php', $data);
                                    echo view('tests/question.php', $data);
                                    echo view('templates/footer.php', $data);
                                } else {
                                    unset($data['test']['questions'][$_SESSION['question_' . $question]]);
                                    $answeredAllQuestions = array();
                                    for ($i = 1; $i <= $data['test']['questions_count']; $i++) {
                                        if (isset($_SESSION['answer_' . $i])) {
                                            $value = true;
                                        } else {
                                            $value = false;
                                        }
                                        array_push($answeredAllQuestions, $value);
                                    }
                                    if (in_array(false, $answeredAllQuestions)) {
                                        header('Location: ' . base_url('test' . '/' . $id . '/intrebare/' . array_rand($data['test']['questions'], 1)));
                                        exit;
                                    } else {
                                        if (! $this->validate([
                                            'test_file' => 'max_size[test_file,5120]|ext_in[test_file,zip]',
                                        ]))
                                        {
                                            echo view('templates/header.php', $data);
                                            echo view('tests/end.php', $data);
                                            echo view('templates/footer.php', $data);
                                        } else {
                                            $testAnswers = array();

                                            for ($i = 1; $i <= $data['test']['questions_count']; $i++) {
                                                $testAnswers[$_SESSION['question_' . $i]] = $_SESSION['answer_' . $i];
                                            }

                                            $testAnswers = serialize($testAnswers);

                                            if (!empty($_FILES['test_file']['name'])) {
                                                $testFile = $this->request->getFile('test_file');
                                                $testFileName = $testFile->getName();
                                                $testFile->move(ROOTPATH . 'public/uploads/tests');
                                            } else {
                                                $testFileName = null;
                                            }

                                            $finishedTestsModel->save([
                                                'test_id' => $data['test']['id'],
                                                'teacher_id' => $data['test']['teacher_id'],
                                                'student_id' => userId(),
                                                'answers' => $testAnswers,
                                                'file' => $testFileName,
                                            ]);

                                            for ($i = 1; $i <= $data['test']['questions_count']; $i++) {
                                                unset($_SESSION['question_' . $i]);
                                                unset($_SESSION['answer_' . $i]);
                                            }

                                            $data['action_message'] = 'Ai trimis testul cu succes.';

                                            echo view('templates/header.php', $data);
                                            echo view('message.php', $data);
                                            echo view('templates/footer.php', $data);
                                        }
                                    }
                                }
                            }
                        } else {
                            header('Location: ' . base_url('test' . '/' . $id . '/intrebare/' . array_rand($data['test']['questions'])));
                            exit;
                        }
                    }
                }
            }
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function delete($id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $testsModel = new TestsModel();

            $data['test'] = $testsModel->getTest($id);

            if (empty($data['test'])) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsit testul cu ID-ul #' . $id);
            }

            $testsModel->where('id', $id)->delete();
            $testsModel->purgeDeleted();

            $data['action_message'] = 'Testul a fost șters cu succes.';

            echo view('templates/header.php', $data);
            echo view('message.php', $data);
            echo view('templates/footer.php', $data);

        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function finished($id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $testsModel = new TestsModel();
            $finishedTestsModel = new FinishedTestsModel();
            $usersModel = new UsersModel();

            $data['title'] = 'Test #' . $id . ' Finalizat';
            $data['test'] = $testsModel->getTest($id);

            if (empty($data['test']) || userId() != $data['test']['teacher_id']) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsit testul cu ID-ul #' . $id);
            }

            $data['user_unread_messages'] = userUnreadMessages();
            $finishedTests = $finishedTestsModel->getFinishedTestsByTeacher(userId());
            $finalTests = array();
            if (!empty($finishedTests)) {
                foreach ($finishedTests as $test) {
                    if ($test['test_id'] == $id) {
                        $test['student_name'] = $usersModel->getUserById($test['student_id'])['username'];
                        array_push($finalTests, $test);
                    }
                }
            }
            $data['finished_tests'] = $finalTests;

            echo view('templates/header.php', $data);
            echo view('tests/finished.php', $data);
            echo view('templates/footer.php', $data);
        } else {
            header('Location: ' . base_url());
            exit;
        }
    }

    public function studentTest($test_id = 0, $student_id = 0)
    {
        $session = \Config\Services::session();

        if (isAdmin()) {
            $testsModel = new TestsModel();
            $finishedTestsModel = new FinishedTestsModel();
            $usersModel = new UsersModel();

            $data['finished_test'] = $finishedTestsModel->getFinishedTest($test_id, $student_id);

            if (empty($data['finished_test']) || userId() != $data['finished_test']['teacher_id'] || $data['finished_test']['student_id'] != $student_id) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Nu a putut fi găsit testul cu ID-ul #' . $test_id);
            }

            $data['test'] = $testsModel->getTest($test_id);
            $data['test']['student_name'] = $usersModel->getUserById($student_id)['username'];
            $data['title'] = 'Test #' . $test_id . ' Finalizat de ' . $data['test']['student_name'];
            $data['user_unread_messages'] = userUnreadMessages();

            $data['test']['questions'] = unserialize($data['test']['questions']);
            $data['finished_test']['answers'] = unserialize($data['finished_test']['answers']);

            if (! $this->validate([
                'grade' => 'required',
            ]))
            {
                echo view('templates/header.php', $data);
                echo view('tests/test.php', $data);
                echo view('templates/footer.php', $data);
            } else {
                $finishedTestsModel->where('id', $data['finished_test']['id'])->set(['grade' => $this->request->getVar('grade')])->update();

                $data['action_message'] = 'Testul a fost evaluat cu succes.';

                echo view('templates/header.php', $data);
                echo view('message.php', $data);
                echo view('templates/footer.php', $data);
            }

        } else {
            header('Location: ' . base_url());
        }
    }
}