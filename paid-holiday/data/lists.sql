CREATE TABLE lists (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- 主キー
    number VARCHAR(255) NOT NULL,         -- 社員番号
    name VARCHAR(255) NOT NULL,           -- 名前
    password VARCHAR(255) NOT NULL,       -- パスワード
    paid INT NOT NULL,                    -- 有給数
    company_id VARCHAR(255) NOT NULL,       -- 企業ID
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- 作成日時
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- 更新日時
);
