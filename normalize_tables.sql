-- Таблица событий
CREATE TABLE events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    event_date DATETIME NOT NULL,
    event_name VARCHAR(255) NOT NULL
);

-- Таблица пользователей
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    user_name VARCHAR(255) NOT NULL
);

-- Таблица типов билетов для каждого события
CREATE TABLE ticket_types (
    ticket_type_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    type_name VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Таблица заказов
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    created DATETIME NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Таблица билетов в заказах
CREATE TABLE order_tickets (
    order_ticket_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    ticket_type_id INT,
    ticket_quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (ticket_type_id) REFERENCES ticket_types(ticket_type_id)
);

-- Таблица индивидуальных билетов
CREATE TABLE tickets (
    ticket_id INT PRIMARY KEY AUTO_INCREMENT,
    order_ticket_id INT,
    barcode VARCHAR(20) UNIQUE NOT NULL,
    FOREIGN KEY (order_ticket_id) REFERENCES order_tickets(order_ticket_id) ON DELETE CASCADE
);


-- Вставка событий
INSERT INTO events (event_date, event_name) VALUES
    ('2023-12-01 19:00:00', 'Концерт симфонического оркестра'),
    ('2024-01-10 09:00:00', 'Конференция по IT-технологиям');

-- Вставка пользователей
INSERT INTO users (user_name) VALUES
    ('Иван Иванов'),
    ('Мария Смирнова');

-- Вставка типов билетов с уникальной ценой для каждого события
-- Предполагаем, что event_id автоматически присвоен как 1 и 2 для добавленных событий
INSERT INTO ticket_types (event_id, type_name, price) VALUES
    (1, 'adult', 700.00),
    (1, 'kid', 450.00),
    (1, 'discount', 500.00),  -- Льготный билет для Концерта
    (1, 'group', 2000.00),    -- Групповой билет для Концерта
    (2, 'adult', 1000.00),
    (2, 'kid', 600.00),
    (2, 'discount', 800.00),  -- Льготный билет для Конференции
    (2, 'group', 4000.00);    -- Групповой билет для Конференции

-- Вставка заказов
-- Предполагаем, что user_id автоматически присвоен как 1 и 2 для добавленных пользователей
INSERT INTO orders (event_id, user_id, total_price, created) VALUES
    (1, 1, 1200.00, '2023-11-20 13:22:09'),
    (2, 2, 1600.00, '2023-11-22 14:30:08');

-- Вставка билетов в заказах
INSERT INTO order_tickets (order_id, ticket_type_id, ticket_quantity) VALUES
    (1, 1, 2),  -- Заказ на 2 взрослых билета для события 1
    (1, 3, 4),  -- Заказ на 4 льготных билета для события 1
    (2, 6, 3);  -- Заказ на 3 детских билета для события 2

-- Вставка индивидуальных билетов с уникальными баркодами для каждого билета
-- Предполагаем, что order_ticket_id присвоен как 1, 2, и 3
INSERT INTO tickets (order_ticket_id, barcode) VALUES
    (1, 'BARCODE001'),
    (1, 'BARCODE002'),
    (2, 'BARCODE003'),
    (2, 'BARCODE004'),
    (2, 'BARCODE005'),
    (2, 'BARCODE006'),
    (2, 'BARCODE007'),
    (3, 'BARCODE008'),
    (3, 'BARCODE009'),
    (3, 'BARCODE010');