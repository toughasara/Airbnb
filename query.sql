-- Creation de base de donnee
CREATE DATABASE airbnb;
USE airbnb;

-- Table des roles 
CREATE TABLE role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title ENUM('TRAVELER', 'OWNER', 'ADMIN') NOT NULL
);

-- Table des utilisateurs
CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255), -- Peut être NULL pour les utilisateurs inscrits via Google/Facebook
    phone_number VARCHAR(20),
    profile_picture VARCHAR(500), -- Peut être NULL et sera ajouté plus tard
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP WITH TIME ZONE,
    social_provider VARCHAR(50), -- 'google' ou 'facebook'
    social_provider_id VARCHAR(255), -- ID unique fourni par Google/Facebook
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE SET NULL
);

-- Table des propriétés
CREATE TABLE propertie (
    id INT PRIMARY KEY AUTO_INCREMENT,
    owner_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    price_per_night DECIMAL(10, 2) NOT NULL,
    max_guests INTEGER NOT NULL,
    amenities TEXT[], -- Tableau de chaînes pour les équipements
    photos TEXT[], -- Tableau de liens de photos
    is_validated BOOLEAN DEFAULT FALSE,
    address VARCHAR(500),
    city VARCHAR(100),
    country VARCHAR(100),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES user(id) ON DELETE SET NULL,
);

-- Table des offres de location
CREATE TABLE rental_offer (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT,
    special_price DECIMAL(10, 2),
    start_date DATE,
    end_date DATE,
    discount_percentage INTEGER CHECK (discount_percentage BETWEEN 0 AND 100),
    offer_type VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES propertie(id) ON DELETE SET NULL,
);

-- Table des réservations
CREATE TABLE booking (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT,
    traveler_id INT,
    check_in_date DATE NOT NULL,
    check_out_date DATE NOT NULL,
    guest_count INTEGER NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) DEFAULT 'PENDING',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT valid_dates CHECK (check_out_date > check_in_date),
    FOREIGN KEY (property_id) REFERENCES propertie(id) ON DELETE SET NULL,
    FOREIGN KEY (traveler_id) REFERENCES user(id) ON DELETE SET NULL
);

-- Table des avis
CREATE TABLE review (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT,
    traveler_id INT,
    rating INTEGER CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(property_id, traveler_id),
    FOREIGN KEY (property_id) REFERENCES propertie(id) ON DELETE SET NULL,
    FOREIGN KEY (traveler_id) REFERENCES user(id) ON DELETE SET NULL
);

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