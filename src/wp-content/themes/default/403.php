<?php
    global $twig;

    $msg = '';
    if (isset($_POST['password'])) {
        $msg = 'Invalid password';

        if ($_POST['password'] == get_field('password', 'site')) {
            $_SESSION['password'] = $_POST['password'];
            header('Location: ' . get_site_url());
            die();
        }
    }

    $password = ((get_field('status', 'site') == 'dev') && get_field('password', 'site'));

    echo $twig->render('403.html', array('password' => $password, 'msg' => $msg));