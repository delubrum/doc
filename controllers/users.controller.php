<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/users.php';
require_once 'models/init.php';
require_once 'middlewares/util.php';
require 'vendor/autoload.php';

class UsersController{
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
    $this->init = new Init();
    $this->util = new Util();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(9, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/users/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Roles(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    if (in_array(11, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/users/roles.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Profile(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    $a = 'Profile';
    $b = 'User';
    require_once 'views/layout/header.php';
    require_once 'views/users/profile.php';
  }

  public function UserForm(){
    require_once "middlewares/check.php";
    $a = 'Edit';
    require_once 'views/users/new.php';
  }

  public function UserEdit(){
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_REQUEST['id']);
    $permissions = json_decode($this->users->permissionsGet($_SESSION["id-SIGMA"])->permissions, true);
    $a = 'Profile';
    $b = 'Edit';
    require_once 'views/users/profile.php';
  }

  public function Deactivate(){
    $this->users->deactivate($_REQUEST['id']);
  }

  public function UserSave(){
    // $dotenv = Dotenv\Dotenv::createUnsafeImmutable('/var/www/html/sigma/'); $dotenv->load();
    require_once "middlewares/check.php";
    $user = $this->users->UserGet($_SESSION["id-SIGMA"]);
    $item = new stdClass();
    $item->name=$_REQUEST['name'];
    $item->email=$_REQUEST['email'];
    $item->lang=$_REQUEST['lang'];
    // $IV = getenv('IV');
    // $KEY = getenv('KEY');
    // $ciphering = getenv('CIPHERING');
    // $iv_length = openssl_cipher_iv_length($ciphering);
    // $item->emailpass = openssl_encrypt($_REQUEST['emailpass'], $ciphering,$KEY, 0 , $IV);
    $item->newpass=$_REQUEST['newpass'];
    $item->cpass=$_REQUEST['cpass'];
    if ($item->cpass != '' and $item->cpass != $item->newpass) {
      echo "New Password do not match";
    } else {
      $item->newpass = password_hash($item->newpass, PASSWORD_DEFAULT);
      if (!empty($_REQUEST['userId'])) {
        $item->userId = $_REQUEST['userId'];
        $this->users->userUpdate($item);
        echo $item->userId;
        if ($item->userId == $user->id) {
          session_start();
          $_SESSION["id-SIGMA"] = "";
          session_destroy();
          $this->util->clearAuthCookie();        }
      } else {
        $id = $this->users->userSave($item);
        echo $id;
      }
    }
  }

  public function UserPermissionsSave(){
    $item = new stdClass();
    $item->roleId=$_REQUEST['roleId'];
    $item->userId=$_REQUEST['userId'];
    $item->permissions=json_encode($_REQUEST['permissions']);
    $this->users->userPermissionsSave($item);
  }

  public function RolePermissions(){
    foreach ($this->users->PermissionsTitleList() as $t) { ?>
      <div class="mt-3">
        <h5><?php echo $t->category ?></h5>
        <hr>
      </div>
      <?php 
      $rolePermissions = json_decode($this->users->rolePermissionsGet($_REQUEST['roleId'])->permissions);
      foreach ($this->users->PermissionsList($t->category) as $p) { ?>
        <label class="btn <?php echo (in_array($p->id, $rolePermissions)) ? 'btn-primary' : 'btn-secondary'; ?> permission active" data-id="<?php echo $p->id ?>" style="cursor:pointer">
          <?php echo $p->name ?>
          <?php echo (in_array($p->id, $rolePermissions)) ? "<input type='hidden' name='permissions[]' value='$p->id'>" : ""; ?>
        </label>
      <?php 
      }
    }
  }

  public function RolesForm(){
    (isset($_REQUEST['id'])) ? $item = $this->users->rolePermissionsGet($_REQUEST['id']) : '';
    $processes = array('cut','laser','punch','router','brake','cnc_profiles','drilling','welding','pretreatment','painting','assembly','packing');
    require_once 'views/users/new_role.php';
  }

  public function RolePermissionsSave(){
    $item = new stdClass();
    $item->rolename=$_REQUEST['rolename'];
    $item->permissions=json_encode($_REQUEST['permissions']);
    if (!empty($_REQUEST['roleId'])) {
      $item->roleId = $_REQUEST['roleId'];
      $this->users->rolePermissionsUpdate($item);
    } else {
      $this->users->rolePermissionsSave($item);
    }
  }

}