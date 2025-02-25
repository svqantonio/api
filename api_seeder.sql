-- Desactivar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminar los datos de las tablas
DELETE FROM products;
DELETE FROM providers;

-- Insertar el proveedor
INSERT INTO providers (name, surnames, email, provider_id, secret_key)
VALUES ('Antonio', 'Gomez Rodriguez', 'antoniogomezrodriguez2000@gmail.com', 'c2ac07cafartwetsdAD52356FEDGeEYIq3cFQQKXuB5ajt4S19Pu8GFZFzaG', 'a2aa07aafartwetsdAD52356FEDGeBpRThivTwnhQIK9MZReKepFiF44aERm');

-- Obtener el `id` del proveedor recién insertado
SET @provider_id = (SELECT id FROM providers WHERE email = 'antoniogomezrodriguez2000@gmail.com');

-- Insertar los productos usando el `id` del proveedor
INSERT INTO products (name, description, provider, price)
VALUES
    ('TV', 'A television is an electronic device that receives broadcast signals and displays them as moving images with sound. Its commonly used for entertainment, news, and educational programming.', @provider_id, 500),
    ('Laptop', 'A laptop is a portable personal computer with an integrated screen and keyboard. Its designed for mobile use, allowing users to perform various tasks like browsing the internet, running software applications, and gaming.', @provider_id, 599),
    ('Mobile', 'A mobile phone is a handheld device that allows for voice and text communication. It often includes features like internet access, a camera, and various applications for social media, productivity, and entertainment.', @provider_id, 900),
    ('Watch', 'A watch is a portable timepiece worn on the wrist, typically displaying hours, minutes, and sometimes seconds. It can be analog or digital and often includes additional features like date display, alarms, and stopwatch functions.', @provider_id, 100),
    ('Screen', 'A screen refers to a flat surface used for displaying visual information. It can be part of devices like TVs, computers, and smartphones, showing images and videos through pixels or LEDs.', @provider_id, 150),
    ('Book', 'A book is a physical or digital collection of pages bound together, containing written or printed text and often illustrations. It serves as a medium for storytelling, information sharing, and education.', @provider_id, 20),
    ('Bag', 'A bag is a flexible container typically used for carrying belongings. It comes in various sizes and styles, often equipped with handles or straps for easy carrying. Bags are essential for daily use, travel, and storage purposes.', @provider_id, 5),
    ('Apple', 'An apple is a round fruit with crisp flesh and a core containing seeds. It comes in various colors such as red, green, or yellow, and is known for its sweet or tart taste. Apples are nutritious, often eaten fresh or used in cooking, baking, and making beverages like cider.', @provider_id, 2),
    ('Keyboard', 'A keyboard is a peripheral input device for computers and other electronic devices. It consists of keys arranged in a specific layout, allowing users to input text, commands, and perform functions. Keyboards can be wired or wireless and are essential for typing, gaming, and controlling software interfaces.', @provider_id, 50),
    ('Mouse', 'A mouse is a hand-held input device used with computers. It typically has buttons and a scroll wheel, allowing users to control the cursor on the screen by moving it on a flat surface. Mice are essential for navigating graphical user interfaces, selecting items, and performing actions like clicking and dragging.', @provider_id, 20),
    ('PS5', 'The PS5, or PlayStation 5, is Sony´s latest video game console featuring advanced graphics, high-speed SSD storage, and a new controller with haptic feedback and adaptive triggers. It supports 4K gaming, ray-tracing technology, and immersive audio, enhancing gaming experiences significantly.', @provider_id, 500),
    ('Xbox One', 'The Xbox One is a gaming console developed by Microsoft, featuring powerful hardware, Blu-ray capability, and access to a variety of entertainment apps. It supports multiplayer gaming, streaming services, and integration with Windows 10 for gaming and media.', @provider_id, 450),
    ('Nintendo Switch', 'The Nintendo Switch is a hybrid gaming console that can be used as a handheld device or connected to a TV. It features detachable Joy-Con controllers, offering versatile gameplay options for single-player and multiplayer experiences. The Switch supports a wide range of games from Nintendo''s franchises and third-party developers, emphasizing portability and social gaming.', @provider_id, 300),
    ('iPhone 14 Pro Max', 'The iPhone 14 Pro Max is Apple´s flagship smartphone known for its large OLED display, powerful A-series chip, and advanced camera system. It offers features like 5G connectivity, Face ID for security, and iOS ecosystem integration, making it ideal for multimedia consumption, productivity, and photography enthusiasts.', @provider_id, 1300);

-- Reactivar la verificación de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;
