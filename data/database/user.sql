 CREATE TABLE user (
      uuid VARCHAR(255) NOT NULL,
      email VARCHAR(255) NOT NULL,
      password VARCHAR(255) NOT NULL,
      username VARCHAR(255) NOT NULL,
      description VARCHAR(255) DEFAULT NULL,
      role_mask VARCHAR(25) DEFAULT "1",
      status INT(1) DEFAULT 1,
      last_login DATETIME DEFAULT NULL,
      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
      deleted_at DATETIME DEFAULT NULL,
      PRIMARY KEY(uuid)
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;