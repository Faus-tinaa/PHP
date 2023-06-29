<?php
require_once 'config.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    logout();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action === 'login') {
            login();
        }
        if ($action === 'insert') {
            insertTodo();
        }
        if ($action === 'hapus') {
            deleteTodo();
        }
        if ($action === 'selesai') {
            updateTodo();
        }
    }
}
function login()
{
    global $conn;
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $username = $_POST['email'];
        $password = $_POST['password'];

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT id FROM user WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            session_start();
            $_SESSION['id'] = $row['id'];
            $stmt->close();
            header('Location: /PHP_Sasa/todo.php');
            exit();
        } else {
            $stmt->close();
            echo "<script>
            alert('Tidak bisa login');
            window.location.href = 'loginTodo.php';
            </script>";
            exit();
        }
    }
}
function logout()
{
    session_start();
    session_destroy();
    header('Location: /PHP_Sasa/login.php');
    exit();
}
function insertTodo()
{
    global $conn;
    session_start();
    if (isset($_POST['valueTodo'])) {
        $valueTodo = $_POST['valueTodo'];
        $id = $_SESSION['id'];
        $status = 1;

        $sql = "INSERT INTO todo (`user_id`, `value`, `status`) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $id, $valueTodo, $status);
        $stmt->execute();

        $stmt->close();

        header('Location: /PHP_Sasa/todo.php');
    }
}
function deleteTodo()
{
    global $conn;
    session_start();
    if (isset($_POST['data'])) {
        $id = $_SESSION['id'];
        $idData = $_POST['data'];

        $sql = "DELETE FROM `todo` WHERE `id` = ? AND `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $idData, $id);
        $stmt->execute();

        $stmt->close();

        header('Location: /PHP_Sasa/todo.php');
    }
}
function updateTodo()
{
    global $conn;
    session_start();
    if (isset($_POST['data'])) {
        $id = $_SESSION['id'];
        $idData = $_POST['data'];

        $sql = "UPDATE `todo` SET `status`='0' WHERE `id` = ? AND `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $idData, $id);
        $stmt->execute();

        $stmt->close();

        header('Location: /PHP_Sasa/todo.php');
    }
}
function readTodo()
{
    global $conn;
    session_start();
    $id = $_SESSION['id'];

    $sql = "SELECT `id`, `value`, `status` FROM `todo` WHERE `user_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();

    return $result;
}
