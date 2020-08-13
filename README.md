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

### IMPORTANT
1. You have to setup a server for generating Hash for starting payments then you have to call the function for starting payment. OK.
2. All used payment details are fake but you can use maerchant id and maerchant key for testing because these are test keys provided by PayuMoney

#### Issues
If you are having any issues relating to this plugin then you can create a issue at this github repo.

