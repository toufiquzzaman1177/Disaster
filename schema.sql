-- Disaster Table
CREATE TABLE Disaster (
    Disaster_ID INT AUTO_INCREMENT PRIMARY KEY,
    Type VARCHAR(50),
    Location VARCHAR(100),
    Date DATE,
    Severity_Level VARCHAR(20)
);

-- Victim Table
CREATE TABLE Victim (
    Victim_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Age INT,
    Location VARCHAR(100),
    Disaster_ID INT,
    FOREIGN KEY (Disaster_ID) REFERENCES Disaster(Disaster_ID)
);

-- Relief Center
CREATE TABLE Relief_Center (
    Center_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Location VARCHAR(100),
    Capacity INT
);

-- Relief Item
CREATE TABLE Relief_Item (
    Item_ID INT AUTO_INCREMENT PRIMARY KEY,
    Item_Name VARCHAR(100),
    Quantity INT
);

-- Distribution
CREATE TABLE Distribution (
    Distribution_ID INT AUTO_INCREMENT PRIMARY KEY,
    Victim_ID INT,
    Center_ID INT,
    Item_ID INT,
    Date_Distributed DATE,
    FOREIGN KEY (Victim_ID) REFERENCES Victim(Victim_ID),
    FOREIGN KEY (Center_ID) REFERENCES Relief_Center(Center_ID),
    FOREIGN KEY (Item_ID) REFERENCES Relief_Item(Item_ID)
);