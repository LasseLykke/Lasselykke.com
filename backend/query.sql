CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    shortDescription TEXT NOT NULL,
    longDescription TEXT NOT NULL,
    tags VARCHAR(255), -- Kommasepareret liste af tags
    imagePaths JSON NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);