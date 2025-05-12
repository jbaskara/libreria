CREATE DATABASE IF NOT EXISTS Libreria;
USE Libreria;

DROP TABLE IF EXISTS Noleggi, Libri, Utenti, Messaggi;

CREATE TABLE Utenti (
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50),
    cognome VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    ruolo ENUM('admin', 'utente') DEFAULT 'utente'
);

CREATE TABLE Libri (
    id_libro INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(100),
    autore VARCHAR(100),
    anno_pubblicazione YEAR,
    genere SET('Romanzo', 'Saggio', 'Biografia', 'Fantasy', 'Giallo', 'Horror', 'Storico', 'Altro'),
    copertina VARCHAR(255),
    lingua ENUM('Italiano', 'Inglese', 'Francese', 'Tedesco', 'Spagnolo', 'Altro'),
    disponibile BOOLEAN DEFAULT TRUE
);

CREATE TABLE Noleggi (
    id_noleggio INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT,
    id_libro INT,
    data_noleggio DATE,
    data_restituzione DATE DEFAULT NULL,
    FOREIGN KEY (id_utente) REFERENCES Utenti(id_utente),
    FOREIGN KEY (id_libro) REFERENCES Libri(id_libro)
);

CREATE TABLE Recensioni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_libro INT NOT NULL,
    utente VARCHAR(255) NOT NULL,
    voto INT CHECK (voto BETWEEN 1 AND 5),
    commento TEXT,
    data_pubblicazione TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_libro) REFERENCES Libri(id_libro)
);


CREATE TABLE Messaggi (
    id_messaggio INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    oggetto VARCHAR(150),
    messaggio TEXT NOT NULL,
    data_invio DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Utenti (nome, cognome, email, password, ruolo) VALUES
('Admin', 'XYZ', 'admin@libreria.it', MD5('admin123'), 'admin'),
('Luca', 'Bianchi', 'luca@example.com', MD5('user123'), 'utente'),
('Anna', 'Verdi', 'anna@example.com', MD5('user123'), 'utente'),
('Giulia', 'Neri', 'giulia@example.com', MD5('user123'), 'utente'),
('Marco', 'Gialli', 'marco@example.com', MD5('user123'), 'utente');

INSERT INTO Libri (titolo, autore, anno_pubblicazione, genere, copertina, lingua, disponibile) VALUES
('Il nome della rosa', 'Umberto Eco', 1980, 'Romanzo,Storico', 'link/copertine/il_nome_della_rosa.jpg', 'Italiano', FALSE),
('1984', 'George Orwell', 1949, 'Romanzo', 'link/copertine/1984.jpg', 'Inglese', TRUE),
('Harry Potter e la Pietra Filosofale', 'J.K. Rowling', 1997, 'Fantasy', 'link/copertine/hp1.jpg', 'Italiano', FALSE),
('Il Signore degli Anelli', 'J.R.R. Tolkien', 1954, 'Fantasy', 'link/copertine/lotr.jpg', 'Inglese', TRUE),
('La Divina Commedia', 'Dante Alighieri', 1320, 'Romanzo', 'link/copertine/divina_commedia.jpg', 'Italiano', TRUE),
('Il Codice Da Vinci', 'Dan Brown', 2003, 'Giallo,Storico', 'link/copertine/da_vinci_code.jpg', 'Italiano', TRUE),
('Dracula', 'Bram Stoker', 1897, 'Horror', 'link/copertine/dracula.jpg', 'Inglese', TRUE),
('Don Chisciotte della Mancia', 'Miguel de Cervantes', 1605, 'Romanzo', 'link/copertine/don_chisciotte.jpg', 'Spagnolo', FALSE),
('Sapiens: Da animali a dèi', 'Yuval Noah Harari', 2011, 'Saggio', 'link/copertine/sapiens.jpg', 'Italiano', TRUE),
('Il Piccolo Principe', 'Antoine de Saint-Exupéry', 1943, 'Romanzo', 'link/copertine/piccolo_principe.jpg', 'Francese', TRUE),
('Il Gattopardo', 'Giuseppe Tomasi di Lampedusa', 1958, 'Storico', 'link/copertine/gattopardo.jpg', 'Italiano', TRUE),
('Sherlock Holmes - Uno studio in rosso', 'Arthur Conan Doyle', 1887, 'Giallo', 'link/copertine/sherlock.jpg', 'Inglese', TRUE),
('Frankenstein', 'Mary Shelley', 1818, 'Horror', 'link/copertine/frankenstein.jpg', 'Inglese', TRUE),
('La coscienza di Zeno', 'Italo Svevo', 1923, 'Romanzo', 'link/copertine/zeno.jpg', 'Italiano', TRUE),
('Il mondo nuovo', 'Aldous Huxley', 1932, 'Romanzo', 'link/copertine/mondo_nuovo.jpg', 'Inglese', TRUE);

INSERT INTO Noleggi (id_utente, id_libro, data_noleggio, data_restituzione) VALUES
(2, 1, '2025-04-01', NULL),
(3, 2, '2025-03-28', '2025-04-05'),
(4, 3, '2025-04-02', NULL),
(5, 6, '2025-03-30', '2025-04-06'),
(2, 8, '2025-04-03', NULL);