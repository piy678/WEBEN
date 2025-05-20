# Webentwicklungsprojekt

    
# SmartTicketing – Webshop

Ein Webshop für den Online-Verkauf von Veranstaltungstickets (Konzerte, Theater, etc.).  
Nutzer*innen können sich registrieren, Tickets durchsuchen, in den Warenkorb legen und bestellen.

---

## Projektstruktur

### Frontend (`/`)
 ``` 
frontend/
│
├── components
│   ├──index.html               → Startseite
├── /res
│   ├── /css/
│   │   └── style.css
│   └── /img/
│       └── picture1.jpg
│
├── /js/
│   ├── login.js             → Login via AJAX
│   ├── register.js          → Registrierung via AJAX
│   ├── tickets.js           → Suche + Anzeige von Tickets
│   └── cart.js              → Warenkorb-Logik
│   ├── checkout.js              → Bestellung abschicken, Gutschein einlösen 
│   ├── myorders.js              → Eigene Bestellungen anzeigen 
│   └── invoice.js               → Rechnung laden/anzeigen
│   └── **productAdmin.js**        ← NEU: Logik für Produktverwaltung (AJAX)
│
├── /sites/
│   ├── login.html
│   ├── register.html
│   ├── tickets.html
│   ├── cart.html
│   └── account.html
│   ├── checkout.html            → Checkout-Seite 
│   ├── myorders.html            → Bestellhistorie anzeigen 
│   └── invoice.html             → Einzelrechnung anzeigen
│   └── **products_admin.html**    ← NEU: Admin-Seite für Produktpflege
 ``` 
### Backend (`/`)
 ``` 
backend/
│
├── /config/
│   ├── dbacess.php          → MySQL-Verbindung
│   └── dataHandler.php      → (optional)
│
├── /models/
│   ├── user.class.php       → Darstellen eines Users als Objekt
│   ├── product.class.php    → Event-Datenmodell
│   └── cart.class.php       → Warenkorb-Klasse
│   ├── order.class.php          → Bestellung-Objekt 
│   ├── voucher.class.php        → Gutschein-Objekt 
│   └── invoice.class.php        → Rechnungs-Objekt 
│
├── /logic/
│   ├── login.php            → verarbeitet Login (POST)
│   ├── register.php         → verarbeitet Registrierung (POST)
│   ├── searchTickets.php    → liefert Tickets als JSON (GET)
│   ├── addToCart.php        → AJAX-Warenkorb hinzufügen
│   └── getCartItems.php     → gibt Warenkorb-Daten als JSON zurück
│   ├── submitOrder.php          → Bestellung speichern (Session → DB) 
│   ├── getOrders.php            → Bestellungen eines Users abrufen 
│   ├── useVoucher.php           → Gutscheincode prüfen und anwenden 
│   └── generateInvoice.php      → Rechnung erzeugen für eine Bestellung
│   ├── **addProduct.php**         ← NEU: Produkt anlegen (mit Bild)
│   ├── **updateProduct.php**      ← NEU: Produkt bearbeiten
│   ├── **deleteProduct.php**      ← NEU: Produkt löschen
│   └── **getProducts.php**        ← NEU: Produktliste für Admin laden
│
├── /productpictures/
│   └── *.png                → Ticket/Event-Bilder

 ```
## Technologien

- **Frontend**: HTML, CSS, JavaScript, AJAX
- **Backend**: PHP (mit `mysqli`), objektorientiert
- **Datenbank**: MySQL
- **Struktur**: Trennung von Frontend & Backend gemäß Spezifikation