# payu_money_flutter

This is the plugin for supporting payumoney payment gateway directly by flutter apps.

## Getting Started

This is the plugin for supporting payumoney payment gateway directly by flutter apps.
Note : Currently supported for only Android Platform. Not for iOS right now but wait for some more days it will be here with new update.
And one more thing if you want to make it more better or want to add more platforms support then feel free to contribute.
#### Setup payment details
``` dart
setupPayment() async {
    bool response = await payuMoneyFlutter.setupPaymentKeys(
        merchantKey: "KSXB9Z3J", merchantID: "AwuZ5FVG4c", isProduction: false, activityTitle: "Payment Screen Title", disableExitConfirmation: false);
  }
```

#### Starting payment
```dart
Future<Map<String, dynamic>> startPayment() async {
    // Generating hash from php server
    Response res =
    await post("http://server_url.com", body: {
      "txnid": txnID,
      "phone": phone,
      "email": email,
      "amount": amount,
      "productinfo": productName,
      "firstname": firstName,
    });
    var data = jsonDecode(res.body);
    print(data);
    String hash = data['params']['hash'];
    print(hash);
    Map<String, dynamic> response = await payuMoneyFlutter.startPayment(
        txnid: txnID,
        amount: amount,
        name: firstName,
        email: email,
        phone: phone,
        productName: productName,
        hash: hash);
    print("EROROWROIWEURIWUERIUWRIOEU : $response");
  }
```

```php
    <?php 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    
function preparePayuPayment($params)
{        
    $SS_URL = (isset($params["SS_URL"]))? $params["SS_URL"] : "";
    $FF_URL = (isset($params["FF_URL"]))? $params["FF_URL"] : "";
    $params["key"] = "KSXB9Z3J";    
    
    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    
    $formError = 0;
    $txnid = "";
    if(empty($params['txnid']))
    {
      $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }
    else
    {
      $txnid = $params['txnid'];
    }    
    
    $params['txnid'] = $txnid;
    $hash = '';
    
    if(empty($params['hash']) && sizeof($params) > 0)
    {
        if(empty($params['txnid']) || empty($params['amount']) || empty($params['firstname']) || empty($params['email']) || empty($params['phone']) || empty($params['productinfo']))
        {
            $formError = 1;
        }
        else
        {
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';    
            foreach($hashVarsSeq as $hash_var)
            {
                  $hash_string .= isset($params[$hash_var]) ? $params[$hash_var] : '';
                  $hash_string .= '|';
              }
            $hash_string .= $params["SALT_KEY"];
            $hash = strtolower(hash('sha512', $hash_string));
        }
    }
    else if(!empty($params['hash']))
    {
        $hash = $params['hash'];
    }
    
    $params["hash"] = $hash;
    return array("status"=>$formError, "params"=>$params);
}
if($_SERVER['REQUEST_METHOD'] == "POST") {
  $allParmas = array(
       "key" => "KSXB9Z3J",
       "txnid" => $_POST["txnid"],
       "amount" => $_POST["amount"],
       "SALT_KEY" => "AwuZ5FVG4c",
       "productinfo" => $_POST["productinfo"],
       "firstname" => $_POST["firstname"],
       "email" => $_POST["email"],
       "phone"=> $_POST["phone"],
       "udf1" => "",
       "udf2" => "",
       "udf3" => "",
       "udf4" => "",
       "udf5" => "",
       "udf6" => "",
       "udf7" => "",
       "udf8" => "",
       "udf9" => "",
       "udf10" => ""
     );
     $returnData = preparePayuPayment($allParmas);
     echo json_encode($returnData);
}else {

  echo json_encode(array(
    "error" => "data not passed",

  ));
}
     ?> 
```

### IMPORTANT
1. You have to setup a server for generating Hash for starting payments then you have to call the function for starting payment. OK.
2. All used payment details are fake but you can use maerchant id and maerchant key for testing because these are test keys provided by PayuMoney

#### Issues
If you are having any issues relating to this plugin then you can create a issue at this github repo.

