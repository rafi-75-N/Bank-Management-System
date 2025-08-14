

CREATE DATABASE bank_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bank_db;

CREATE TABLE Bank (
    BankCode INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    City VARCHAR(50) NOT NULL,
    Address VARCHAR(200) NOT NULL
);

CREATE TABLE Branch (
    BranchID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    City VARCHAR(50) NOT NULL,
    Address VARCHAR(200) NOT NULL,
    BankCode INT NOT NULL,
    CONSTRAINT fk_branch_bank FOREIGN KEY (BankCode) REFERENCES Bank(BankCode)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Customer (
    CustID INT AUTO_INCREMENT PRIMARY KEY,
    FName VARCHAR(50) NOT NULL,
    LName VARCHAR(50) NOT NULL,
    Address VARCHAR(200) NOT NULL,
    Contact VARCHAR(20) NOT NULL
);

CREATE TABLE Account (
    AccountNo INT AUTO_INCREMENT PRIMARY KEY,
    Balance DECIMAL(12,2) NOT NULL DEFAULT 0,
    AccountType CHAR(1) NOT NULL, -- 'C' current, 'S' savings
    MaximumLimit DECIMAL(12,2) NULL,
    YearlyFee DECIMAL(12,2) NULL,
    MinimumBalance DECIMAL(12,2) NULL,
    InterestRate DECIMAL(5,2) NULL,
    CustID INT NOT NULL,
    CONSTRAINT fk_account_customer FOREIGN KEY (CustID) REFERENCES Customer(CustID)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Employee (
    EmpID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100) NOT NULL,
    EmailID VARCHAR(100) NOT NULL,
    Address VARCHAR(200) NOT NULL,
    Contact VARCHAR(20) NOT NULL,
    Age INT NOT NULL,
    ManagerID INT NULL,
    CONSTRAINT fk_employee_manager FOREIGN KEY (ManagerID) REFERENCES Employee(EmpID)
        ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE Loan (
    LoanID INT AUTO_INCREMENT PRIMARY KEY,
    Amount DECIMAL(12,2) NOT NULL,
    Date DATE NOT NULL,
    PaidAmount DECIMAL(12,2) NOT NULL DEFAULT 0,
    BranchID INT NOT NULL,
    CustID INT NOT NULL,
    CONSTRAINT fk_loan_branch FOREIGN KEY (BranchID) REFERENCES Branch(BranchID)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_loan_customer FOREIGN KEY (CustID) REFERENCES Customer(CustID)
        ON UPDATE CASCADE ON DELETE RESTRICT
);

CREATE TABLE Payment (
    PaymentID INT AUTO_INCREMENT PRIMARY KEY,
    Amount DECIMAL(12,2) NOT NULL,
    PaymentDate DATE NOT NULL,
    LoanID INT NOT NULL,
    CONSTRAINT fk_payment_loan FOREIGN KEY (LoanID) REFERENCES Loan(LoanID)
        ON UPDATE CASCADE ON DELETE CASCADE
);

-- Sample data
INSERT INTO Bank (Name, City, Address) VALUES
('Alpha Bank', 'Dhaka', '1/A Road 10, Dhaka'),
('Beta Bank', 'Chattogram', '22 Agrabad, Chattogram');

INSERT INTO Branch (Name, City, Address, BankCode) VALUES
('Alpha Dhaka Branch', 'Dhaka', 'Uttara, Dhaka', 1),
('Alpha CTG Branch', 'Chattogram', 'Agrabad, CTG', 1),
('Beta Dhaka Branch', 'Dhaka', 'Banani, Dhaka', 2);

INSERT INTO Customer (FName, LName, Address, Contact) VALUES
('Rafi', 'Ahmed', 'Mirpur, Dhaka', '01700000000'),
('Sara', 'Khan', 'Banani, Dhaka', '01811111111');

INSERT INTO Account (Balance, AccountType, MaximumLimit, YearlyFee, MinimumBalance, InterestRate, CustID) VALUES
(50000, 'S', NULL, NULL, 5000, 4.50, 1),
(150000, 'C', 100000, 1000, NULL, NULL, 2);

INSERT INTO Employee (Name, EmailID, Address, Contact, Age, ManagerID) VALUES
('Arif Hossain', 'arif@example.com', 'Uttara, Dhaka', '01922222222', 35, NULL),
('Nadia Islam', 'nadia@example.com', 'Banani, Dhaka', '01633333333', 29, 1);

INSERT INTO Loan (Amount, Date, PaidAmount, BranchID, CustID) VALUES
(200000, '2024-07-01', 50000, 1, 1),
(350000, '2024-09-15', 150000, 3, 2);

INSERT INTO Payment (Amount, PaymentDate, LoanID) VALUES
(25000, '2024-08-01', 1),
(25000, '2024-09-01', 1),
(50000, '2024-10-10', 2);
