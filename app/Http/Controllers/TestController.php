<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // require 'vendor/autoload.php';
        $mail = new PHPMailer(true);
        try{
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $message = file_get_contents('https://max-gym-site.000webhostapp.com/test.html'); 
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "gitikakhanna392@gmail.com";
            $mail->Password = "messimission1011";
            $mail->SMTPSecure = "tls";
            $mail->Port = 587;
            $mail->setFrom('gitikakhanna392@gmail.com', 'Gitika Khanna');
            $mail->addAddress('archit_150@yahoo.co.in', 'To');
            $mail->Subject = "Message chl gyaa";
            // $mail->Body = "Welcome to max gym";
            $mail->MsgHTML($message);
            $mail->IsHTML(true); 
            $mail->CharSet="utf-8";
            // $mail->SMTPOptions = array(
            //     'ssl' => array(
            //         'verify_peer' => false,
            //         'verify_peer_name' => false,
            //         'allow_self_signed' => true
            //     )
            // );
            $mail->send();
            echo "Message sent";
        }
        catch(Exception $e){
            echo "Message not sent";
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('test');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
