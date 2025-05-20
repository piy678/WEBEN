# SmartTicketing – Webshop

Ein Webshop für den Online-Verkauf von Veranstaltungstickets (Konzerte, Theater, etc.).  
Nutzer*innen können sich registrieren, Tickets durchsuchen, in den Warenkorb legen und bestellen.  
Administratoren können Produkte verwalten und Bestellungen einsehen.

---

## Projektstruktur

### Frontend (`/frontend/`)

```
frontend/
│
├── components/
│   └── index.html                   → Startseite
│
├── res/
│   ├── css/
│   │   └── style.css               → Zentrales Styling
│   └── img/
│       └── picture1.jpg, ...       → Ticket/Event-Bilder
│
├── js/
│   ├── login.js                    → Login via AJAX
│   ├── register.js                 → Registrierung via AJAX
│   ├── tickets.js                  → Ticket-Suche und Anzeige
│   ├── cart.js                     → Warenkorb-Logik
│   ├── checkout.js                 → Bestellung abschicken, Gutschein einlösen
│   ├── myorders.js                 → Eigene Bestellungen anzeigen
│   ├── invoice.js                  → Rechnung laden und anzeigen
│   └── productAdmin.js             → Produktverwaltung (Adminbereich)
│
├── sites/
│   ├── login.html                  → Login-Seite
│   ├── register.html               → Registrierung
│   ├── tickets.html                → Ticketübersicht
│   ├── cart.html                   → Warenkorb
│   ├── checkout.html               → Kasse (Bestellung absenden)
│   ├── myorders.html               → Bestellhistorie
│   ├── invoice.html                → Einzelrechnung anzeigen
│   └── products_admin.html         → Adminseite zur Produktpflege
```

---

### Backend (`/backend/`)

```
backend/
│
├── config/
│   ├── dbacess.php                 → MySQL-Verbindung
│   └── dataHandler.php            → (optional)
│
├── models/
│   ├── user.class.php             → Benutzerobjekt
│   ├── product.class.php          → Ticket/Event-Datenmodell
│   ├── cart.class.php             → Warenkorb-Klasse
│   ├── order.class.php            → Bestellung-Objekt
│   ├── voucher.class.php          → Gutschein-Objekt
│   └── invoice.class.php          → Rechnungs-Objekt
│
├── logic/
│   ├── login.php                  → Login-Verarbeitung
│   ├── register.php               → Registrierung
│   ├── searchTickets.php          → Tickets als JSON (GET)
│   ├── addToCart.php              → Produkt in Warenkorb legen
│   ├── getCartItems.php           → Warenkorb als JSON
│   ├── submitOrder.php            → Bestellung speichern
│   ├── getOrders.php              → Bestellungen abrufen
│   ├── getOrdersByUser.php        → Bestellungen eines bestimmten Nutzers
│   ├── useVoucher.php             → Gutschein anwenden
│   ├── createVoucher.php          → Gutschein erstellen (Admin)
│   ├── getVouchers.php            → Gutscheinliste abrufen (Admin)
│   ├── generateInvoice.php        → Rechnung erstellen
│   ├── getInvoiceData.php         → Rechnungsdaten für Anzeige abrufen
│   ├── addProduct.php             → Produkt anlegen (inkl. Bild)
│   ├── updateProduct.php          → Produkt bearbeiten
│   ├── deleteProduct.php          → Produkt löschen
│   ├── getProducts.php            → Produktliste laden (Admin)
│   └── getUsers.php               → Nutzerliste abrufen (Admin)
│
├── productpictures/
│   └── *.png                      → Produktbilder (Tickets)
```

---

## Verwendete Technologien

| Bereich       | Technologie        |
|---------------|--------------------|
| Frontend      | HTML, CSS, JavaScript, AJAX |
| Backend       | PHP (OOP, mysqli)  |
| Datenbank     | MySQL              |
| Struktur      | Klare Trennung von Frontend & Backend |

---

## Benutzerrollen

- Benutzer:
  - Registrierung / Login
  - Tickets durchsuchen und kaufen
  - Warenkorb nutzen
  - Bestellungen einsehen
  - Rechnungen ansehen

- Admin:
  - Ticket-/Produktverwaltung (CRUD)
  - Gutscheinverwaltung
  - Event-Bilder hochladen
  - Nutzer- und Bestellübersicht einsehen
  - Rechnungsdaten abrufen

---

## Neue Features (Stand Mai 2025)

- Admin-Produktverwaltung:
  - Produkt anlegen, bearbeiten, löschen
  - Verwaltung per `products_admin.html` und `productAdmin.js`
- Gutscheine:
  - Erstellung (`createVoucher.php`)
  - Anwendung (`useVoucher.php`)
  - Verwaltung (`getVouchers.php`)
- Rechnungen:
  - Automatisch erzeugt nach Bestellung
  - Datenabruf über `getInvoiceData.php`
  - Anzeige via `invoice.js` / `invoice.html`
- Nutzerverwaltung（Admin）:
  - Vollständige Liste über `getUsers.php`
- Benutzerbezogene Bestellabfrage:
  - `getOrdersByUser.php`

---

## Hinweise zur Nutzung

- Projekt benötigt lokale PHP + MySQL Umgebung (z. B. XAMPP)
- Datenbankstruktur ist über `dbacess.php` angebunden
- Produktbilder bitte in `backend/productpictures/` hochladen
- Admin-Zugang über Direktaufruf `products_admin.html`
