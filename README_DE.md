![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate Modul für WHMCS Version **5.x.x** und WHMCS Version **6.x**

[![Build Status](https://travis-ci.org/cardgate/whmcs.svg?branch=master)](https://travis-ci.org/cardgate/whmcs)

## Support

Dieses Modul is geeignet für WHMCS Version **5.x.x** und WHMCS Version **6.x**

## Vorbereitung

Um dieses Modul zu verwenden, sind Zugangsdaten zu **CardGate** notwendig.  
Gehen Sie zu [**Mein CardGate**](https://my.cardgate.com/) und fragen Sie Ihre **Site ID** und **Hash Key** an, oder kontaktieren Sie Ihren Accountmanager.

## Installation

1. Downloaden Sie den aktuellsten [**Source Code**](https://github.com/cardgate/whmcs/releases/) auf Ihrem Desktop.

2. Entpacken und uploaden Sie den **Gateway-Ordner** in den **Module-Ordner** von Ihrem Webshop. 

## Konfiguration

1. Gehen Sie zum **Adminbereich** Ihres Webshops.

2. Klicken Sie auf den **Setup-Tab** und wählen Sie **Payments, Payments Gateways**.

3. Wählen Sie das **CardGate Modul** aus der Liste aus, welches Sie **aktivieren** möchten. 

4. Verändern Sie falls gewünscht, den Namen von dem Zahlungsmittel.

5. Wählen Sie **Testmodus**, falls Sie erst testen möchten.

6. Füllen Sie nun die **Site ID** und den **Hash Key** ein, welchen Sie unter **Webseite** bei [**Mein CardGate**](https://my.cardgate.com/) finden können.

7. Füllen Sie die gewünschte Standard **Gateway-Sprache** ein.

8. Speichern Sie nun die Einstellungen in dem Sie auf **Einstellungen speichern** klicken.

9. Wiederholen Sie die Schritte 3 bis 8 für **jedes Zahlungsmittel**, dass Sie installieren möchten.

10. Gehen Sie zu [**Mein CardGate**](https://my.cardgate.com/), klicken Sie auf Webseiten und wählen Sie die richtige Seite aus.

11. Füllen Sie bei **Verbindung mit der Website** die **Callback URL** ein, z.B:  
    **http://meinwebshop.com/modules/gateways/callback/cardgateplus.php**  
    (Ersetzen Sie **http://meinwebshop.com** mit der URL Ihres Webshops.)   

12. Sorgen Sie dafür, dass Sie **nach dem Testen** die **aktivierten Zahlungsmethoden** vom **Testmode** in den **Livemode** umschalten und klicken Sie auf **Speichern**.

## Anforderungen

Keine weiteren Anforderungen.
