<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
//require_once(ROOT . DS . 'vendor' . DS ."MailChimp.php");

class EmailComponent extends Component
{

    public static function getAdminEmail(array $fields)
    {
        $AdminsTable = TableRegistry::get('Admin.Admins');
		return $AdminsTable->find('all',['conditions'=>['Admins.type'=>'SA']])->first();
    }
    /**
     * [contactsAdmin function is for sending email to admin when someone submit contact form on the site]
     * @param  [type] $user_data [user submited data]
     * @param  [type] $settings  [website settings]
     * @return [type]            [true or false]
     */
    public function contactsAdmin($user_data, $settings){
        $admin_email = self::getAdminEmail(['mail_email','contact_email']);
		$email = new Email();
        $email->to(array($admin_email->contact_email));
        $email->subject('LearnerOn Contacts');
        $email->from(array($admin_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('contact_admin',Null);
        $email->viewVars(array('url'=>Router::url("/",true),'settings'=>$settings,'user_data'=>$user_data));
        if($email->send()){
            return true;
        }else{
            return false;
        }
    }
    /**
     * [newsletterSubscriptions function is for sending email to user after newsletter signup]
     * @param  [string] $user_email [user email]
     * @param  [array] $settings   [website settings]
     * @return [type]             [true or false]
     */
    public function newsletterSubscriptions($user_email, $settings)
    {
        $api_key = "8355d50813ef16722e53a6613eee8cf3-us15";                   
        $list_id = "a386debcfb";
        $name = "";
        $email = $user_email;
        $phone = "";
        $args=array("apikey" =>$api_key, "id" => $list_id, "email" => array("email" => $email));
        $MailChimp = new  \MailChimp($api_key);
        $result = $MailChimp->call("lists/subscribe",$args);
         if($result){
            return true;
        }else{
            return false;
        }
        /*$admin_email = self::getAdminEmail(['mail_email','contact_email']);
        $email = new Email();
        $email->to(array($user_email));
        $email->subject('LearnerOn Newsletter Subscriptions');
        $email->from(array($admin_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('newsletter_subscriptions_user',Null);
        $email->viewVars(array('url'=>Router::url("/",true),'settings'=>$settings));
        if($email->send()){
            return true;
        }else{
            return false;
        }*/
    }
    
    /**
     * [userRegister function is for sending an verification email after user register]
     * @param  [type] $user_email [user email]
     * @param  [type] $url        [verification url]
     * @param  [type] $user_data  [user data]
     * @param  [type] $settings   [website settings]
     * @return [type]             [description]
     */
    public static function userRegister($user_email, $url, $user_data, $settings){
        $form_email = self::getAdminEmail(['mail_email']);
        $email = new Email();
        $email->to(array($user_email));
        $email->subject('LearnerOn Account Verification');
        $email->from(array($form_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('user_verification',NULL);
        $email->viewVars(array('verify_url'=>$url, 'url'=>Router::url("/",true),'user_details' => $user_data,'settings'=>$settings));
        if($email->send()){
            return true;
        }else{
            return false;
        }

    }
    /**
     * [resetPassword sending link to user when password reset]
     * @param  [string] $user_email [user email id]
     * @param  [string] $url        [password reset url]
     * @param  [array] $settings   [website settings]
     * @return [type]             [true or false]
     */
    public static function resetPassword($user_email,$name, $url, $settings){
        $form_email = self::getAdminEmail(['mail_email']);
        $email = new Email();
        $email->to(array($user_email));
        $email->subject('LearnerOn Password Reset');
        $email->from(array($form_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');
        $email->template('reset_password',NULL);
        $email->viewVars(array('reset_url'=>$url, 'url'=>Router::url("/",true),'settings'=>$settings,'name'=>$name));
        if($email->send()){
            return true;
        }else{
            return false;
        }
    }

	//this function is for notify question submitter if new response is post
    public static function sendQuestionNotificationEmail($url, $settings, $question_title, $loggedin_user_data, $question_submitter_details, $notify_type){
		$form_email = self::getAdminEmail(['mail_email']);
        $email = new Email();
		if($question_submitter_details['notification_email'] != ''){
			$user_email = $question_submitter_details['notification_email'];
		}else{
			$user_email = $question_submitter_details['email'];
		}		
        $email->to(array($user_email));
        $email->subject('LearnerOn Notification Email');
        $email->from(array($form_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('question_notification_email',Null);
        $email->viewVars(array('question_url'=>$url, 'url'=>Router::url("/",true),'question_title'=>$question_title,'loggedin_user_data'=>$loggedin_user_data,'question_submitter_details'=>$question_submitter_details,'settings'=>$settings,'notify_type'=>$notify_type));
        if($email->send()){
            return true;
        }else{
            return false;
        }

    }
	
	//this function is for notify to all users in the same category during post question
    public static function sendPostQuestionNotificationEmailToAllUsers($to_user, $url, $settings, $question_title, $loggedin_user_data, $notify_type){
		$form_email = self::getAdminEmail(['mail_email']);
        $email = new Email();
		if($to_user['user']['notification_email'] != ''){
			$user_email = $to_user['user']['notification_email'];
		}else{
			$user_email = $to_user['user']['email'];
		}		
        $email->to(array($user_email));
        $email->subject('LearnerOn Notification Email');
        $email->from(array($form_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('post_question_notification_email',Null);
        $email->viewVars(array('to_user'=>$to_user, 'question_url'=>$url, 'url'=>Router::url("/",true),'question_title'=>$question_title,'loggedin_user_data'=>$loggedin_user_data,'question_submitter_details'=>$question_submitter_details,'settings'=>$settings,'notify_type'=>$notify_type));
        if($email->send()){
            return true;
        }else{
            return false;
        }

    }
	
	//this function is for notify to all users who wants news update
    public static function sendPostNewsCommentNotificationEmailToAllUsers($to_user, $url, $settings, $news_title, $loggedin_user_data){
		$form_email = self::getAdminEmail(['mail_email']);
        $email = new Email();
		if($to_user['user']['notification_email'] != ''){
			$user_email = $to_user['user']['notification_email'];
		}else{
			$user_email = $to_user['user']['email'];
		}		
        $email->to(array($user_email));
        $email->subject('LearnerOn Notification Email');
        $email->from(array($form_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('post_newscomment_notification_email',Null);
        $email->viewVars(array('to_user'=>$to_user, 'news_url'=>$url, 'url'=>Router::url("/",true),'news_title'=>$news_title,'loggedin_user_data'=>$loggedin_user_data,'settings'=>$settings));
        if($email->send()){
            return true;
        }else{
            return false;
        }

    }

}
