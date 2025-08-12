# interview-app

Refaktorisano rešenje test zadatka za backend developera, urađeno bez korišćenja gotovih framework rešenja.  
## Opis zadatka

Aplikacija omogućava registraciju korisnika uz sledeće funkcionalnosti:

- Validacija ulaznih podataka (email, lozinka, potvrda lozinke)
- Provera jedinstvenosti email adrese u bazi
- Hashovanje lozinke pre čuvanja
- MaxMind simulacija
- Logovanje aktivnosti korisnika u posebnu tabelu (`logs`)
- Rad sa bazom preko Repository
  
## Tehnologije i alati

- **PHP 8.2+**
- **PDO** za pristup bazi
- **MySQL** baza podataka
- **Composer** za autoloading
- **PSR-4** autoloading standard


