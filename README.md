# Barangay Masipit — Event Registration System
**ITP 313 · Event-Driven Programming · Laboratory Activity 5**

CRUD-style Event Registration System na may login/middleware gate,
dalawang environmental event (Clean-Up Drive at Tree Planting), admin
dashboard, at nature/gradient theme. React (walang build step) sa
frontend ng CRUD, PHP + MySQL (Laragon) sa backend.

---

## 1. Paano buksan sa Laragon

1. I-extract ang zip na ito sa loob ng Laragon `www` folder mo, kaya
   magiging: `laragon/www/event-registration-system/`
2. Buksan ang Laragon → i-click **Start All** (Apache + MySQL).
3. I-click ang **Database** button ng Laragon (magbubukas ng
   phpMyAdmin), o pumunta sa `http://localhost/phpmyadmin`.
4. Gumawa ng bagong database (o hayaan mo lang, may
   `CREATE DATABASE IF NOT EXISTS` na sa script), tapos i-**Import**
   ang `sql/database.sql`.
5. Buksan sa browser: `http://localhost/event-registration-system/`

   > Kung gusto mo gamitin yung Laragon "pretty URL" na
   > `http://event-registration-system.test/`, buksan mo lang ang
   > `config/app.php` at sundin yung comment doon (Option B).

6. Mag-login gamit ang isa sa demo accounts:
   - **admin** / `admin123` → may access sa Admin Dashboard
   - **juan** / `admin123` → regular user lang

---

## 2. Ang flow ng system (sagot sa requirements)

```
index.php (LOGIN)
     │  (middleware.php ang bantay dito pababa)
     ▼
choose-event.php  →  pumili: Clean-Up Drive o Tree Planting
     │                              │
     ▼                              ▼
events/cleanup/index.php     events/treeplanting/index.php
   (React CRUD app)               (React CRUD app)
```

- **Auth + Middleware:** `config/middleware.php` ay naka-require sa
  simula ng `choose-event.php`, ng dalawang event pages, ng
  `contact.php`, at ng admin dashboard. Kapag walang
  `$_SESSION['user_id']`, agad na iri-redirect pabalik sa login —
  kahit i-copy mo pa yung URL ng Event Registration page, o
  mag-logout ka muna, babalik ka pa rin sa login.
- **CRUD React app (3 components):** bawat event (`events/cleanup/app.jsx`
  at `events/treeplanting/app.jsx`) ay may:
  - `App` (**Parent**) — `useState` para sa list, form data, at
    editing id; `useEffect` na nagloload ng JSON data galing sa
    `api.php` pag-mount.
  - `RegistrationForm` (**Child #1**) — tumatanggap ng lahat ng props
    galing sa Parent (`formData`, `onChange`, `onSubmit`).
  - `RegistrationList` (**Child #2**) — tumatanggap din ng props
    (`list`, `onEdit`, `onDelete`).
- **Database:** `api.php` sa bawat event folder ay nag-cconnect sa
  MySQL (Laragon) gamit ang PDO — GET/POST/PUT/DELETE = Read/Create/
  Update/Delete.
- **Admin dashboard:** `admin/dashboard.php`, protected ng
  `config/admin_middleware.php` (kailangan `role = admin`).
- **Contact page:** `contact.php`, may social links (GitHub, Facebook,
  Instagram).

---

## 3. Mga file na dapat mong dagdagan (background images)

Tignan ang `assets/images/PLACEHOLDER-README.txt` — doon nakalista
kung anong filename ang hinahanap ng bawat page. Gagana pa rin naman
lahat kahit wala pang laman (gradient background muna ang lalabas).

---

## 4. Design notes

- **Estuary palette** (Clean-Up Drive): deep teal → seafoam gradient,
  para sa "ilog at baybayin" na tema.
- **Canopy palette** (Tree Planting): moss green → gold-lichen
  gradient, para sa "gubat at kabundukan" na tema.
- Typeface: **Fraunces** (display/headings) + **Inter** (body text),
  parehong galing Google Fonts (may fallback sa system fonts kung
  walang internet).
- JS effects: procedurally-drawn na "floating leaves" sa canvas
  (`assets/js/effects.js`), subtle 3D tilt sa event-choice cards, at
  simpleng shake animation sa mga invalid na form field.

---

## 5. Kung babaguhin mo

- Password ng demo accounts: `admin123` para sa parehong `admin` at
  `juan`. Baguhin sa `sql/database.sql` (gamit ang PHP
  `password_hash()`) kung gusto mo ng ibang password.
- Idagdag pang field sa forms: baguhin ang `EMPTY_FORM` sa `app.jsx`,
  ang `<div className="field">` sa parehong file, AT ang column sa
  MySQL table + sa `api.php`.
