


CREATE DATABASE bank_management CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bank_management;

-- 1) Banks
CREATE TABLE banks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bank_code VARCHAR(20) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL,
  city VARCHAR(80),
  address VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2) Branches (belongs to a bank)
CREATE TABLE branches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  branch_code VARCHAR(20) NOT NULL UNIQUE,
  bank_id INT NOT NULL,
  name VARCHAR(120) NOT NULL,
  city VARCHAR(80),
  address VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_branch_bank FOREIGN KEY (bank_id) REFERENCES banks(id) ON DELETE CASCADE
);

-- 3) Customers (auth-enabled)
CREATE TABLE customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cust_code VARCHAR(20) NOT NULL UNIQUE,
  first_name VARCHAR(80) NOT NULL,
  last_name VARCHAR(80) NOT NULL,
  address VARCHAR(255),
  contact VARCHAR(40),
  email VARCHAR(120) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4) Employees (auth-enabled; admins)
CREATE TABLE employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  emp_code VARCHAR(20) NOT NULL UNIQUE,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  address VARCHAR(255),
  contact VARCHAR(40),
  age INT,
  branch_id INT,
  manager_id INT NULL,
  is_admin TINYINT(1) NOT NULL DEFAULT 1,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_emp_branch FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE SET NULL,
  CONSTRAINT fk_emp_manager FOREIGN KEY (manager_id) REFERENCES employees(id) ON DELETE SET NULL
);

-- 5) Accounts (single-table inheritance via account_type)
CREATE TABLE accounts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  account_no BIGINT NOT NULL UNIQUE,
  cust_id INT NOT NULL,
  employee_id INT NULL, -- who created/manages it
  account_type ENUM('SAVINGS','CURRENT') NOT NULL,
  balance DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  -- Current account-only (nullable otherwise)
  maximum_limit DECIMAL(12,2) NULL,
  yearly_fee DECIMAL(12,2) NULL,
  -- Savings account-only (nullable otherwise)
  minimum_balance DECIMAL(12,2) NULL,
  interest_rate DECIMAL(5,2) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_acc_customer FOREIGN KEY (cust_id) REFERENCES customers(id) ON DELETE CASCADE,
  CONSTRAINT fk_acc_employee FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE SET NULL
);

-- 6) Loans (approved by admin employees)
CREATE TABLE loans (
  id INT AUTO_INCREMENT PRIMARY KEY,
  loan_code VARCHAR(20) NOT NULL UNIQUE,
  cust_id INT NOT NULL,
  branch_id INT NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  loan_date DATE NOT NULL,
  paid_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  status ENUM('PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  approved_by INT NULL,
  approved_at DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_loan_customer FOREIGN KEY (cust_id) REFERENCES customers(id) ON DELETE CASCADE,
  CONSTRAINT fk_loan_branch FOREIGN KEY (branch_id) REFERENCES branches(id) ON DELETE CASCADE,
  CONSTRAINT fk_loan_approver FOREIGN KEY (approved_by) REFERENCES employees(id) ON DELETE SET NULL
);

-- 7) Payments (towards loans)
CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  payment_code VARCHAR(20) NOT NULL UNIQUE,
  loan_id INT NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  payment_date DATE NOT NULL,
  recorded_by INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_payment_loan FOREIGN KEY (loan_id) REFERENCES loans(id) ON DELETE CASCADE,
  CONSTRAINT fk_payment_emp FOREIGN KEY (recorded_by) REFERENCES employees(id) ON DELETE SET NULL
);

-- Useful indexes
CREATE INDEX idx_accounts_cust ON accounts(cust_id);
CREATE INDEX idx_loans_cust ON loans(cust_id);

-- Seed some demo data including an initial admin employee (password: Admin@123)
INSERT INTO banks (bank_code, name, city, address) VALUES
('B001','Blue Sky Bank','Dhaka','1 Finance Ave'),
('B002','River State Bank','Chittagong','22 Harbor Rd');

INSERT INTO branches (branch_code, bank_id, name, city, address) VALUES
('BR001',1,'Main Branch','Dhaka','1 Finance Ave'),
('BR002',1,'Uttara Branch','Dhaka','123 Uttara'),
('BR101',2,'Harbor Branch','Chittagong','22 Harbor Rd');

-- Admin employee
INSERT INTO employees (emp_code, name, email, address, contact, age, branch_id, is_admin, password_hash)
VALUES ('EMP001','System Admin','admin@bank.com','HQ','555-2001',35,1,1, 
  '$2y$10$Rz9Yf6qP5w1DqK0g2Q6L2uYV6x0x3Ciz6c2eN9Y0Ih8kQ0kq1fL1C'); 
-- The above is bcrypt for 'Admin@123'

-- Two customers (password: Cust@123)
INSERT INTO customers (cust_code, first_name, last_name, address, contact, email, password_hash) VALUES
('C001','Michael','Johnson','123 Admin St, Dhaka','555-0001','michael@example.com',
 '$2y$10$1c8mF1xGq4kko0dYx9x2je3L0eCIt73q0g9E3kCwqzGfX7J9qX9dK'), 
('C002','Sarah','Williams','456 Manager Ave, Dhaka','555-0002','sarah@example.com',
 '$2y$10$1c8mF1xGq4kko0dYx9x2je3L0eCIt73q0g9E3kCwqzGfX7J9qX9dK');

-- An example account
INSERT INTO accounts (account_no, cust_id, employee_id, account_type, balance, minimum_balance, interest_rate)
VALUES (100000001, 1, 1, 'SAVINGS', 5000.00, 1000.00, 3.50);

-- One loan (pending)
INSERT INTO loans (loan_code, cust_id, branch_id, amount, loan_date, status) 
VALUES ('L001',1,1,20000.00, CURDATE(), 'PENDING');
