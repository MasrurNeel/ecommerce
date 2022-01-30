<?php
namespace App\Controllers\Frontend;
use App\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Respect\Validation\Exceptions\ExecutableException;
use Respect\Validation\Validator;


class HomeController extends Controller {
     public function getIndex()
     {
         view('home');
     }
     public function getRegister()
     {
         view('register');
     }
     public function postRegister()
     {
         $validatior = new Validator();
         $errors = [];
         $username = $_POST['username'];
         $email = $_POST['email'];
         $password = $_POST['password'];
         $profile_photo = $_FILES['profile_photo'];
//validation
         if($validatior::alnum()->noWhitespace()->validate($username) === false){
            $errors['username'] = 'Username can only contain alphabets or numeric';
         }
         if(\strlen($username)<6){
             $errors['username'] = 'Username must have atleast 6 chars';
         }
         if($validatior::email()->validate($email) === false){
             $errors['email'] = 'Email must be a valid email address';
         }
         if(\strlen($password)<6){
             $errors['password'] = 'Password must be atleast 6 chars';
         }
          if($validatior::image()->validate($profile_photo['name'])){
              $errors['profile_photo'] = 'Profile photo must be an image file';
          }
         if(empty($errors)){
              //profile_photo upload
              $file_name = 'profile_photo_'.time();
              $extension =explode('.', $profile_photo['name']);
              $ext = end($extension);
              move_uploaded_file($profile_photo['tmp_name'],'media/profile_photo' . $file_name.'.'.$ext);
             $token = sha1($username.$email.uniqid('llc',true));

             User::create([
                 'username' => $username,
                 'email' => $email,
                 'password' => password_hash($password, PASSWORD_BCRYPT),
                 'profile|_photo' => $file_name.'.'.$ext,
                 'email_verification_token' => $token,
             ]);
             //send the mail
             $mail = new PHPMailer(true);
             try{
                 //$error settings
                 $mail->SMTPDebug = 2;
                 $mail->isSMTP();
                 $mail->Host = 'smtp.mailtrap.io';
                 $mail->SMTPAuth = true;
                 $mail->Username = 'da24cc67e9bb79';
                 $mail->Password = 'dc5778bc9b1351';
                 $mail->SMTPSecure = 'tls';
                 $mail->Port = 2525;
                 //Recipients
                 $mail->setFrom('mikum861@gmail.com', 'System User');
                 $mail->addAddress($email, $username);
                 //Content
                 $mail->isHTML(true);
                 $mail->Subject = 'Registration Successful';
                 $mail->Body = 'Dear '.$username.',</br>
      Please click the following link to activate your account</br>
      <a href="http://ecommerce.test/activate/'.$token.'">Click Here to Activate</a>
      <br/>-LLC Team';
                 $mail->send();
             }catch (Exception $e){
                echo 'Message could not be sent. Mailer Error:', $mail->ErrorInfo;
             }
             $_SESSION['success']='User registration successful';
             header('Location: /login');
             exit();
          }
         $_SESSION['errors']= $errors;
         header('Location: /register');
         exit();
     }
     public function getLogin()
     {
         view('login');
     }
    public function postLogin()
    {
        $validatior = new Validator();
        $errors = [];
        $email = $_POST['email'];
        $password = $_POST['password'];
//validation
        if($validatior::email()->validate($email) === false){
            $errors['email'] = 'Email must be a valid email address';
        }
        if(\strlen($password)<6){
            $errors['password'] = 'Password must be atleast 6 chars';
        }
        if(empty($errors)){
            $user = User::select(['id', 'password', 'email', 'username', 'email_verified_at'])->where('email', $email)->first();
            if($user){
                if($user->email_verified_at === null){
                    $errors[] = 'Your account is not verified';
                    $_SESSION['errors']= $errors;
                    header('Location: /login');
                    exit();
                }
                if(password_verify($password, $user->password) === true){
                    $_SESSION['success']= 'Logged in';
                    $_SESSION['users']= [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                        ];

                    header('Location: /dashboard');
                    exit();
                }
                $errors[] = 'Invalid credentials';
                $_SESSION['errors']= $errors;
                header('Location: /login');
                exit();
            }
            $errors[] = 'User not found';
            $_SESSION['errors']= $errors;
            header('Location: /login');
            exit();
        }
    }
    public function getActivate($token = '')
    {
        $errors = [];
        if(empty($token)){
            $errors[] = 'No token provided';
            $_SESSION['errors']= $errors;
            header('Location: /login');
            exit();
        }
        $user = User::where('email_verification_token', $token)->first();
        if($user){
            $user->update([
                'email_verified_at' => Carbon::now(),
                'email_verification_token' =>null,
            ]);
            $_SESSION['success']= 'Account activated. You can login now.';
            header('Location: /login');
            exit();
        }
        $errors[] = 'Invalid token provided';
        $_SESSION['errors']= $errors;
        header('Location: /login');
        exit();
    }
    public function getLogout()
    {
       unset($_SESSION['user']);

        $_SESSION['success']= 'You have been logged out.';
        header('Location: /login');
        exit();
    }

 }