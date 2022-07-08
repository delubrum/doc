<?php
class Purchases {
    private $pdo;
    public function __CONSTRUCT() {
        try {
            $this->pdo = Database::Conectar();
            $pdo = null;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function list($filters) {
        try {
            $purchases = $this->purchasesList($filters);
            foreach($purchases as $k => $v) {
                $purchases[$k] = 'x';
            }
            return $purchases;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function purchasesList($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.name as projectName, b.pmId, c.username as username, d.username as pmName, e.username as quoter
            FROM purchases a
            LEFT JOIN projects b 
            ON a.projectId = b.id
            LEFT JOIN users c
            ON a.userId = c.id
            LEFT JOIN users d
            ON b.pmId = d.id
            LEFT JOIN users e
            ON a.quoterId = e.id
            WHERE 1=1
            $filters
            ORDER BY a.id DESC
            ");
            $stm->execute(array());
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function ItemsList($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*
            FROM purchase_items a
            LEFT JOIN purchases b
            on a.purchaseId = b.id
            WHERE 1=1
            $filters
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function purchaseSave($item) {
        try {
            $sql = "INSERT INTO purchases (type,projectId,deliveryPlace,requestDate,userId) VALUES (?,?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->type,
                    $item->projectId,
                    $item->deliveryPlace,
                    $item->requestDate,
                    $item->userId
                )
            );
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function purchaseItemSave($item) {
        try {
            $sql = "INSERT INTO purchase_items (purchaseId,material,qty,notes) VALUES (?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->purchaseId,
                    $item->name,
                    $item->qty,
                    $item->notes
                )
            );
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.name as projectName, b.pmId, c.username as username, d.username as pmName , e.username as quotername, b.approvedBy
            FROM `purchases` a
            LEFT JOIN projects b 
            ON a.projectId = b.id
            LEFT JOIN users c
            ON a.userId = c.id
            LEFT JOIN users d
            ON b.pmId = d.id
            LEFT JOIN users e
            ON a.quoterId = e.id
            WHERE a.id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemGet($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, c.name as projectname, d.username as username, e.username as pmname
            FROM purchase_items a
            LEFT JOIN purchases b 
            ON a.purchaseId = b.id
            LEFT JOIN projects c
            ON b.projectId = c.id
            LEFT JOIN users d
            ON b.userId = d.id
            LEFT JOIN users e
            ON c.pmId = e.id
            WHERE a.id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function vendorGet($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM purchase_vendors
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function purchasesItemsList($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM purchase_items
            WHERE purchaseId = ? 
            ORDER BY id ASC");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function reportList() {
        try {
            $stm = $this->pdo->prepare("SELECT b.id, c.username as User, d.username as Quoter, b.createdAt as Date, e.name as Project, 
            a.material as Description, a.qty as Qty, f.vendor as Vendor, b.purchasedAt as PurchaseDate, a.purchaseOrder as PO, f.price as Price, (f.price*a.qty) as Total,
            f.date as VendorDate, b.receivedAt as ReceiveDate,
            (CASE 
                WHEN b.cancelledAt IS NOT NULL THEN 'Cancelled'
                WHEN b.approvedAt IS NOT NULL and b.purchasedAt IS  NULL THEN 'Purchasing'
                WHEN b.receivedAt IS NOT NULL THEN 'Closed'
                WHEN b.purchasedAt IS NOT NULL and b.receivedAt IS  NULL THEN 'Receiving'
                WHEN b.quoterId IS NOT NULL and b.quotedAt IS NULL THEN 'Pricing'
                WHEN b.quotedAt IS NOT NULL and b.approvedPMAt IS NULL IS  NULL THEN 'PM Approval'
                WHEN b.approvedPMAt IS NOT NULL and b.approvedAt IS NULL IS  NULL THEN 'CEO Approval'
                ELSE 'Process'
            END) AS Status
            FROM purchase_items a
            LEFT JOIN purchases b
            ON a.purchaseId = b.id
            LEFT JOIN users c
            ON b.userId = c.id
            LEFT JOIN users d
            ON b.quoterId = d.id
            LEFT JOIN projects e
            ON b.projectId = e.id
            LEFT JOIN purchase_vendors f
            ON a.id = f.itemId
            WHERE f.suggestedAt is not null
            ORDER BY a.id ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemVendorsList($id,$filters = '')
    {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM purchase_vendors
            WHERE itemId = ?
            $filters
            ORDER BY id ASC");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateField($id,$field) {
        try {
            $sql = "UPDATE purchases SET $field=now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function purchaseReceivedBy($id,$userId) {
        try {
            $sql = "UPDATE purchases SET receivedBy=? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($userId,$id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function rejectPurchaseApproval($id) {
        try {
            $sql = "UPDATE purchases SET quotedAt = null, approvedPMAt = null, approvedAt = null WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function rejectPurchaseQuote($id) {
        try {
            $sql = "UPDATE purchases SET sentAt = null WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function purchaseAssignUser($item) {
        try {
            $sql = "UPDATE purchases SET quoterId= ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(                
                array(
                    $item->userId,
                    $item->purchaseId
            )
        );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemOrderSave($item) {
        try {
            $sql = "UPDATE purchase_items SET purchaseOrder	= ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(                
                array(
                    $item->order,
                    $item->id
            )
        );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function itemDaysSave($item) {
        try {
            $sql = "UPDATE purchase_items SET days= ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(                
                array(
                    $item->days,
                    $item->id
            )
        );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemNotesSave($item) {
        try {
            $sql = "UPDATE purchase_items SET notes	= ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(                
                array(
                    $item->notes,
                    $item->id
            )
        );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function PurchaseInfoSave($item) {
        try {
            $sql = "UPDATE purchases SET deliveryPlace	= ?, requestDate = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(                
                array(
                    $item->delivery,
                    $item->date,
                    $item->id
            )
        );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemVendorSave($item) {
        try {
            $sql = "INSERT INTO purchase_vendors (purchaseId,itemId,vendor,price,qty,notes,date) VALUES (?,?,?,?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->purchaseId,
                    $item->itemId,
                    $item->vendor,
                    $item->price,
                    $item->qty,
                    $item->notes,
                    $item->date
                )
            );
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function itemFieldUpdate($id,$field) {
        try {
            $sql = "UPDATE purchase_items SET $field=now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function vendorCheck($item) {
        try {
            $sql = "UPDATE purchase_vendors SET suggestedAt = null WHERE itemId = ?";
            $this->pdo->prepare($sql)->execute(array($item->itemId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $sql = "UPDATE purchase_vendors SET suggestedAt = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($item->vendorId));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function totalPrice($id) {
        try {
            $stm = $this->pdo->prepare("select sum(qty*price) as total
            FROM purchase_vendors
            WHERE purchaseId= ?
            AND suggestedAt is not null
            ");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemPrice($id) {
        try {
            $stm = $this->pdo->prepare("select sum(qty*price) as total
            FROM purchase_vendors
            WHERE itemId= ?
            AND suggestedAt is not null
            ");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemDelete($id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM purchase_items WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        try {
            $stm = $this->pdo->prepare("DELETE FROM purchase_vendors WHERE itemId = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function vendorDelete($id) {
        try {
            $stm = $this->pdo->prepare("DELETE FROM purchase_vendors WHERE id = ?");
            $stm->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function alertCheck($id) {
        try {
            $sql = "UPDATE purchases SET alertCheck = 1 WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function alertCheckItem($id) {
        try {
            $sql = "UPDATE purchase_items SET alertCheck = 1 WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function alertCheckItemPM($id) {
        try {
            $sql = "UPDATE purchase_items SET alertCheckPM = 1 WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function daily($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT DATE(sentAt) as date, COUNT(*) as total
            FROM purchases
            WHERE sentAt is not null
            $filters
            GROUP BY DATE(date)
            ORDER BY sentAt
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemDaily($filters) {
        try {
            $stm = $this->pdo->prepare("SELECT DATE(sentAt) as date, COUNT(*) as total
            FROM purchase_items a
            LEFT JOIN purchases b
            ON a.purchaseId = b.id
            WHERE 1=1
            $filters
            GROUP BY DATE(date)
            ORDER BY date
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function pendingDaily($date) {
        try {
            $stm = $this->pdo->prepare("SELECT sum(services+materials) as total
            FROM purchase_pending
            WHERE createdAt >= '$date'
            AND createdAt <= '$date 23:59:59'
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function monthly($year) {
        try {
            $stm = $this->pdo->prepare("SELECT count(*) as total, DATE_FORMAT(sentAt, '%b') as date
            FROM purchases
            WHERE year(sentAt) = ?
            GROUP BY DATE_FORMAT(sentAt, '%b')
            ");
            $stm->execute(array($year));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function itemMonthly($year) {
        try {
            $stm = $this->pdo->prepare("SELECT count(*) as total, DATE_FORMAT(b.sentAt, '%b') as date
            FROM purchase_items a
            LEFT JOIN purchases b
            ON a.purchaseId = b.id
            WHERE year(b.sentAt) = ?
            GROUP BY DATE_FORMAT(b.sentAt, '%b')
            ");
            $stm->execute(array($year));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function pendingMonthly($year) {
        try {
            $stm = $this->pdo->prepare("SELECT sum(services+materials) as total, DATE_FORMAT(createdAt, '%b') as date
            FROM purchase_pending
            WHERE year(createdAt) = ?
            GROUP BY DATE_FORMAT(createdAt, '%b')
            ");
            $stm->execute(array($year));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function total() {
        try {
            $stm = $this->pdo->prepare("SELECT count(*) as total
            FROM purchases
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function pendingSave($type,$services,$materials) {
        try {
            $sql = "INSERT INTO purchase_pending (type,services,materials) VALUES (
                    '$type',
                    '$services',
                    '$materials'
            )";
			$this->pdo->prepare($sql)->execute();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function deliverSum($id){
        try {
            $stm = $this->pdo->prepare("SELECT SUM(qty) as total FROM purchase_delivers where itemId = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deliverList($id,$filters) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username
            FROM purchase_delivers a
            LEFT JOIN users b
            ON a.userId = b.id
            WHERE itemId = ?
            $filters
            ORDER BY id ASC
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deliverSave($item) {
        try {
            $sql = "INSERT INTO purchase_delivers (itemId,notes,qty,userId) VALUES (
                '$item->itemId',
                '$item->notes',
                '$item->qty',
                '$item->userId'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function updateDeliverField($id,$field) {
        try {
            $sql = "UPDATE purchase_delivers SET $field = now() WHERE id = ?";
            $this->pdo->prepare($sql)->execute(array($id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deliverListPurchases($id) {
        try {
            $stm = $this->pdo->prepare("SELECT a.*, b.username
            FROM purchase_delivers a
            LEFT JOIN users b
            ON a.userId = b.id
            LEFT JOIN purchase_items d
            ON a.itemId = d.id
            WHERE d.purchaseId = ?
            ORDER BY id ASC
            ");
            $stm->execute(array($id));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function saveData($item) {
        try {
            $sql = "INSERT INTO purchases_data (id,description) VALUES (
                '$item->id',
                '$item->description'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function deleteData(){
        try {
            $stm = $this->pdo->prepare("TRUNCATE purchases_data");
            $stm->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getAvailable(){
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM purchases_data 
            WHERE id <> 0
            GROUP BY id
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function controlUpdate($item) {
        try {
            $sql = "UPDATE purchases SET 
            quoterId = '$item->user' 
            WHERE 
            id = '$item->purchase'
            ";
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function quoterItems($type,$id) {
        try {
            $sql = "SELECT a.id FROM purchase_items a
            LEFT JOIN purchases b
            on a.purchaseId = b.id
            WHERE quotedAt is null
            AND type = ?
            AND quoterId = ?
            ";
            $this->pdo->prepare($sql)->execute(array($type,$id));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getQuoterId() {
        try {
            $stm = $this->pdo->prepare("SELECT quoterId FROM purchase_items a
            LEFT JOIN purchases b
            on a.purchaseId = b.id
            LEFT JOIN users c
            on b.quoterId = c.id
            WHERE quotedAt is null
            AND quoterId is not null
            AND cancelledAt is null 
            AND sentAt is not null 
            AND c.password is not null
            GROUP BY quoterId
            ORDER BY count(a.id)
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function codeSave($name,$user) {
        try {
            $sql = "INSERT INTO purchases_codes (name,userId) VALUES (
                '$name',
                '$user'
            )";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function codeGet($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM purchases_codes
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function codeUpdate($item) {
        try {
            $sql = "UPDATE purchases_codes SET
            code = '$item->code',
            description = '$item->description',
            updatedAt = now()
            WHERE id = '$item->id'
            ";
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function codeCheck($id) {
        try {
            $sql = "UPDATE purchases_codes SET alert = 1 WHERE id = '$id'";
            $this->pdo->prepare($sql)->execute();
            return $sql;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    

    

    

}