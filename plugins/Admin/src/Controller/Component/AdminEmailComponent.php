<?php
namespace Admin\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
require_once(ROOT . DS . 'vendor' . DS ."MailChimp.php");

/**
 * Component for all emails
 */
class AdminEmailComponent extends Component
{

    /**
     * Get the email from which the email will be sent from
     * @param  array  $fields fields to fetch from db
     * @return object data fetch from the db
     */
    public static function getAdminEmail(array $fields)
    {
        $Admin = TableRegistry::get('Admin.Admins');
        return $Admin->find()->select($fields)->where(['type' => 'SA'])->first();
    }
	
    public function replySubAdmin($userdata, $settings){
		$admin_email = self::getAdminEmail(['mail_email']);
        $email = new Email('default');
        $email->to(array($userdata['email']));
        $email->subject('LearnerOn Sub Admin Details');
        $email->from(array($admin_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('Admin.sub_admin_details',Null);
        $email->viewVars(array('siteurl_url'=>Router::url("/",true),'url'=>Router::url(['plugin' => 'admin', 'controller' => '/', 'action' => '/'],true),'settings'=>$settings,'userdata'=>$userdata));
        if($email->send()){
            return true;
        }else{
            return false;
        }
    }
	
	public function replyCustomer($user_email, $message, $settings){
        $admin_email = self::getAdminEmail(['mail_email']);
        $email = new Email('default');
        $email->to(array($user_email));
        $email->subject('LearnerOn Admin Reply');
        $email->from(array($admin_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('Admin.reply_contact',Null);
        $email->viewVars(array('url'=>Router::url("/",true),'settings'=>$settings,'message'=>$message));
        if($email->send()){
            return true;
        }else{
            return false;
        }
    }
	
	//Resend verification link to Customers
	public function resendToCustomer($user_email, $user, $url, $settings){
        $admin_email = self::getAdminEmail(['mail_email']);
        $email = new Email('default');
        $email->to(array($user_email));
        $email->subject('LearnerOn Account Verification');
        $email->from(array($admin_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');              
        $email->template('Admin.user_verification',Null);
        $email->viewVars(array('verify_url'=>$url, 'url'=>Router::url("/",true),'user_details' => $user,'settings'=>$settings));
        if($email->send()){
            return true;
        }else{
            return false;
        }
    }


    /**
     * resetPassword email for reset password
     * @param  string $to email id which will recieve the email
     * @return array email details
     */
    public static function resetPassword($user_email,$first_name, $url, $settings){
		$from_email = self::getAdminEmail(['mail_email']);
		$email = new Email('default');
        $email->to(array($user_email));
        $email->subject('LearnerOn Password Recovery Link');
        $email->from(array($from_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');
        $email->template('Admin.reset_password',NULL);
        $email->viewVars(array('reset_url'=>$url, 'url'=>Router::url("/",true),'settings'=>$settings,'first_name'=>$first_name));
        if($email->send()){
            return true;
        }else{
			return false;
        }
    }
	
	/**
     * questionEditNotification email sending update notification
    */
    public static function questionEditNotification($url,$user_email,$user_data,$data,$settings){
		$from_email = self::getAdminEmail(['mail_email']);
		$email = new Email('default');
        $email->to(array($user_email));
        $email->subject('LearnerOn Question Update Notification');
        $email->from(array($from_email->mail_email => WEBSITE_NAME));
        $email->emailFormat('html');
        $email->template('Admin.question_update',NULL);
        $email->viewVars(array('url'=>$url,'user_data'=>$user_data,'settings'=>$settings,'all_data'=>$data));
        if($email->send()){
            return true;
        }else{
			return false;
        }
    }

    public static function customerRegistration($url, $userDetails, $settings)
    {
        $email = self::getAdminEmail([]);
        $Email = new Email('default');
        return $Email->from([$email->mail_email => WEBSITE_NAME])
                ->to($userDetails['email'])
                ->subject('LearnerOn Verification')
                ->template('user_verification', null)
                ->emailFormat('html')
                ->viewVars(array('verify_url' => $url, 'url' => Router::url("/", true), 'user_details' => $userDetails, 'settings' => $settings))
                ->send();
    }
	
	public function replyQuestionSubmittedUser($url, $submitter_name, $email, $message, $settings){
		$from_email = self::getAdminEmail(['mail_email']);
        $Email = new Email('default');
        return $Email->from([$from_email->mail_email => WEBSITE_NAME])
                ->to($email)
                ->subject('LearnerOn Admin Reply')
                ->template('Admin.reply_question_submitted_user', null)
                ->emailFormat('html')
                ->viewVars(array('url' => $url, 'message' => $message, 'settings' => $settings))
                ->send();
    }
	
	public function replyNewsCommentSubmittedUser($url, $submitter_name, $email, $message, $settings){
		$from_email = self::getAdminEmail(['mail_email']);
        $Email = new Email('default');
        return $Email->from([$from_email->mail_email => WEBSITE_NAME])
                ->to($email)
                ->subject('LearnerOn Admin Reply')
                ->template('Admin.reply_news_comment_submitted_user', null)
                ->emailFormat('html')
                ->viewVars(array('url' => $url, 'message' => $message, 'settings' => $settings))
                ->send();
    }
	
	//this function is for notify to all users who wants news update
    public function sendPostNewsNotificationEmailToAllUsers($to_user, $url, $settings, $news_title, $user_email){
		$from_email = self::getAdminEmail(['mail_email']);
        $Email = new Email('default');
		return $Email->from([$from_email->mail_email => WEBSITE_NAME])
                ->to($user_email)
                ->subject('LearnerOn News Post Notification')
                ->template('Admin.reply_news_post_notification', null)
                ->emailFormat('html')
                ->viewVars(array('url' => $url, 'to_user' => $to_user, 'news_title' => $news_title, 'settings' => $settings))
                ->send();
    }
}
