import 'package:flutter/material.dart';
import 'package:hamyar_moshtari/constants.dart';
import 'package:hamyar_moshtari/screens/login/components/head.dart';

Body(title, method, controller, mobileNumber, hintText, helpText, icon) {
  return Column(
    children: <Widget>[
      Head(title),
      Align(
        alignment: Alignment.topCenter,
        child: Padding(
          padding: const EdgeInsets.only(left: 20, top: 70, right: 20),
          child: Text(
            helpText,
            style: const TextStyle(
              fontFamily: 'Vazir',
              fontSize: 18,
              color: kPrimaryColor,
            ),
            textAlign: TextAlign.center,
          ),
        ),
      ),
      Expanded(
        child: Builder(
          builder: (context) => Stack(
            children: <Widget>[
              Center(
                child: Padding(
                  padding: const EdgeInsets.only(
                    left: 70,
                    right: 70,
                  ),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Material(
                        child: TextField(
                          textAlign: TextAlign.right,
                          style: const TextStyle(
                              fontFamily: 'Vazir', fontSize: 18),
                          controller: controller,
                          decoration: InputDecoration(
                            prefixIcon: Icon(
                              icon,
                            ),
                            hintText: hintText,
                          ),
                        ),
                      ),
                      const SizedBox(
                        height: 30,
                      ),
                      Padding(
                        padding: const EdgeInsets.only(left: 30, right: 30),
                        child: Material(
                          borderRadius: BorderRadius.circular(40),
                          color: kPrimaryColor,
                          child: InkWell(
                            onTap: () {
                              if (mobileNumber == "") {
                                method(
                                    context: context,
                                    mobile_number: controller.text);
                              } else {
                                method(
                                    context: context,
                                    mobile_number: mobileNumber,
                                    sms_code: controller.text);
                              }
                            },
                            child: const SizedBox(
                              height: 40,
                              child: Center(
                                child: Text(
                                  'ورود به همیار مشتری',
                                  style: TextStyle(
                                      fontFamily: 'Vazir',
                                      fontSize: 16,
                                      color: kPrimaryLightColor),
                                ),
                              ),
                            ),
                          ),
                        ),
                      )
                    ],
                  ),
                ),
              )
            ],
          ),
        ),
      ),
      Expanded(
        child: Column(
          children: <Widget>[
            const Text(
              'مطالعه شرایط و حریم خصوصی',
              style: TextStyle(color: kPrimaryColor),
            ),
            Padding(
              padding: const EdgeInsets.only(left: 30),
              child: SizedBox(
                width: 430,
                child: Column(
                  children: [
                    const SizedBox(
                      height: 10,
                    ),
                    Row(
                      children: <Widget>[
                        const SizedBox(
                          width: 10,
                        ),
                        const Text(
                          'با شرایط حریم خصوصی همیار مشتری موافقم',
                          style: TextStyle(color: kPrimaryColor),
                        ),
                        const SizedBox(
                          width: 10,
                        ),
                        Checkbox(
                          value: false,
                          onChanged: (value) {},
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    ],
  );
}
