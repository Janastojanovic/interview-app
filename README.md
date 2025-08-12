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
- **Docker**

### Pokretanje

- Napraviti fajl .env(na istoj putanji kao .env.example)
  - Podesiti env konstante(kao u .env.example)
    
- cd docker
- docker compose up -d
- docker exec -it interview-app-app bash
- composer install
- composer dump-autoload -o
  
- docker exec -it interview-app-db bash
- mysql -u -root -p
  - Uneti sifru iz .env
- create database ime_baze

**SQL za kreiranje users tabele:**
  use ime_baze;

  CREATE TABLE users(
  id int unsigned primary key auto_increment,
  email varchar(255) unique not null,
  password varchar(255) not null
  )
  
**SQL za kreiranje user_logs tabele:**
  use ime_baze;
  
  CREATE TABLE user_logs(
  id int unsigned primary key auto_increment,
  action varchar(255) not null,
  user_id int not null,
  log_time datetime not null,
  FOREIGN KEY (user_id) REFERENCES users(id)
  )

