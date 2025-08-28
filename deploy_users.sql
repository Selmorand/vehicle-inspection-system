-- Deploy known users to staging server
-- Run this on staging database: alphains_production

-- User: Admin User (admin@alphainspections.co.za) - Password: admin123
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES ('Admin User', 'admin@alphainspections.co.za', '$2y$10$PJuVLrBE96JdZuck2ckURurO.RJmzblIFFyTn7u4FGddKmPPp9vsO', 'admin', NOW(), NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  password = '$2y$10$PJuVLrBE96JdZuck2ckURurO.RJmzblIFFyTn7u4FGddKmPPp9vsO',
  role = 'admin',
  updated_at = NOW();

-- User: John Inspector (inspector@alphainspections.co.za) - Password: inspector123
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES ('John Inspector', 'inspector@alphainspections.co.za', '$2y$10$m7eHwxulX7bnUYvGGK87keIhj/SzfDiWEJSCwkTAYKP145E9i3wM2', 'inspector', NOW(), NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  password = '$2y$10$m7eHwxulX7bnUYvGGK87keIhj/SzfDiWEJSCwkTAYKP145E9i3wM2',
  role = 'inspector',
  updated_at = NOW();

-- User: Jane User (user@alphainspections.co.za) - Password: user123
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES ('Jane User', 'user@alphainspections.co.za', '$2y$10$pnRJBQQQyGv4E/p8N/Unbu/DpmigWzTYoqrw.paIpRsHhpN0zGAFm', 'user', NOW(), NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  password = '$2y$10$pnRJBQQQyGv4E/p8N/Unbu/DpmigWzTYoqrw.paIpRsHhpN0zGAFm',
  role = 'user',
  updated_at = NOW();

