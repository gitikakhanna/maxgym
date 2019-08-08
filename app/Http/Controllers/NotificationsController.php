<?php

namespace App\Http\Controllers;

use App\Notifications;
use Illuminate\Http\Request;
use App\Customers;
use App\Invoice;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function show(Notifications $notifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function edit(Notifications $notifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $customer, $cust_name, $id)
    {
        $fetchemail = Customers::where('id', $customer)->value('email');
        $package_months = '+'.$request->package.' month';
        Customers::where('id', $customer)->update([
            'joiningdate' => $request->joiningdate,
            'due_date' => date('Y-m-d', strtotime($package_months, strtotime($request->joiningdate))),
            'package' => $request->package_id,
            'updated_at' => now(),
        ]);

        Notifications::where('id', $id)->delete();

        Invoice::insert([
            'member_id' => $customer,
            'name' => $cust_name,
            'package_from' => $request->joiningdate,
            'package_till' => date('Y-m-d', strtotime($package_months, strtotime($request->joiningdate))),
            'duration' => $request->package,
            'amount_paid' => $request->price,
            'amount_due' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "averma382@gmail.com";
            $mail->Password = "averma382maxgym";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->setFrom('averma382@gmail.com', 'Amit Verma');
            $mail->addAddress($fetchemail, 'To');
            $mail->Subject = "MAX GYM-Membership Extended";
            $mail->Body = "Your membership is extended and will remain valid till ".date('d M Y', strtotime($package_months, strtotime($request->joiningdate))).". For queries please contact us at 9990777229, 9999909502.";
            $mail->send();
            echo "Message sent";
        }
        catch(Exception $e){
            echo "Message not sent";
        }
        
        $request->session()->flash('flashSuccess', 'Membership extended successfully.');    
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notifications  $notifications
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notifications $notifications)
    {
        //
    }
    
    public function delete($id)
    {
        
        Notifications::where('id', $id)->delete();
        return redirect()->back();
    }
}
