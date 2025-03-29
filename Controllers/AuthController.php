<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserStore;
use App\Models\Privilege;
use App\Models\Database;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class AuthController
{
    public function login() 
    {
        session_start();
        $pdo = Database::getConnection();

        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("Location: index.php?page=welcome");
            exit;
        }

        $flash_message = '';
        if (!empty($_SESSION['flash'])) {
            $flash_message = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        $loader = new FilesystemLoader(__DIR__ . '/../views/auth');
        $twig = new Environment($loader, ['cache' => false]);

        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => '',
            'login_err' => '',
            'logout_success' => isset($_GET['logout']) && $_GET['logout'] == 1 
                ? "You have been successfully logged out." 
                : '',
            'flash' => $flash_message,
            'path' => 'index.php?page=login',
            'asset' => '/projet-web-Lode-stampee/public' 
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data['email'] = trim($_POST["email"]);
            $data['password'] = trim($_POST["password"]);

            if (empty($data['email'])) {
                $data['email_err'] = "Please enter your email.";
            }

            if (empty($data['password'])) {
                $data['password_err'] = "Please enter your password.";
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $userModel = new User($pdo);
                $user = $userModel->findByEmail($data['email']);

                if ($user && password_verify($data['password'], $user['password'])) {
                    session_regenerate_id(true);

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user['id'];
                    $_SESSION["username"] = $user['name'];
                    $_SESSION["privilege"] = $user['user_privilege'];

                    header("Location: index.php?page=welcome");
                    exit;
                } else {
                    $data['login_err'] = "Invalid email or password.";
                }
            }
        }

        echo $twig->render('login.twig', $data);
    }

    public function register() 
    {
        $pdo = Database::getConnection();
        $loader = new FilesystemLoader(__DIR__ . '/../views/auth');
        $twig = new Environment($loader, ['cache' => false]);

        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'username_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
            'path' => 'index.php?page=register',
            'asset' => '/projet-web-Lode-stampee/public'
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data['username'] = trim($_POST["username"]);
            $data['email'] = trim($_POST["email"]);
            $data['password'] = trim($_POST["password"]);
            $data['confirm_password'] = trim($_POST["confirm_password"]);

            if (empty($data['username'])) {
                $data['username_err'] = "Please enter a username.";
            }

            if (empty($data['email'])) {
                $data['email_err'] = "Please enter an email.";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = "Invalid email format.";
            }

            if (empty($data['password'])) {
                $data['password_err'] = "Please enter a password.";
            }

            if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = "Passwords do not match.";
            }

            if (empty($data['username_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                try {
                    $userModel = new User($pdo);

                    if ($userModel->exists($data['email'])) {
                        $data['email_err'] = "This email is already registered.";
                    } else {
                        $privModel = new Privilege($pdo);
                        $userPriv = $privModel->getByName('user');

                        $userModel->create(
                            $data['username'],
                            $data['email'],
                            $data['password'],
                            $userPriv['id']
                        );

                        session_start();
                        $_SESSION['flash'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                        header("Location: index.php?page=login");
                        exit;
                    }
                } catch (\PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                    $data['email_err'] = "Something went wrong. Please try again.";
                }
            }
        }

        echo $twig->render('register.twig', $data);
    }

    public function registerAdmin()
    {
        $pdo = Database::getConnection();
        $loader = new FilesystemLoader(__DIR__ . '/../views/auth');
        $twig = new Environment($loader, ['cache' => false]);

        $data = [
            'username' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'username_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
            'path' => 'index.php?page=register-admin',
            'asset' => '/projet-web-Lode-stampee/public'
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data['username'] = trim($_POST["username"]);
            $data['email'] = trim($_POST["email"]);
            $data['password'] = trim($_POST["password"]);
            $data['confirm_password'] = trim($_POST["confirm_password"]);

            if (empty($data['username'])) {
                $data['username_err'] = "Please enter a username.";
            }

            if (empty($data['email'])) {
                $data['email_err'] = "Please enter an email.";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = "Invalid email format.";
            }

            if (empty($data['password'])) {
                $data['password_err'] = "Please enter a password.";
            }

            if ($data['password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = "Passwords do not match.";
            }

            if (
                empty($data['username_err']) &&
                empty($data['email_err']) &&
                empty($data['password_err']) &&
                empty($data['confirm_password_err'])
            ) {
                try {
                    $userModel = new User($pdo);

                    if ($userModel->exists($data['email'])) {
                        $data['email_err'] = "This email is already registered.";
                    } else {
                        $privModel = new Privilege($pdo);
                        $adminPriv = $privModel->getByName('admin');

                        $userModel->create(
                            $data['username'],
                            $data['email'],
                            $data['password'],
                            $adminPriv['id']
                        );

                        session_start();
                        $_SESSION['flash'] = "Administrateur inscrit avec succès.";
                        header("Location: index.php?page=login");
                        exit;
                    }
                } catch (\PDOException $e) {
                    $data['email_err'] = "Something went wrong. Please try again.";
                }
            }
        }

        echo $twig->render('register.twig', $data);
    }

    public function resetPassword()
    {
        $pdo = Database::getConnection();
        $loader = new FilesystemLoader(__DIR__ . '/../views/auth');
        $twig = new Environment($loader);

        $data = [
            'email' => '',
            'email_err' => '',
            'reset_success' => '',
            'path' => 'index.php?page=reset-password',
            'asset' => '/projet-web-Lode-stampee/public'
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $data['email'] = trim($_POST["email"]);

            if (empty($data['email'])) {
                $data['email_err'] = "Please enter your email.";
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = "Invalid email format.";
            }

            if (empty($data['email_err'])) {
                $data['reset_success'] = "A password reset link has been sent to your email address.";
            }
        }

        echo $twig->render('resetPassword.twig', $data);
    }

    public function logout()
    {
        session_start();
        $_SESSION['flash'] = "👋 Vous avez été déconnecté avec succès.";
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
