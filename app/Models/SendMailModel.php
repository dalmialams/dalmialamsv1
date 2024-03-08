<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use App\Models\Role\Role;
use Mail;

use PHPMailer\PHPMailer\src\PHPMailer;
use PHPMailer\PHPMailer\src\SMTP;
use PHPMailer\PHPMailer\src\Exception;
  

require('PHPMailer\PHPMailer\src\PHPMailer.php');
require('PHPMailer\PHPMailer\src\SMTP.php');
require('PHPMailer\PHPMailer\src\Exception.php');

class SendMailModel extends BaseModel {

    public function __construct() {
        parent:: __construct();
    }

   /*  public function sendWelcomeEmail($user_id, $new_password) {
        $user = User\UserModel::where(['id' => $user_id])->get()->toArray();
        $this->data['user'] = isset($user[0]) ? $user[0] : '';
        $this->data['password'] = $new_password;
        Mail::send('admin.emails.welcome', $this->data, function ($m) use ($user) {
            $email = $this->data['user']['user_name'];
            $m->from('admin@landmgmt.dalmiabharat.com', 'Dalmia Lams');
            $m->to($email, '')->subject('Welcome to Dalmia::Lams!');
        });
    } */
	public function sendWelcomeEmail($user_id, $new_password) {
        $user = User\UserModel::where(['id' => $user_id])->get()->toArray();
        $this->data['user'] = isset($user[0]) ? $user[0] : '';
        $this->data['password'] = $new_password;
        $email = $this->data['user']['user_name'];
		$subject ="Welcome to Dalmia::Lams!";
		$role =Role::where(['id' => $this->data['user']['role_id']])->value('display_name');
		$message ="<div ><div> <img alt='' src='http://123.63.224.20/dalmia-lams/assets/img/left_logo.png' alt='' /> </div><div style=' padding: 10px;border: 1px solid #ccc; color: #111;white-space: normal;line-height: 18px;'>  <div style='color: #111;font-size:18px; font-weight:300; margin-bottom:15px;'>Hello,</div>  <p>Welcome to Dalmia</p><p>You have been registered as a <strong>";
		$message .=$role."</strong> level user</p> <p>Please find your login credentials</p><p><strong>User Name:</strong> ";
		$message .=$this->data['user']['user_name']."</p> <p><strong>Password:</strong>$new_password</p></div><div style='background: #4c609d; padding: 10px;text-align:center;color:#fff;'> &copy; Dalmia::Lams ".date('Y')." </div></div>";
		
		//$message = 'Text Message';
		
		 $str = '"D:\\sendmail\\senditquiet\\senditquiet" -s smtp.dalmiabhart.com -port 25 -u landmgmt@dalmiabharat.com -p Dalmia@2020 -f landmgmt@dalmiabharat.com -t '.$email.' -subject "'.$subject.'" -body "'.$message.'"';
		exec($str, $op, $ret);
		

		if($ret == 0)			
			return true;		
		else
			return false;
    }

    /* public function sendForgotPasswordEmail($user_id, $link) {
        $user = User\UserModel::where(['id' => $user_id])->get()->toArray();
        
        $this->data['user'] = isset($user[0]) ? $user[0] : '';
        $this->data['link'] = $link;
        //$email=$this->data['user']['user_name'];
        Mail::send('admin.emails.forgot_pwd', $this->data, function ($m) use ($user) {
            $email=$user[0]['user_name'];
            $email = ($email == 'admin') ? 'admin@dalmia.com' : $this->data['user']['user_name'];
			//$email = 'tanmay.kundu@cyber-swift.com';
            $m->from('admin@landmgmt.dalmiabharat.com', 'Dalmia Lams');
            $m->to($email, $user[0]['user_name'])->subject('Forgot Password Link');
        });
    } */	
	public function sendForgotPasswordEmail($user_id, $link) {
        $user = User\UserModel::where(['id' => $user_id])->get()->toArray();
        $this->data['user'] = isset($user[0]) ? $user[0] : '';
        $this->data['link'] = $link;
        //$email=$this->data['user']['user_name'];
        $email=$user[0]['user_name'];
		 //$message =( view('admin.emails.forgot_pwd', $this->data)); 
		$message ="<div><div >Hello,</div><p>Please click on the following link to reset your password.</p><p><strong><a href='".URL($link)."'>". URL($link) ."</a></strong></p></div>"."<br><div style='background: #4c609d; padding: 10px;text-align:center;color:#fff;'> &copy; Dalmia::Lams ".date('Y')." </div>";
		
		//$message = 'Text Message';
		$subject = 'Forgot Password Link';
		//$str = '"D:\\sendmail\\senditquiet\\senditquiet" -s smtp.dalmiabharat.com -port 25 -u landmgmt@dalmiabharat.com -p Dalmia@2020 -f landmgmt@dalmiabharat.com -t '.$email.' -subject "'.$subject.'" -body "'.$message.'"';
		//echo $str;
		//exec($str, $op, $ret);
		$this->passwordEmailer($link,$email);

	/*	if($ret == 0)			
			return true;		
		else
			return false;*/
    }
	
	public function passwordEmailer($link,$email){
		
		$mail = new PHPMailer(true);
		  
		try {
			$mail->SMTPDebug = 2;                                       
			$mail->isSMTP();   
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);				
			$mail->Host       = 'smtp.dalmiabharat.com';                    
			//$mail->SMTPAuth   = true;                             
			$mail->Username   =  'landmgmt@dalmiabharat.com';
			$mail->Password   = 'Dalmia@2020';                        
			$mail->SMTPSecure = 'tls';                              
			$mail->Port       = 25;  
		  
			$mail->setFrom('landmgmt@dalmiabharat.com', 'Land Management System');           
			$mail->addAddress($email,'');
			//$mail->addBcc('fenil.shah@emergingfive.com');
			   
			$mail->isHTML(true);                                  
			$mail->Subject = 'Forgot Password Link';
			$mail->Body    = "<div><div >Hello,</div><p>Please click on the following link to reset your password.</p><p><strong><a href='".URL($link)."'>". URL($link) ."</a></strong></p></div>"."<br><div style='background: #4c609d; padding: 10px;text-align:center;color:#fff;'> &copy; Dalmia::Lams ".date('Y')." </div>";
		//	$mail->AltBody = 'Body in plain text for non-HTML mail clients';
			$mail->send();
			//echo "Mail has been sent successfully!";
		} catch (Exception $e) {
			//echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
  

	}
}
