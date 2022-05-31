<?php

header('Content-Type: text/html; charset=UTF-8');
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $messages = array();


    if (!empty($_COOKIE['save'])) {

        setcookie('save', '', 100000);
        setcookie('login', '', 100000);
        setcookie('pass', '', 100000);

        $messages[] = 'Спасибо, результаты сохранены.';

        if (!empty($_COOKIE['pass'])) {
            $messages[] = sprintf(
                '<div>Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.</div>',
                strip_tags($_COOKIE['login']),
                strip_tags($_COOKIE['pass'])
            );
        }
    }


    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['limbs'] = !empty($_COOKIE['limbs_error']);
    $errors['select'] = !empty($_COOKIE['select_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['policy'] = !empty($_COOKIE['policy_error']);


    if ($errors['name']) {
        setcookie('name_error', '', 100000);
        $messages[] = '<div class="message">Введите имя.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div class="message">Введите верный email.</div>';
    }
    if ($errors['date']) {
        setcookie('date_error', '', 100000);
        $messages[] = '<div class="message">Введите корректную дату рождения.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = '<div class="message">Выберите пол.</div>';
    }
    if ($errors['limbs']) {
        setcookie('limbs_error', '', 100000);
        $messages[] = '<div class="message">Выберите количество конечностей.</div>';
    }
    if ($errors['select']) {
        setcookie('select_error', '', 100000);
        $messages[] = '<div class="message">Выберите суперспособнос(ть/ти).</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        $messages[] = '<div class="message">Расскажите о себе.</div>';
    }
    if ($errors['policy']) {
        setcookie('policy_error', '', 100000);
        $messages[] = '<div class="message">Ознакомтесь с политикой обработки данных.</div>';
    }

    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : strip_tags($_COOKIE['name_value']);
    $values['email'] = empty($_COOKIE['email_value']) ? '' : strip_tags($_COOKIE['email_value']);
    $values['date'] = empty($_COOKIE['date_value']) ? '' : strip_tags($_COOKIE['date_value']);
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : strip_tags($_COOKIE['gender_value']);
    $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : strip_tags($_COOKIE['limbs_value']);
    $values['select'] = empty($_COOKIE['select_value']) ? '' : strip_tags($_COOKIE['select_value']);
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
    $values['policy'] = empty($_COOKIE['policy_value']) ? '' : strip_tags($_COOKIE['policy_value']);

    if (empty($errors) && !empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
        try {
            $user = 'u47545';
            $pass = '5871686';
            $member = $_SESSION['login'];
            $db = new PDO('mysql:host=localhost;dbname=u47545', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
            $stmt = $db->prepare("SELECT * FROM members2 WHERE login = ?");
            $stmt->execute(array($member));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $values['name'] = $result['name'];
            $values['email'] = $result['email'];
            $values['date'] = $result['date'];
            $values['gender'] = $result['gender'];
            $values['limbs'] = $result['limbs'];
            $values['bio'] = $result['bio'];
            $values['policy'] = $result['policy'];

            $powers = $db->prepare("SELECT distinct name from supermembers join superpowers2 pow on power_id = pow.id where member_id = ?");
            $powers->execute(array($result['id']));
            $result = $powers->fetchAll(PDO::FETCH_ASSOC);
            $values['select'] = implode(',', $result);
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
        printf('<div>Вход с логином %s, uid %d</div>', $_SESSION['login'], $_SESSION['uid']);
    }
    include('form.php');
} else {
    $errors = FALSE;

    if (!preg_match('/^([a-zA-Z]|[а-яА-Я])/', $_POST['name'])) {
        setcookie('name_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('name_value', $_POST['name'], time() + 12 * 30 * 24 * 60 * 60);
    }


    if (!preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', $_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 12 * 30 * 24 * 60 * 60);
    }


    $date = explode('-', $_POST['date']);
    $age = (int)date('Y') - (int)$date[0];
    if ($age > 100 || $age < 0) {
        setcookie('date_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('date_value', $_POST['date'], time() + 12 * 30 * 24 * 60 * 60);
    }


    if (empty($_POST['gender'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 12 * 30 * 24 * 60 * 60);
    }


    if (empty($_POST['limbs'])) {
        setcookie('limbs_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('limbs_value', $_POST['limbs'], time() + 12 * 30 * 24 * 60 * 60);
    }


    if (empty($_POST['select'])) {
        setcookie('select_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('select_value', implode(',', $_POST['select']), time() + 12 * 30 * 24 * 60 * 60);
    }


    if (empty($_POST['bio'])) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $_POST['bio'], time() + 12 * 30 * 24 * 60 * 60);
    }


    if (empty($_POST['policy'])) {
        setcookie('policy_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('policy_value', $_POST['policy'], time() + 12 * 30 * 24 * 60 * 60);
    }

    if ($errors) {

        header('Location: index.php');
        exit();
    } else {
        setcookie('name_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('limbs_error', '', 100000);
        setcookie('select_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('policy_error', '', 100000);
    }

    $user = 'u47545';
    $pass = '5871686';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $gender = $_POST['gender'];
    $limbs = $_POST['limbs'];
    $bio = $_POST['bio'];
    $policy = $_POST['policy'];
    $powers = $_POST['select'];
    $member = $_SESSION['login'];

    $db = new PDO('mysql:host=localhost;dbname=u47545', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

    if (!empty($_COOKIE[session_name()]) && session_start() && !empty($_SESSION['login'])) {
        try {
            $stmt = $db->prepare("UPDATE members2 SET name = ?, email = ?, date = ?, gender = ?, limbs = ?, bio = ?, policy = ? WHERE login = ?");
            $stmt->execute(array($name, $email, $date, $gender, $limbs, $bio, $policy, $member));

            $stmt = $db->prepare("SELECT id FROM members2 WHERE login = ?");
            $stmt->execute(array($member));
            $member_id = $stmt->fetch(PDO::FETCH_ASSOC);

            $superpowers = $db->prepare("DELETE FROM supermembers WHERE member_id = ?");
            $superpowers->execute(array($member_id['id']));

            foreach ($powers as $value) {
                $stmt = $db->prepare("SELECT id from superpowers2 WHERE name = ?");
                $stmt->execute(array($value));
                $power_id = $stmt->fetch(PDO::FETCH_ASSOC);

                $superpowers = $db->prepare("INSERT INTO supermembers SET power_id = ?, member_id = ? ");
                $superpowers->execute(array($power_id['id'], $member_id['id']));
            }
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    } else {
        $login = uniqid();
        $password = uniqid();
        $hash = md5($password);

        setcookie('login', $login);
        setcookie('pass', $password);

        try {
            $stmt = $db->prepare("INSERT INTO members2 SET login = ?, pass = ?, name = ?, email = ?, date = ?, gender = ?, limbs = ?, bio = ?, policy = ?");
            $stmt->execute(array($login, $hash, $name, $email, $date, $gender, $limbs, $bio, $policy));
            $member_id = $db->lastInsertId();
            foreach ($powers as $value) {
                $stmt = $db->prepare("SELECT id from superpowers2 WHERE name = ?");
                $stmt->execute(array($value));
                $power_id = $stmt->fetch(PDO::FETCH_ASSOC);

                $superpowers = $db->prepare("INSERT INTO supermembers SET power_id = ?, member_id = ? ");
                $superpowers->execute(array($power_id['id'], $member_id));
            }
        } catch (PDOException $e) {
            print('Error : ' . $e->getMessage());
            exit();
        }
    }
    setcookie('save', '1');
    header('Location: ./');
}
