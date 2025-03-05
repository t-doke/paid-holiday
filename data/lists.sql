CREATE TABLE lists (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- 主キー
    number INT NOT NULL,                  -- 社員番号
    name VARCHAR(255) NOT NULL,           -- 名前
    password VARCHAR(255) NOT NULL,       -- パスワード
    paid INT NOT NULL,                    -- 有給数
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- 作成日時
    updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- 更新日時
);
