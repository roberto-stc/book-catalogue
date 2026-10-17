-- Book Catalogue database schema
-- Run this once in phpMyAdmin (http://localhost/phpmyadmin) inside the book_catalogue database.

DROP TABLE IF EXISTS books;
DROP TABLE IF EXISTS users;

-- One row per book.
CREATE TABLE books (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(200) NOT NULL,
    author      VARCHAR(150) NOT NULL,
    genre       VARCHAR(50)  NOT NULL,
    year        INT          NOT NULL,
    isbn        VARCHAR(20),
    description TEXT
);

-- Site users. We never store the real password, only a scrambled "hash"
-- made by PHP's password_hash(), so the column needs room for it.
CREATE TABLE users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Sample books so the site has something to show and search.
INSERT INTO books (title, author, genre, year, isbn, description) VALUES
    ('Project Hail Mary',        'Andy Weir',         'Sci-Fi',      2021, '9780593135204', 'A lone astronaut must save Earth.'),
    ('The Ministry of Time',     'Kaliane Bradley',   'Sci-Fi',      2024, '9781668045145', 'Time-travel romance and spy thriller.'),
    ('Some Desperate Glory',     'Emily Tesh',        'Sci-Fi',      2023, '9781250834980', 'A soldier questions everything she was raised to believe.'),
    ('Starter Villain',          'John Scalzi',       'Sci-Fi',      2023, '9780765389220', 'Inheriting a supervillain business.'),
    ('Fourth Wing',              'Rebecca Yarros',    'Fantasy',     2023, '9781649374042', 'Dragon riders at a war college.'),
    ('The Name of the Wind',     'Patrick Rothfuss',  'Fantasy',     2007, '9780756404741', 'The early life of Kvothe.'),
    ('The Thursday Murder Club', 'Richard Osman',     'Crime',       2020, '9780241425442', 'Retirees solve cold cases.'),
    ('The Silent Patient',       'Alex Michaelides',  'Crime',       2019, '9781250301697', 'A woman stops speaking after a murder.'),
    ('Happy Place',              'Emily Henry',       'Romance',     2023, '9780593441275', 'Exes pretend to still be together.'),
    ('Sapiens',                  'Yuval Noah Harari', 'Non-Fiction', 2011, '9780062316097', 'A brief history of humankind.'),
    ('Atomic Habits',            'James Clear',       'Non-Fiction', 2018, '9780735211292', 'Small changes, remarkable results.'),
    ('The Shining',              'Stephen King',      'Horror',      1977, '9780307743657', 'A family snowed in at a haunted hotel.');
