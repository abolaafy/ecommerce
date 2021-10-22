<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Slider;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use stdClass;
use DB;
use  App\Events\NewOrder;
use Illuminate\Support\Facades\Auth;

class rafeh
{}
class PaymentController extends Controller
{
    private $apiURL;
    private $request_client;
    private $token;

    public function __construct()
    {
        $this ->token ="rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";
        $this -> apiURL = 'https://apitest.myfatoorah.com';

    }
    public function index($amount)
    {

        $sliders = Slider:: get ();
        return view('site.cart.payments', compact('amount' ,'sliders'));
    }
    public function pay_fatoorah(Request $q)
    {

        $q->validate(['ccNum' => 'required',  'name_card' => 'required',  'ccExp' => 'required'  ,    'ccCvv' => 'required|numeric',
        'amount' => 'required|numeric|min:100',],['required' => 'هذا الحقل مطلوب ',
        'min' => 'هذا الحقل يجب الا يقل عن حرفان',     'max' => 'هذا الحقل يجب الا يزيد عن 100 حرف',   'numeric' => 'هذا الحقل يجب ان يكوةةن رقم' ]);

        $ccNum = str_replace(' ','' ,$q-> ccNum);
        $name_card = str_replace(' ','' ,$q-> name_card);
        $ccExp = $q-> ccExp;
        $ccCvv = $q-> ccCvv;
        $amount = $q-> amount;
        $customerName = auth()->user()->name;
        $customerEmail = 'abolaafTest@gmail.com';
        $customerMobile = strlen (auth()->user()->mobile) <= 11 ?auth()->user()->mobile: '123456';
        $ccExp = (explode('/',$ccExp ));
        $ccMonth = $ccExp [0];
        $ccYear = $ccExp [1];
        $data['language'] = 'en';
        $PaymentMethodId = $q ->PaymentMethodId;
        $token = $this ->token;
        $apiURL = $this ->apiURL;
        $curl = curl_init();

        curl_setopt_array($curl,
        [
            CURLOPT_URL => "$apiURL/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => "{'PaymentMethodId':'$PaymentMethodId','CustomerName':'$customerName','DisplayCurrencyIso':'SAR' ,'MobileCountryCode':'020','CustomerMobile':'$customerMobile',
            'InvoiceValue':'$amount' ,'CallBackUrl': 'https://dieera.com','ErrorUrl':'https://dieera.com','Language':'en','CustomerReference':'ref 1','CustomerCivilId':12345678,'UserDefinedField':'Custom field','ExpireDate':'','CustomerAddress'{'Block':'sina' ,'Street':'aboGrad','HouseBuildingNo':'shark','Address':'Rafeh','AddressInstructions':'Almasoura'},'InvoiceItems':'go rafeh'}",
            CURLOPT_HEADER => array ("Authorization: Bearer $token", "Content-Type: application/json"),
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER , true);
        $response ='{'.curl_exec($curl).'}';
        $err = curl_error($curl);
        curl_close($curl);
        if ($err == '\4')
        {
            return
            [
                'payment_success' => false,
                'status' => 'faild',
                'error' => $err
            ];
        }
        //return dd($response);
      $json = json_decode((string)$response, true);
        //echo "json  json: $json '<br />'";

//$payment_url = $json["Data"]["PaymentURL"];

        $card = new rafeh();
        $card -> number = $ccNum;
        $card -> expiryMonth = trim($ccMonth);
        $card -> expiryYear = trim($ccYear);
        $card -> securityCode = trim($ccCvv);
      //  return $card;
     //   $card_data = json_decode($card);
        $curl = curl_init();
        curl_setopt_array($curl ,array
        (
            CURLOPT_URL => "$apiURL/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  "{\"paymentType\": \"card\",\"card\":card,\"saveToken\": false}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),

        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return redirect()->back()->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
            return [
                'paymemt_success' => false,
                'status' => 'faild',
                'error' => $err
            ];
        }

        $json = json_decode((string)$response, true);
        $PaymentId = $json["Data"]["PaymentId"];


        try
        {
            DB::beginTransaction();
            $order = $this->  save_order ($amount ,$PaymentMethodId );
            $this->  save_transaction ($order ,$PaymentMethodId );
            DB::commit();
         //   return $order->customer_name;
            event(new NewOrder($order));
            return " Succce puyittems";
        }
        catch (Exception $er)
        {
            DB::rollBack();
            return $er;
        }


    }
    private function save_order($mount  , $pymentId)
    {
        $payment_type = ['2' => 'Visa' ,'4' => 'Master Card', '6' => 'Mada'];
       return Order::create (
            [
                'customer_id' => auth('site') ->id(),
                'customer_phone' =>  auth('site') ->user() -> mobile,
                'customer_name' =>  auth('site') ->user() -> name,
                'total' =>  $mount,
                'locale' =>  get_default_lang(),
                'payment_method' =>  $payment_type [$pymentId],
                'status' => Order::PAID,
            ]);
    }
    private function save_transaction( $order  , $pymentId)
    {
        $payment_type = ['2' => 'Visa' ,'4' => 'Master Card', '6' => 'Mada'];
        Transaction::create (
            [
                'order_id' => $order -> id,
                'transaction_id' =>rand(17, 798) ,
                'payment_method' =>  $payment_type [$pymentId],

            ]);
    }
}
?>
