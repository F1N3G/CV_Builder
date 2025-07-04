# CV\_Builder – README.md

Acest proiect reprezintă o aplicație web complet funcțională pentru crearea și personalizarea de CV-uri, dezvoltată pentru disciplina Sisteme de Gestiune a Bazelor de Date (SGBD). Include o bază de date relațională în 3FN, funcții și proceduri stocate, triggeri, interfață PHP și stil CSS modern.

---

## 📁 Structura fișierelor

### Fișiere SQL (proceduri, funcții, triggeri, script principal)

* `cv_builder_test1.sql` – Script complet de creare a bazei de date și populare a tabelelor.
* `auto_insert_cv.sql` – Trigger care inserează automat un CV gol când se creează un user.
* `count_filled_sections.sql` – Funcție care numără câmpurile completate dintr-un CV.
* `delete_cv_on_user_delete.sql` – Trigger care șterge CV-ul când se șterge un user.
* `funcție_stocata_1.sql` – Conține funcția `get_template_name(user_id)`.
* `get_email_domain.sql` – Funcție care extrage domeniul emailului utilizatorului.
* `insert_blank_cv.sql` – Procedură care inserează un CV gol pentru un utilizator nou.
* `list_users_with_template.sql` – Procedură care listează utilizatorii ce folosesc un anumit template.
* `reset_cv.sql` – Procedură care șterge toate câmpurile completate ale unui CV.
* `set_update_timestamp.sql` – Trigger care actualizează `updated_at` la modificare.

### Fișiere backend PHP

* `db.php` – Conexiune la baza de date MySQL (localhost, root, fără parolă).
* `save_profile.php` – Primește datele CV-ului din dashboard și le salvează asincron (POST JSON).
* `debug_session.txt` / `debug_user.txt` – Fișiere temporare pentru depanare sesiuni/utilizator.

### Interfață și funcționalități principale

* `index.php` – Pagina principală a aplicației. Introducere + buton de înregistrare.
* `login.php` – Formular de autentificare utilizator.
* `register.php` – Formular de înregistrare cont nou (creează și `profile`).
* `logout.php` – Dezactivează sesiunea și redirecționează către login.
* `dashboard.php` – Pagină principală a utilizatorului pentru completarea CV-ului.
* `preview.php` – Previzualizare a CV-ului completat, în stil imprimabil.

### Pagini pentru gestionarea secțiunilor de CV

* `education.php` – Adăugare și vizualizare istoric educațional.
* `experience.php` – Adăugare și vizualizare experiență profesională.
* `skills.php` – Adăugare și vizualizare competențe (tehnice).

### Stilizare și UI

* `style.css` – Stil CSS pentru formulare, butoane și pagini simple.

---

## ▶️ Pași pentru rulare locală (cu Laragon/XAMPP)

1. Creează baza de date rulând `cv_builder_test1.sql` în HeidiSQL.
2. Copiază toate fișierele `.php` într-un folder din `www` sau `htdocs`.
3. Accesează în browser: `http://localhost/cv_builder/`
4. Creează un cont nou și începe editarea CV-ului.

---

Document redactat de: **Florescu Neagoe - Alexandra Gabriela**

Proiect: CV\_Builder · Materia: SGBD · Anul II
