![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate module for WHMCS version **5.x.x** and WHMCS version **6.x**

## Support

This plugin supports WHMCS version **5.x.x** and WHMCS version **6.x**

## Preparation

The usage of this module requires that you have obtained CardGate securitycredentials.  
Please visit [My Cardgate](https://my.cardgate.com/) and retrieve your Site ID and Hash key,  
or contact your accountmanager.

## Installation

1. Download the cardgate.zip file on your desktop.

2. Upload the **gateways** folder to the **modules** folder of your webshop.

## Configuration

1. Login to the **admin** section of your webshop.

2. Click on the **Setup** tab and goto **Payments, Payment Gateways**.

3. Select the **CardGate module** you wish to activate from the list and **activate** it. 

4. If desired change the name of the payment method.

5. Select **Test mode** if you want to test first.

6. Now enter the **Site ID** and the **Hash Key** which you can find at **Sites** on [My Cardgate](https://my.cardgate.com/).

7. Enter the desired default **gateway language**.

8. Now save the settings by clicking on the **Save Changes** button.

9. Repeat **steps 3 through 8** for **each payment method** you wish to **activate**.

10. Go to [My Cardgate](https://my.cardgate.com/), choose **Sites** and select the appropriate site.

11. Go to **Connection to the website** and enter the **Callback URL**, for example:  
    **http://mywebshop.com/modules/gateways/callback/cardgateplus.php**  
    (Replace **http://mywebshop.com** with the URL of your webshop)    

12. When you are **finished testing** make sure that you switch **all activated payment methods** from **Test Mode** to **Live mode** and save it (**Save**).

## Requirements

No further requirements.
