<?php  
namespace App\Controllers;

use App\Providers\View;
use App\Models\UserStore;
use App\Models\Privilege;
use App\Models\Database;
use App\Models\CRUD;



class AdminController
{
    public function dashboard()
    {
        session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["privilege"] !== 'admin') {
            $_SESSION['flash'] = " Accès refusé.";
            header("Location: index.php?page=home");
            exit;
        }

        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views');
        $twig = new \Twig\Environment($loader);

        echo $twig->render('admin/dashboard.twig', [
            "session" => $_SESSION,
            "asset" => ASSET
        ]);
    }

    public function listUsers()
    {
        session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["privilege"] !== "admin") {
            $_SESSION['flash'] = "Accès refusé.";
            header("Location: index.php?page=login");
            exit;
        }

        $userStore = new UserStore();
        $users = $userStore->getAll();

        $flash_message = '';
        if (!empty($_SESSION['flash'])) {
            $flash_message = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        $twig = View::twig();
        echo $twig->render('admin/users.twig', [
            'users' => $users,
            'flash' => $flash_message
        ]);
    }

    public function editUser()
    {
        session_start();

        if (!isset($_SESSION["loggedin"]) || $_SESSION["privilege"] !== "admin") {
            $_SESSION['flash'] = "Accès refusé.";
            header("Location: index.php?page=login");
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "Utilisateur introuvable.";
            exit;
        }

        $userStore = new UserStore();
        $privilegeStore = new Privilege(Database::getConnection());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userStore->update($id, [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'role' => $_POST['role']
            ]);

            $_SESSION['flash'] = "Utilisateur mis à jour avec succès.";
            header('Location: index.php?page=admin-users');
            exit;
        }

        $user = $userStore->find($id);
        $crudPrivilege = new CRUD(Database::getConnection(), 'Privilege');
        $privileges = $crudPrivilege->all();


        $twig = View::twig();
        echo $twig->render('admin/edit_user.twig', [
            'user' => $user,
            'privileges' => $privileges
        ]);
    }
}
