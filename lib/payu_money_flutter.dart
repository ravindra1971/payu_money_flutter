import 'dart:async';

import 'package:flutter/cupertino.dart';
import 'package:flutter/services.dart';

class PayuMoneyFlutter {
  static const MethodChannel _channel =
      const MethodChannel('payu_money_flutter');
  String _merchantKey;
  String _merchantID;
  bool _isProduction = false;

  Future<bool> setupPaymentKeys(
      {@required String merchantKey,
      @required String merchantID,
      @required bool isProduction,
      @required String activityTitle,
      @required bool disableExitConfirmation}) async {
    bool response = await _channel.invokeMethod("setupDetails", {
      "merchantKey": merchantKey,
      "merchantID": merchantID,
      "isProduction": isProduction,
      "activityTitle": activityTitle,
      "disableExitConfirmation": disableExitConfirmation,
    });
    if (response) {
      _merchantID = merchantID;
      _merchantKey = merchantKey;
      _isProduction = isProduction;
    }
    return response;
  }

  Future<dynamic> startPayment(
      {@required String txnid,
      @required String amount,
      @required String name,
      @required String email,
      @required String phone,
      @required String productName,
      @required String hash,
      @required String udf1,
      @required String udf2,
      @required String udf3,
      @required String udf4,
      @required String udf5      
      }) async {
    try {
      var data = await _channel.invokeMethod("startPayment", {
        "txnid": txnid,
        "hash": hash,
        "amount": amount,
        "phone": phone,
        "email": email,
        "productName": productName,
        "firstname": name,
        "udf1": udf1,
        "udf2": udf2,
        "udf3": udf3,
        "udf4": udf4,
        "udf5": udf5
      });
      return data;
    } catch (e) {
      print(e.toString());
      return null;
    }
  }
}
