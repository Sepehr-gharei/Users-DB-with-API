<?php
# ======= CONNECT TO PDO =========
try {
    $pdo = new PDO("mysql:dbname=api_users;host=localhost", 'root', '');
    $pdo->exec("set names utf8;");
    // echo "Connection OK!";
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}


# ======= SELECTE USER =========

function getUsers($data)
{
    global $pdo;
    $user_id = $data['id'] ?? null;
    $where = "";
    if (!is_null($user_id) and is_numeric($user_id)) {
        $where = "where id = {$user_id} ";
    }
    $sql = "select * from users $where";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $records;
}
# ======= ADD USER =========
function addUser($data)
{
    global $pdo;
    $sql = "INSERT INTO `users` (`name`, `password`) VALUES (:name, :password);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $data['name'], ':password' => $data['password']]);
    return $stmt->rowCount();
}


# ======= UPDATE USER =========
function updateUser($name , $id){
    global $pdo;
    $sql = "UPDATE users set name = '$name' where id = $id "; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
    
}



# ====== DELETE USER =======
function deleteUser($id){
    global $pdo;
    $sql = "DELETE from users WHERE id = $id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->rowCount();
}