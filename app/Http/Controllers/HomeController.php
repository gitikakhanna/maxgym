<?php

namespace App\Http\Controllers;

// use Twilio\Rest\Client;
use App\Customers;
use App\Notifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Packages;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyMail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customers::where('due_date', '<', Carbon::now()->format('Y-m-d'))->get();
        // dd(Carbon::now());
        if(count($customers))
        {
            foreach($customers as $key=>$customer){
                $overdue_customers = DB::table('notifications')->where('customer_id', $customer->id)->get();
                if(!count($overdue_customers)){
                    DB::table('notifications')->insert([
                        'customer_id' => $customer->id,
                        'customer_name' => $customer->name,
                        'package_id' => $customer->package,
                        'due_date' => $customer->due_date,
                        'action' => '0',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                            $mail = new PHPMailer(true);
                        
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPAuth = true;
                            $mail->Username = "averma382@gmail.com";
                            $mail->Password = "averma382maxgym";
                            $mail->SMTPSecure = "tls";
                            $mail->Port = 587;
                            $mail->setFrom('averma382@gmail.com', 'Amit Verma');
                            $mail->addAddress($customer->email, 'To');
                            $mail->Subject = "Max Gym - Membership Expired";
                            $mail->Body = "Your membership ends on ".date('d M Y', strtotime($customer->due_date)).". In order to continue renew today. For queries please contact us at 9990777229, 9999909502.";
                            $mail->send();
                        
                }
            }
        }

        $notifications = Notifications::where('action', '0')->orderBy('created_at', 'des')->get();
        $packages = Packages::all();
        $members = Customers::all();
        $joining_members = Customers::where('created_at', 'like', date('Y-m-%'))->get();
        $expiring_members = Customers::where('due_date', 'like', date('Y-m-%'))->where('due_date', '>', Carbon::now()->format('Y-m-d'))->get();
        
    //         // Account details
    // $apiKey = urlencode('G1iY5K7ywI0-iz0mdXpJO9tmeForcfCiAvz4mqhuqQ');
    
    // // Message details
    // $numbers = array(919711950845);
    // $sender = urlencode('TXTLCL');
    // $message = rawurlencode('hola! ritika khanna');
 
    // $numbers = implode(',', $numbers);
 
    // // Prepare data for POST request
    // $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
    // // Send the POST request with cURL
    // $ch = curl_init('https://api.textlocal.in/send/');
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    // $response = curl_exec($ch);
    // curl_close($ch);

        return view('home', compact('notifications', 'packages', 'members', 'joining_members', 'expiring_members'));
    }

    public function sendmail()
    {
        $comment = 'Hi, this is a test mail';
        $toEmail = "gitikakhanna392@gmail.com";
        Mail::to($toEmail)->send(new NotifyMail($comment));

        return 'Email has been sent';
    }

}
