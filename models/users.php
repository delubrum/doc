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
            $stm = $this->pdo->prepare("SELECT a.*, b.rolename
            FROM users a
            LEFT JOIN roles b
            ON a.role = b. id
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
            $stm = $this->pdo->prepare("SELECT a.id, a.role, b.rolename, a.username, a.email, a.password, a.lang, a.createdAt, a.active, a.imageData, a.imageType
            FROM users a
            LEFT JOIN roles b
            ON a.role = b.id
            WHERE a.id = ?");
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

    public function userMachinesList($userId) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM user_machines a 
            LEFT JOIN machines b 
            ON a.machineId = b.id
            WHERE userId = ?
            ORDER BY sort ASC");
            $stm->execute(array($userId));
            return $stm->fetchAll(PDO::FETCH_OBJ);
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

    public function rolePermissionsGet($roleId) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM roles
            WHERE id = ?");
            $stm->execute(array($roleId));
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

    public function RolesList() {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM roles
            ORDER BY rolename ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
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

    // public function userSave($item) {
    //     try {
    //         $sql = "INSERT INTO users (role,username,email,password,emailPassword,lang) VALUES (3,?,?,?,?,?)";
	// 		$this->pdo->prepare($sql)->execute(
    //             array(
    //                 $item->name,
    //                 $item->email,
    //                 $item->newpass,
    //                 $item->emailpass,
    //                 $item->lang
    //             )
    //         );
    //         $id = $this->pdo->lastInsertId();
    //         $permission = '["10"]';
    //         $sql = "INSERT INTO user_permissions (userId,permissions) VALUES (?,?)";
	// 		$this->pdo->prepare($sql)->execute(
    //             array(
    //                 $id,
    //                 $permission
    //             )
    //         );
    //         return $id;
    //     }
    //         catch (Exception $e) {
    //         die($e->getMessage());
    //     }    
    // }

    public function userSave($item) {
        try {
            $sql = "INSERT INTO users (role,username,email,password,lang) VALUES (3,?,?,?,?)";
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
            $sql = "UPDATE users SET role = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->roleId,
                    $item->userId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function rolePermissionsUpdate($item) {
        try {
            $sql = "UPDATE roles SET rolename = ?, permissions = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->rolename,
                    $item->permissions,
                    $item->roleId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function rolePermissionsSave($item) {
        try {
            $sql = "INSERT INTO roles (rolename,permissions) VALUES (?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->rolename,
                    $item->permissions,
                )
            );
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function clientsList() {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM clients ORDER BY name ASC");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}