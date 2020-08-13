import 'package:flutter/services.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:payu_money_flutter/payu_money_flutter.dart';

void main() {
  const MethodChannel channel = MethodChannel('payu_money_flutter');

  TestWidgetsFlutterBinding.ensureInitialized();

  setUp(() {
    channel.setMockMethodCallHandler((MethodCall methodCall) async {
      return '42';
    });
  });

  tearDown(() {
    channel.setMockMethodCallHandler(null);
  });

  test('getPlatformVersion', () async {
    expect(await PayuMoneyFlutter.platformVersion, '42');
  });
}
