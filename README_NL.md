![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate module voor WHMCS version **5.x.x** and WHMCS version **6.x**

## Support

Deze plugin is geschikt voor WHMCS versie **5.x.x** en WHMCS versie **6.x**

## Voorbereiding

Voor het gebruik van deze module zijn CardGate inloggegevens noodzakelijk.

Ga a.u.b. naar [Mijn CardGate](https://my.cardgate.com/) en kopieer de  site ID and hash key,  
of vraag deze gegevens aan uw accountmanager.

## Installatie

1. Download en unzip de meest recente [source code](https://github.com/cardgate/whmcs/releases/) op je bureaublad.

2. Upload de **gateways** map naar de **modules** map van je webshop.

## Configuratie

1. Login op het **admin** gedeelte van je webshop.

2. Klik op de **Setup** tab en kies **Payments, Payment Gateways**.

3. Kies de **CardGate module** die je wenst te activeren uit de keuzelijst en **activeer** het. 

4. Verander indien gewenst de naam van de betaalmethode.

5. Kies voor **Test mode** wanneer je eerst wilt testen.

6. Vul nu de **Site ID** en de **Hash Key (Codeersleutel)** in, deze kun je vinden bij **Sites** op [Mijn CardGate](https://my.cardgate.com/).

7. Vul de gewenste standaard **gateway taal** in.

8. Sla nu de instellingen op met de **Save Changes** knop.

9. Herhaal de **stappen 3 tot en met 8** voor **iedere betaalmethode** die je wenst te **activeren**.

10. Ga naar [Mijn CardGate](https://my.cardgate.com/), kies **Sites** en selecteer de juiste site.

11. Vul bij **Technische koppeling** de **Callback URL** in, bijvoorbeeld:  
    **http://mijnwebshop.com/modules/gateways/callback/cardgateplus.php**  
   (Vervang **http://mijnwebshop.com** met de URL van jouw webshop)

12. Zorg ervoor dat je na het testen **alle geactiveerde betaalmethoden** omschakelt van **Test mode** naar **Live mode** en sla het op (**Save**).

## Vereisten

Geen verdere vereisten.
