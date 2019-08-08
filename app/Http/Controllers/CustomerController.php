<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $packages = DB::table('packages')->get();
        return view('customer', compact('packages'));
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

    protected function storeAction($data)
    {
        $package_months = '+'.$data->package.' month';
        $insertId = DB::table('customers')->insertGetId([
            'name' => $data->name,
            'dob' => $data->dob,
            'email' => $data->email,
            'address' => $data->address,
            'contact' => $data->contact,
            'gender' => $data->gender,
            'joiningdate' => $data->joining_date,
            'due_date' => date('Y-m-d', strtotime($package_months, strtotime($data->joining_date))),
            'package' => $data->package_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Invoice::insert([
            'member_id' => $insertId,
            'name' => $data->name,
            'package_from' => $data->joining_date,
            'package_till' => date('Y-m-d', strtotime($package_months, strtotime($data->joining_date))),
            'duration' => $data->package,
            'amount_paid' => $data->price,
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
            $mail->addAddress($data->email, 'To');
            $mail->Subject = "Welcome to MAX GYM - Enrolled for membership";
            $mail->Body = "Congratulations! Your membership starts today and will remain valid till ".date('d M Y', strtotime($package_months, strtotime($data->joining_date))).". For queries please contact us at 9990777229, 9999909502.";
            $mail->send();
            echo "Message sent";
        }
        catch(Exception $e){
            echo "Message not sent";
        }        
        

   }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'address' => 'required',
            'contact' => 'required|numeric',
            'package' => 'required|not_in:0',
            'gender' => 'required|not_in:0'
        ]);
        
        $this->storeAction($request);
        $request->session()->flash('flashSuccess', 'Membership added successfully.');    
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
