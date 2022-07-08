<?php
class Users {
    private $pdo;
    public function __CONSTRUCT() {
        try {
            $this->pdo = Database::Conectar();
            $pdo = null;
        }
            catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function usersList() {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM users
            WHERE password is not null
            ORDER BY username ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function userGet($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM users
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function permissionGet($permissionId) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE id = ?");
            $stm->execute(array($permissionId));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deactivate($id) {
        try {
            $sql = "UPDATE users SET password = null WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function permissionsGet($userId) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM user_permissions a 
            WHERE userId = ?");
            $stm->execute(array($userId));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function permissionsGetbyId($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function PermissionsList($category) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE category = ?
            ORDER BY sort,name ASC");
            $stm->execute(array($category));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function PermissionsTitleList() {
        try {
            $stm = $this->pdo->prepare("SELECT DISTINCT(category)
            FROM permissions
            ORDER BY sort,category ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function userSave($item) {
        try {
            $sql = "INSERT INTO users (username,email,password,lang) VALUES (?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->name,
                    $item->email,
                    $item->newpass,
                    $item->lang
                )
            );
            $id = $this->pdo->lastInsertId();
            $permission = '["10"]';
            $sql = "INSERT INTO user_permissions (userId,permissions) VALUES (?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $id,
                    $permission
                )
            );
            return $id;
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function userUpdate($item) {
        try {
            (!empty($item->cpass)) ? $pass = "password = '$item->newpass'," : $pass = "";
            $sql = "UPDATE users SET username = ?, email = ?, $pass lang = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->name,
                    $item->email,
                    $item->lang,
                    $item->userId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function userPermissionsSave($item) {
        try {
            $sql = "UPDATE user_permissions SET permissions = ? WHERE userId = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->permissions,
                    $item->userId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}