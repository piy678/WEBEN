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
│
├── /sites/
│   ├── login.html
│   ├── register.html
│   ├── tickets.html
│   ├── cart.html
│   └── account.html
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
│   ├── user.class.php       → Login- & Registrierungslogik
│   ├── product.class.php    → Event-Datenmodell
│   └── cart.class.php       → Warenkorb-Klasse
│
├── /logic/
│   ├── login.php            → verarbeitet Login (POST)
│   ├── register.php         → verarbeitet Registrierung (POST)
│   ├── searchTickets.php    → liefert Tickets als JSON (GET)
│   ├── addToCart.php        → AJAX-Warenkorb hinzufügen
│   └── getCartItems.php     → gibt Warenkorb-Daten als JSON zurück
│
├── /productpictures/
│   └── *.png                → Ticket/Event-Bilder

 ```
## Technologien

- **Frontend**: HTML, CSS, JavaScript, AJAX
- **Backend**: PHP (mit `mysqli`), objektorientiert
- **Datenbank**: MySQL
- **Struktur**: Trennung von Frontend & Backend gemäß Spezifikation

  
