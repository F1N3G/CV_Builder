-- Creare baza de date
DROP DATABASE IF EXISTS cv_builder;
CREATE DATABASE cv_builder CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE cv_builder;

-- Tabel: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabel: profiles
CREATE TABLE profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    summary TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel: education
CREATE TABLE education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_id INT,
    institution VARCHAR(100),
    degree VARCHAR(100),
    field VARCHAR(100),
    start_year YEAR,
    end_year YEAR,
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE
);

-- Tabel: experience
CREATE TABLE experience (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_id INT,
    job_title VARCHAR(100),
    company VARCHAR(100),
    start_date DATE,
    end_date DATE,
    description TEXT,
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE
);

-- Tabel: skills
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_id INT,
    skill_name VARCHAR(100),
    skill_level ENUM('beginner', 'intermediate', 'advanced'),
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE
);


CREATE TABLE cv_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(50),
    email VARCHAR(100),
    address VARCHAR(255),
    liceu TEXT,
    facultate TEXT,
    experienta TEXT,
    cursuri TEXT,
    voluntariat TEXT,
    tehnice TEXT,
    lingvistice TEXT,
    sociale TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Populare: users
INSERT INTO users (username, email, password) VALUES
('john_doe', 'john@example.com', 'hashed_pass_1'),
('jane_smith', 'jane@example.com', 'hashed_pass_2'),
('alice_jones', 'alice@example.com', 'hashed_pass_3'),
('bob_martin', 'bob@example.com', 'hashed_pass_4'),
('clara_white', 'clara@example.com', 'hashed_pass_5'),
('david_green', 'david@example.com', 'hashed_pass_6'),
('eva_black', 'eva@example.com', 'hashed_pass_7'),
('frank_brown', 'frank@example.com', 'hashed_pass_8'),
('gina_wilson', 'gina@example.com', 'hashed_pass_9'),
('harry_potter', 'harry@hogwarts.edu', 'hashed_pass_10');

-- Populare: profiles
INSERT INTO profiles (user_id, full_name, phone, address, summary) VALUES
(1, 'John Doe', '0744000001', 'Strada A, nr. 1', 'Web developer junior.'),
(2, 'Jane Smith', '0744000002', 'Strada B, nr. 2', 'Marketing specialist.'),
(3, 'Alice Jones', '0744000003', 'Strada C, nr. 3', 'UX/UI Designer.'),
(4, 'Bob Martin', '0744000004', 'Strada D, nr. 4', 'Software engineer.'),
(5, 'Clara White', '0744000005', 'Strada E, nr. 5', 'Financial analyst.'),
(6, 'David Green', '0744000006', 'Strada F, nr. 6', 'Project manager.'),
(7, 'Eva Black', '0744000007', 'Strada G, nr. 7', 'Digital artist.'),
(8, 'Frank Brown', '0744000008', 'Strada H, nr. 8', 'Data scientist.'),
(9, 'Gina Wilson', '0744000009', 'Strada I, nr. 9', 'Scrum Master.'),
(10, 'Harry Potter', '0744000010', 'Str. Hogwarts, nr. 9¾', 'Vânător de buguri.');

-- Populare: education
INSERT INTO education (profile_id, institution, degree, field, start_year, end_year) VALUES
(1, 'UBB Cluj', 'Licenta', 'Informatica', 2019, 2022),
(2, 'ASE Bucuresti', 'Licenta', 'Marketing', 2018, 2021),
(3, 'UNArte Bucuresti', 'Licenta', 'Design grafic', 2020, 2023),
(4, 'UPB', 'Licenta', 'Calculatoare', 2017, 2021),
(5, 'ULBS', 'Licenta', 'Finante', 2019, 2022),
(6, 'SNSPA', 'Master', 'Management', 2022, 2024),
(7, 'Universitatea de Arte Timișoara', 'Licenta', 'Arte vizuale', 2018, 2021),
(8, 'UBB Cluj', 'Master', 'Data Science', 2020, 2022),
(9, 'ULBS', 'Licenta', 'Economie', 2016, 2019),
(10, 'Hogwarts', 'Licenta', 'Magie Aplicată', 2010, 2017);

-- Populare: experience
INSERT INTO experience (profile_id, job_title, company, start_date, end_date, description) VALUES
(1, 'Web Developer', 'BitSoft', '2022-01-10', '2023-05-30', 'Site-uri WordPress și Laravel.'),
(2, 'Marketing Assistant', 'Orange', '2021-03-01', '2022-12-15', 'Campanii email și social media.'),
(3, 'UX Designer', 'Adobe', '2022-07-01', '2023-12-31', 'Figma, prototipuri, cercetare utilizatori.'),
(4, 'Junior Dev', 'IBM', '2020-06-15', '2022-08-31', 'Proiecte Java și API-uri REST.'),
(5, 'Analist Financiar', 'BCR', '2021-02-01', '2023-01-01', 'Bugete, rapoarte și analize.'),
(6, 'PM Intern', 'Vodafone', '2023-01-15', '2023-07-15', 'Coordonare echipe.'),
(7, 'Ilustrator', 'Ubisoft', '2019-05-01', '2021-11-30', 'Grafica pentru jocuri mobile.'),
(8, 'Data Analyst', 'Amazon', '2020-09-01', '2022-11-30', 'SQL, Python, dashboard-uri.'),
(9, 'Coordonator Proiect', 'Continental', '2018-04-01', '2020-12-01', 'Proiecte tehnice.'),
(10, 'Programator VR', 'Ministerul Magiei', '2016-01-01', '2023-01-01', 'Magie + cod.');

-- Populare: skills
INSERT INTO skills (profile_id, skill_name, skill_level) VALUES
(1, 'HTML/CSS', 'advanced'),
(2, 'SEO', 'intermediate'),
(3, 'Adobe XD', 'advanced'),
(4, 'Java', 'intermediate'),
(5, 'Excel', 'advanced'),
(6, 'Agile', 'beginner'),
(7, 'Photoshop', 'advanced'),auto_insert_cv
(8, 'Python', 'intermediate'),
(9, 'Public Speaking', 'intermediate'),
(10, 'Luptă cu dragoni', 'advanced');
