<?php
header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
class User { 
   public $id;
   public $email;
   public $password;

function __construct($id,$email,$password){
$this->id=$id;
$this->email=$email;
$this->password=$password;}
}
class User_qr {
   public $id;
   public $name;
   public $login;
public $password;
public $cash;
public $spend_cash;

function __construct($id,$name,$login,$password,$cash,$spend_cash){
$this->id=$id;
$this->name=$name;
$this->login=$login;
$this->password=$password;
$this->cash=$cash;
$this->spend_cash=$spend_cash;}
}
class Goods{
   public $id;
   public $name;
   public $price;
public $code;
   public $count;

function __construct($id,$name,$price,$code,$count){
$this->id=$id;
$this->name=$name;
$this->price=$price;
$this->code=$code;
$this->count=$count;}
}
class FinalResult{
public $users=array();
   public $good=array();
   

function __construct($users,$good){
$this->users=$users;
$this->good=$good;
}
}

class Product{
   public $identifier;
   public $name;
   public $price;

function __construct($identifier,$name,$price){
$this->identifier=$identifier;
$this->name=$name;
$this->price=$price;}
}

class Note {
   public $title;
  public  $content;
   public $lastChange;
public $noteid;

function __construct($title,$content,$lastChange,$noteid){
$this->title=$title;
$this->content=$content;
$this->lastChange=$lastChange;
$this->noteid=$noteid;}
}

class TransferPackage {
   public $packageId;
  public  $type;
  public  $date;
  public  $userId;
   public $notes=array();

function __construct($packageId,$type,$date,$userId,$notes){
$this->packageId=$packageId;
$this->type=$type;
$this->date=$date;
$this->userId=$userId;
$this->notes=$notes;}
}

class ApiController extends Controller
{
Const APPLICATION_ID = 'ASCCPE';
    private $format = 'json';
    public function filters()
    {
            return array();
    }
 
    // Actions

 public function actionFd()
    {

    if(isset($_POST['login'])and isset($_POST['password']))
        {$login = $_POST['login'];
	     $pass = md5($_POST['password']);

              $id = Yii::app()->db->createCommand()
                ->select('user_id')
                ->from('users')
                ->where("`username` = '".$login."' AND `password` = '".$pass."'")
				->QueryScalar();
	if (count('.$tid.')>0) {
	$connection = Yii::app()->db;

$arr= Yii::app()->db->createCommand()
                ->select('*')
                ->from('notes')
                ->where("`user_id` = '".$id."'")
				->queryAll();

$mas=[];
$tp=new TransferPackage;
foreach($arr as $k){
$titles=$k["title"];
$contents=$k["content"];
$lastChanges=$k["date"];
$noteid=$k["noteid"];

$n= new Note;
$n->__construct($titles,$contents,$lastChanges,$noteid);
$mas[]=$n;
}
$today = date("m.d.y"); 
$packageid=1;
$tp->__construct("$packageid","Enter",$today,$id,$mas);
$packageid++;


$this->_sendResponse(200, json_encode($tp,JSON_PRETTY_PRINT));					 }
	else{$this->_sendResponse(500, 'Error: Немає такого користувача' );}
		}else {
                        // Model not implemented error
                        $this->_sendResponse(500, 'Error: Щось не то з параметрами Л-П' );
                        Yii::app()->end();
           }

	}


public function actionfdqr()
       {// Check if id was submitted via GET
           
       if(isset($_POST['login'])and isset($_POST['password']))  
           {$login = $_POST['login'];
   	     $pass = md5($_POST['password']);
   		
$arr= Yii::app()->db->createCommand()
                ->select('id,name,cash')
                ->from('Users_QR')
                ->where("`login` = '".$login."' AND `password` = '".$pass."'")
				->queryAll();

           
$this->_sendResponse(200, json_encode($arr,JSON_PRETTY_PRINT));	
   	}else {                  
                           // Model not implemented error
                           $this->_sendResponse(500, 'Error: Щось не то з параметрами  add' );
                           Yii::app()->end();
              }
                                  
   	}

public function actionAdduserqr()
       {
           
       if(isset($_POST['login'])and isset($_POST['password'])and isset($_POST['name']))  
           {$login = $_POST['login'];
          $pass = md5($_POST['password']);
          $name = $_POST['name'];
        
     $connection = Yii::app()->db;
            $sql = "INSERT INTO `Users_QR` (`login`,`password`,`name`) 
        values ('".$login."','".$pass."','".$name."')";
            $command = $connection->createCommand($sql)->execute();
    $ok="Ви зареєстровані!!!";
            $this->_sendResponse(200,"$ok");
     }else {                  
                           // Model not implemented error
                           $this->_sendResponse(500, 'Error: Щось не то з параметрами  add' );
                           Yii::app()->end();
              }
                                  
     } 

  


 public function actionAdduser()
    {// Check if id was submitted via GET
        
    if(isset($_POST['login'])and isset($_POST['password']))  
        {$login = $_POST['login'];
	     $pass = md5($_POST['password']);
		 $token = microtime(true);
	$connection = Yii::app()->db;
         $sql = "INSERT INTO `users` (`username`,`password`,`token`) 
		 values ('".$login."','".$pass."','".$token."')";
         $command = $connection->createCommand($sql)->execute();
$ok="Ви зареєстровані!!!";
         $this->_sendResponse(200,"$ok");
	}else {                  
                        // Model not implemented error
                        $this->_sendResponse(500, 'Error: Щось не то з параметрами  add' );
                        Yii::app()->end();
           }
                               
	}  

 public function actionAddgoods()
    {// Check if id was submitted via GET
        
    if(isset($_POST['name'])and isset($_POST['price'])and isset($_POST['code'])and isset($_POST['count']))  
        {$name= $_POST['name'];
	     $price= $_POST['price'];
             $code= $_POST['code'];
	     $count= $_POST['count'];
		 
	$connection = Yii::app()->db;
         $sql = "INSERT INTO `Goods` (`name`,`price`,`code`,`count`) 
		 values ('".$name."','".$price."','".$code."','".$count."')";
         $command = $connection->createCommand($sql)->execute();
$ok="Товар додано!!!";
         $this->_sendResponse(200,"$ok");
	}else {                  
                        // Model not implemented error
                        $this->_sendResponse(500, 'Error: Щось не то з параметрами  add' );
                        Yii::app()->end();
           }
                               
	}  
public function actionFdadmin()
   {

   if(isset($_POST['login']))
       {

             
 if (count('.$tid.')>0) {
 $connection = Yii::app()->db;

 $user = Yii::app()->db->createCommand()
   ->select('*')
   ->from('Users_QR')
 ->QueryAll();

$usrm=[];
foreach($user as $k){
$id=$k["id"];
$name=$k["name"];
$login=$k["login"];
$password=$k["password"];
$cash=$k["cash"];
$spend_cash=$k["spend_cash"];
$User_qr=new User_qr;
$User_qr->__construct($id,$name,$login,$password,$cash,$spend_cash);
$usrm[]=$User_qr;
}

$goods=Yii::app()->db->createCommand()
  ->select('*')
  ->from('Goods')
->QueryAll();

$goodm=[];
foreach($goods as $k){
$id=$k["id"];
$name=$k["name"];
$price=$k["price"];
$code=$k["code"];
$count=$k["count"];
$Goods=new Goods;
$Goods->__construct($id,$name,$price,$code,$count);
$goodm[]=$Goods;
}

$FinalResult=new FinalResult;
$FinalResult->__construct($usrm,$goodm);





$this->_sendResponse(200, json_encode($FinalResult,JSON_PRETTY_PRINT));					 }
 else{$this->_sendResponse(500, 'Error: Немає такого користувача' );}
   }else {
                       // Model not implemented error
                       $this->_sendResponse(500, 'Error: Щось не то з параметрами Л-П' );
                       Yii::app()->end();
          }

 }

public function actionEditgoods()//-----------------------------------------------------
    {

    if(isset($_POST['id']) and isset($_POST['name']) and isset($_POST['price']) and isset($_POST['count']))
        {$id = $_POST['id'];
         $name = $_POST['name'];
	     $price = $_POST['price'];
	     $count = $_POST['count'];
	$connection = Yii::app()->db;
              $sql = "UPDATE `Goods` SET `name`='".$name."',`price`='".$price."', `count`='".$count."' WHERE `id`=".$id;
              $command = $connection->createCommand($sql)->execute();
              $this->_sendResponse(200,"Товар оновлено");
        }else {
                        // Model not implemented error
                        $this->_sendResponse(500, 'Error: Щось не то з параметрами EditGoods' );
                        Yii::app()->end();
           }

	}

public function actionDellgoods()//-----------------------------------------------------
{
  if(isset($_POST['id']))
      {$id= $_POST['id'];

$connection = Yii::app()->db;
       $sql = "DELETE FROM `Goods` WHERE `id` = '".$id."'";
       $command = $connection->createCommand($sql)->execute();
       $this->_sendResponse(200);
}else {
                      // Model not implemented error
                      $this->_sendResponse(500, 'Error: Щось не то з параметрами  Delldish' );
                      Yii::app()->end();
         }

}
    public function actionbuy()
                  {// Check if id was submitted via GET
                      
                  if(isset($_POST['id'])and isset($_POST['code'])) 
                      {$id = $_POST['id'];
                        $code=$_POST['code'];
              		
              
           
                  $user_cash = Yii::app()->db->createCommand()
                    ->select('cash')
                    ->from('Users_QR')
                    ->where("`id` = '".$id."'")
            ->QueryScalar();
      
            $goods_price=Yii::app()->db->createCommand()
              ->select('price')
              ->from('Goods')
              ->where("`code` = '".$code."'")
      ->QueryScalar();

      if($user_cash>=$goods_price){
        

        
        $goods_count=Yii::app()->db->createCommand()
          ->select('count')
          ->from('Goods')
          ->where("`code` = '".$code."'")
  ->QueryScalar();

  
  $goods_count++;

  
  $connection = Yii::app()->db;
              $sql = "UPDATE `Goods` SET `count`='".$goods_count."' WHERE `code`='".$code."'";
              $command = $connection->createCommand($sql)->execute();

    $update_cash=$user_cash-$goods_price;

  $connection1 = Yii::app()->db;
                $sql1 = "UPDATE `Users_QR` SET `cash`='".$update_cash."' WHERE `id`='".$id."'";
                $command1 = $connection1->createCommand($sql1)->execute();

                $spend_cash=Yii::app()->db->createCommand()
                  ->select('spend_cash')
                  ->from('Users_QR')
                  ->where("`id` = '".$id."'")
                ->QueryScalar();

    $update_spend_cash=$spend_cash+$goods_price;

$connection2 = Yii::app()->db;
                $sql2 = "UPDATE `Users_QR` SET `spend_cash`='".$update_spend_cash."' WHERE `id`='".$id."'";
                $command2 = $connection2->createCommand($sql2)->execute();

                $return=Yii::app()->db->createCommand()
                  ->select('*')
                  ->from('Goods')
                  ->where("`code` = '".$code."'")
           ->QueryAll();


$productm=[];
$Product=new Product;
foreach($return as $k){
$identifier=$k["code"];
$name=$k["name"];
$price=$k["price"];


$Product->__construct($identifier,$name,$price);
}


      
       
      }
      else {$return="Недостатньо коштів";}
                  
                     
              
                       $this->_sendResponse(200,json_encode($Product,JSON_PRETTY_PRINT));
              	}else {                  
                                      // Model not implemented error
                                      $this->_sendResponse(500, 'Error: Щось не то з параметрами  add' );
                                      Yii::app()->end();
                         }
                                             
              	}


  public function actionEditnote()//-----------------------------------------------------
    {

    if(isset($_POST['noteid']) and isset($_POST['title']) and isset($_POST['content']))
        {$noteid= $_POST['noteid'];
         $title= $_POST['title'];
	     $content= $_POST['content'];
$date=date("y.m.d");
	$connection = Yii::app()->db;
              $sql = "UPDATE `notes` SET `title`='".$title."',`content`='".$content."',`date`='".$date."' WHERE `noteid`='".$noteid."'";
              $command = $connection->createCommand($sql)->execute();
              $this->_sendResponse(200);
        }else {
                        // Model not implemented error
                        $this->_sendResponse(500, 'Error: Щось не то з параметрами Editdriver' );
                        Yii::app()->end();
           }

	} 

  public function actionDellnote()//-----------------------------------------------------
{
    if(isset($_POST['noteid']))
        {$noteid= $_POST['noteid'];

	$connection = Yii::app()->db;
         $sql = "DELETE FROM `notes` WHERE `noteid` = '".$noteid."'";
         $command = $connection->createCommand($sql)->execute();
         $this->_sendResponse(200);
	}else {
                        // Model not implemented error
                        $this->_sendResponse(500, 'Error: Щось не то з параметрами  Delldish' );
                        Yii::app()->end();
           }

	}

      


    
private function _sendResponse($status = 200, $body = '', $content_type = 'text/html; charset=utf-8')
{
    // set the status
    $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
    header($status_header);
    // and the content type
    header('Content-type: ' . $content_type);
 
    // pages with body are easy
    if($body != '')
    {
        // send the body
        echo $body;
    }
    // we need to create the body if none is passed
    else
    {
        // create some body messages
        $message = '';
 
        // this is purely optional, but makes the pages a little nicer to read
        // for your users.  Since you won't likely send a lot of different status codes,
        // this also shouldn't be too ponderous to maintain
        switch($status)
        {
            case 401:
                $message = 'You must be authorized to view this page.';
                break;
            case 404:
                $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                break;
            case 500:
                $message = 'The server encountered an error processing your request.';
                break;
            case 501:
                $message = 'The requested method is not implemented.';
                break;
        }
 
        // servers don't always have a signature turned on 
        // (this is an apache directive "ServerSignature On")
        $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];
 
        // this should be templated in a real-world solution
        $body = '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
</head>
<body>
    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
    <p>' . $message . '</p>
    <hr />
    <address>' . $signature . '</address>
</body>
</html>';
 
        echo $body;
    }
    Yii::app()->end();
}

private function _getStatusCodeMessage($status)
{
    // these could be stored in a .ini file and loaded
    // via parse_ini_file()... however, this will suffice
    // for an example
    $codes = Array(
        200 => 'OK',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
    );
    return (isset($codes[$status])) ? $codes[$status] : '';
}
}		
