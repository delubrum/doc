<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Init {
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

    public function navTitleList() {
        try {
            $stm = $this->pdo->prepare("SELECT DISTINCT id, title, c, icon
            FROM permissions
            WHERE type = 'menu'
            GROUP BY title
            ORDER BY sortm ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function permission($id) {
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

    public function navSubtitleList($title) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE type = 'menu'
            AND title = ?
            ORDER BY sort ASC");
            $stm->execute(array($title));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function redirect() {
        header("location: 403.php");
        //header('Location: ?c=Login&a=Index');
    }

    public function alert($fields,$table,$filters) {
        try {
            $stm = $this->pdo->prepare("SELECT $fields
            FROM $table
            WHERE 1=1
            $filters
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function rejectCause($item) {
        try {
            $sql = "INSERT INTO rejectCauses (type,itemId,cause,userId) VALUES (?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->type,
                    $item->itemId,
                    $item->cause,
                    $item->userId
                )
            );
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function rejectList($type,$itemId) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username
            FROM rejectCauses a
            LEFT JOIN users b
            ON a.userId = b.id
            WHERE type = ?
            AND itemId = ?
            ");
            $stm->execute(array($type,$itemId));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function toExcel($rows,$filename){
        $doc = new Spreadsheet();
        $doc
        ->getProperties()
        ->setCreator("Sigma")
        ->setLastModifiedBy('Sigma')
        ->setTitle($filename)
        ->setDescription($filename);

        $sheet = $doc->getActiveSheet();
        $sheet->setTitle("Report");
        $header = array();
        if(!empty($rows)){
            $firstRow = $rows[0];
            foreach($firstRow as $colName => $val){
                $header[] = $colName;
            }
        }
        $sheet->fromArray($header, null, 'A1');
        $i = 2;
        foreach ($rows as $r) {
            $x = "A$i";
            $sheet->fromArray((array) $r, null, $x);
            $i++;
        }
               
        $writer = new Xlsx($doc);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
        $writer->save('php://output');
    }

    public function reject($table,$query) {
        try {
            $sql = "UPDATE $table SET $query";
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function sendEmail($item) {
        date_default_timezone_set('America/Bogota');
        //Load Composer's autoloader
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable('/var/www/html/sigma/'); $dotenv->load();
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = "smtp.office365.com";
        $mail->Port = 587;
        $mail->SMTPSecure = "starttls";
        $mail->SMTPAuth   = true;
        $mail->SMTPDebug = 0;
        //$mail->Username = $item->email;
        // $IV = getenv('IV');
        // $KEY = getenv('KEY');
        // $ciphering = getenv('CIPHERING');
        // $decryption=openssl_decrypt($item->pass, $ciphering, $KEY, 0 , $IV);
        //$mail->Password = $decryption;
        $mail->Username = "sigmareport@es-metals.com";
        $mail->Password = "Esmetals2022*";
        $mail->setFrom("sigmareport@es-metals.com");
        $mail->addReplyTo($item->email, 'EsMetals');
        $mail->AddBCC($item->email);
        foreach($item->to as $r) {
            $mail->addAddress($r);
        }
        $mail->AddEmbeddedImage("assets/img/logo.png", 'scope');
        $mail->Subject = "$item->subject";

        $msg = "<div style='width:90%;border-radius:10px;background:white;color:black;font-size:14px;font-family:Century Gothic;padding:30px;text-align:justify'>
                <br>
                Greetings!
                <br><br>
                $item->body
                ";
        $msg .= "
                <br><br>
                Should you have any questions please do not hesitate to contact The ES Metals team.
                <br><br>
                <br>
                <div style='font-size:10px;text-align:justify'>
                The information contained in this electronic mail transmission is intended by ES Metals solely for the use of the named individual or entity to which it is directed, and may contain information that is confidential, privileged or otherwise protected by law, including by applicable copyright or other laws protecting intellectual property or trade secrets. If you are not the individual or entity to whom this electronic mail transmission is directed, or otherwise have reason to believe that you received this electronic mail transmission in error, please delete it from your system without copying or forwarding it, and notify the sender by reply email, so that the intended recipient's address can be corrected.
                </div>";
        $mail->msgHTML($msg);
        $mail->AltBody = "$item->body";
        if (!$mail->send()) {
            return "Email Failed";
        } else {
            try {
                $sql = "INSERT INTO email_log (itemId,type,emails,subject,body) VALUES (?,?,?,?,?)";
                $this->pdo->prepare($sql)->execute(array($item->id,$item->type, json_encode($item->to), $item->subject, $item->body));
            } catch (Exception $e) {
                die($e->getMessage());
            }
            return json_encode($item->to);
        }
    }

    public function indicator($id) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM indicators
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

}