-- Création de la base de données
-- CREATE DATABASE airbnb;

-- Connexion à la base de données
-- \c airbnb;

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