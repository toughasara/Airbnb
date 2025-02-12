-- Création de la base de données

CREATE DATABASE airbnb;

-- Connexion à la base de données
\c airbnb;

-- Table des rôles
CREATE TABLE role (
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL CHECK (title IN ('TRAVELER', 'OWNER', 'ADMIN'))
);

-- Table des utilisateurs
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    role_id INT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255), -- Peut être NULL pour les utilisateurs inscrits via Google/Facebook
    phone_number VARCHAR(20),
    profile_picture VARCHAR(500),
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive', 'suspended')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP WITH TIME ZONE,
    is_connected BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE SET NULL
);

-- Table des messages
CREATE TABLE message (
    id SERIAL PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (sender_id) REFERENCES "user"(id) ON DELETE SET NULL,
    FOREIGN KEY (receiver_id) REFERENCES "user"(id) ON DELETE SET NULL
);

-- Table des propriétés
CREATE TABLE property (
    id SERIAL PRIMARY KEY,
    owner_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    price_per_night DECIMAL(10, 2) NOT NULL,
    max_guests INTEGER NOT NULL,
    amenities JSONB, -- Tableau de chaînes pour les équipements
    photos JSONB, -- Tableau de liens de photos
    is_validated BOOLEAN DEFAULT FALSE,
    address VARCHAR(500),
    city VARCHAR(100),
    country VARCHAR(100),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES "user"(id) ON DELETE SET NULL
);

-- Table des promotions de location
CREATE TABLE promotion (
    id SERIAL PRIMARY KEY,
    property_id INT,
    discount_percentage INTEGER CHECK (discount_percentage BETWEEN 0 AND 100),
    promotion_type VARCHAR(50) NOT NULL CHECK (promotion_type IN ('last minute', 'seasonal', 'long stay', 'weekend special')),
    start_date DATE,
    end_date DATE,
    status VARCHAR(50) DEFAULT 'valide' CHECK (status IN ('valide', 'suspendu')),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES property(id) ON DELETE SET NULL
);

-- Table des réservations
CREATE TABLE booking (
    id SERIAL PRIMARY KEY,
    property_id INT,
    traveler_id INT,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    guest_count INTEGER NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'PENDING',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT valid_dates CHECK (check_out_date > check_in_date),
    FOREIGN KEY (property_id) REFERENCES property(id) ON DELETE SET NULL,
    FOREIGN KEY (traveler_id) REFERENCES "user"(id) ON DELETE SET NULL
);

-- Table des avis
CREATE TABLE review (
    id SERIAL PRIMARY KEY,
    property_id INT,
    traveler_id INT,
    rating INTEGER CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(property_id, traveler_id),
    FOREIGN KEY (property_id) REFERENCES property(id) ON DELETE SET NULL,
    FOREIGN KEY (traveler_id) REFERENCES "user"(id) ON DELETE SET NULL
);
);

INSERT INTO role (title) VALUES
('TRAVELER'),
('OWNER'),
('ADMIN');

INSERT INTO "user" (role_id, first_name, last_name, email, password, phone_number, profile_picture, status, last_login, is_connected) VALUES
(1, 'Jean', 'Dupont', 'jean.dupont@example.com', 'password123', '+33123456789', 'https://example.com/profiles/jean.jpg', 'active', '2023-10-01 12:00:00+00', TRUE),
(2, 'Marie', 'Martin', 'marie.martin@example.com', 'password456', '+33987654321', 'https://example.com/profiles/marie.jpg', 'active', '2023-10-02 14:30:00+00', FALSE),
(3, 'Admin', 'User', 'admin@example.com', 'admin123', '+33000000000', 'https://example.com/profiles/admin.jpg', 'active', '2023-10-03 10:15:00+00', TRUE);

INSERT INTO message (sender_id, receiver_id, content, is_read) VALUES
(1, 2, 'Bonjour Marie, je suis intéressé par votre propriété !', FALSE),
(2, 1, 'Bonjour Jean, merci pour votre intérêt. Quand souhaitez-vous visiter ?', TRUE);

INSERT INTO property (owner_id, title, description, category, price_per_night, max_guests, amenities, photos, is_validated, address, city, country) VALUES
(2, 'Charmant studio à Paris', 'Un studio cosy en plein cœur de Paris, proche de la Tour Eiffel.', 'Studio', 80.00, 2, '["Wi-Fi", "Cuisine équipée", "TV"]', '["https://example.com/photos/paris1.jpg", "https://example.com/photos/paris2.jpg"]', TRUE, '15 Rue de la Paix', 'Paris', 'France'),
(2, 'Maison de campagne en Provence', 'Une belle maison avec piscine et jardin.', 'Maison', 150.00, 6, '["Piscine", "Jardin", "BBQ"]', '["https://example.com/photos/provence1.jpg", "https://example.com/photos/provence2.jpg"]', TRUE, '10 Chemin des Lavandes', 'Aix-en-Provence', 'France');

INSERT INTO promotion (property_id, discount_percentage, promotion_type, start_date, end_date, status) VALUES
(1, 10, 'last minute', '2023-10-15', '2023-10-20', 'valide'),
(2, 20, 'seasonal', '2023-11-01', '2023-11-30', 'valide');

INSERT INTO booking (property_id, traveler_id, check_in_date, check_out_date, guest_count, total_price, status) VALUES
(1, 1, '2023-10-18', '2023-10-20', 2, 144.00, 'CONFIRMED'),
(2, 1, '2023-11-10', '2023-11-15', 4, 600.00, 'PENDING');

Table des paiements
CREATE TABLE payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    booking_id UUID REFERENCES bookings(id),
    amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50),
    transaction_id VARCHAR(255) UNIQUE,
    payment_date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'PENDING'
);
INSERT INTO review (property_id, traveler_id, rating, comment) VALUES
(1, 1, 5, 'Super séjour, le studio est parfaitement situé et très confortable.'),
(2, 1, 4, 'Très belle maison, mais un peu difficile à trouver.');
-- Table des paiements
-- CREATE TABLE payments (
--     id INT PRIMARY KEY AUTO_INCREMENT,
--     booking_id UUID REFERENCES bookings(id),
--     amount DECIMAL(10, 2) NOT NULL,
--     payment_method VARCHAR(50),
--     transaction_id VARCHAR(255) UNIQUE,
--     payment_date TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
--     status VARCHAR(50) DEFAULT 'PENDING'
-- );

Table des fils de conversation
CREATE TABLE conversation_threads (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id UUID REFERENCES properties(id),
    sender_id UUID REFERENCES users(id),
    receiver_id UUID REFERENCES users(id),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    last_message_at TIMESTAMP WITH TIME ZONE,
    status VARCHAR(50) DEFAULT 'ACTIVE'
);

Table des messages instantanés
CREATE TYPE message_type AS ENUM ('TEXT', 'BOOKING_REQUEST', 'BOOKING_CONFIRMATION', 'SYSTEM_NOTIFICATION');

CREATE TABLE instant_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    conversation_thread_id UUID REFERENCES conversation_threads(id),
    sender_id UUID REFERENCES users(id),
    content TEXT NOT NULL,
    message_type message_type DEFAULT 'TEXT',
    sent_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    is_read BOOLEAN DEFAULT FALSE
);

Table des notifications de messages
CREATE TABLE message_notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    message_id UUID REFERENCES instant_messages(id),
    receiver_id UUID REFERENCES users(id),
    notification_time TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    is_delivered BOOLEAN DEFAULT FALSE,
    is_read BOOLEAN DEFAULT FALSE
);

Index pour optimiser les performances
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_properties_owner ON properties(owner_id);
CREATE INDEX idx_bookings_property ON bookings(property_id);
CREATE INDEX idx_bookings_traveler ON bookings(traveler_id);
CREATE INDEX idx_reviews_property ON reviews(property_id);
CREATE INDEX idx_conversations_participants ON conversation_threads(sender_id, receiver_id);
-- Index pour optimiser les performances
-- CREATE INDEX idx_users_email ON users(email);
-- CREATE INDEX idx_properties_owner ON properties(owner_id);
-- CREATE INDEX idx_bookings_property ON bookings(property_id);
-- CREATE INDEX idx_bookings_traveler ON bookings(traveler_id);
-- CREATE INDEX idx_reviews_property ON reviews(property_id);
-- CREATE INDEX idx_conversations_participants ON conversation_threads(sender_id, receiver_id);
