<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $mailAddress = '';
    protected $UserModel;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request , User $User)
    {
        $this->mailAddress = $request->input('email');
        $this->UserModel = $User;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 檢查 email是否存在
        $userinfo = $this->UserModel->where([
            ['email', '=', $this->mailAddress],
        ])->first();

        $myRandStr = $this->random_string(6, "123456789abcdefghijklmnpqrstuvwxyz");
        // 更新 id_password資料表驗證碼
        $userinfo->repassword = $myRandStr;
        $userinfo->save();

        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->CharSet = "UTF-8";
            $mail->SMTPDebug = 0;                        //Enable verbose debug output
            $mail->isSMTP();                             //Send using SMTP
            $mail->Host = 'smtp.gmail.com';              //Set the SMTP server to send through
            $mail->SMTPAuth = true;                      //Enable SMTP authentication
            $mail->Username = '信箱';     //SMTP username
            $mail->Password = '密碼';              //SMTP password
            $mail->SMTPSecure = 'tls';                   //Enable implicit TLS encryption
            $mail->Port = 587;                           //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->mailAddress, 'Bgreen運動家具,密碼驗證信件');
            $mail->addAddress($this->mailAddress, 'VIP');     //Add a recipient
            $mail->addReplyTo($this->mailAddress, 'Reset Password');

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Bgreen運動家具_密碼驗證信件';
            $mail->Body = "您的驗證碼: " . $myRandStr . "";
            $mail->send();
        } catch (Exception $e) {
        }
    }

    # 產生隨機字串的 PHP 函數
    public function random_string($length = 32, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if (!is_int($length) || $length < 0) {
            return false;
        }
        $characters_length = strlen($characters) - 1;
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, $characters_length)];
        }
        return $string;
    }
}
