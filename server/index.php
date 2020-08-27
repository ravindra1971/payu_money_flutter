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
