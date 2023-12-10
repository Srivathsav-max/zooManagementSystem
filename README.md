```
CREATE TABLE Employee (
  EmployeeID INT PRIMARY KEY AUTO_INCREMENT,
  StartDate VARCHAR(255) NOT NULL,
  JobType VARCHAR(255) NOT NULL,
  FirstName VARCHAR(255) NOT NULL,
  MiddleName VARCHAR(255),
  LastName VARCHAR(255) NOT NULL,
  Street VARCHAR(255) NOT NULL,
  City VARCHAR(255) NOT NULL,
  State VARCHAR(255) NOT NULL,
  Zip VARCHAR(255) NOT NULL,
  SuperID INT REFERENCES Employee(EmployeeID),
  HourlyRateID INT REFERENCES HourlyRate(ID),
  ConcessionID INT REFERENCES Concession(ID),
  ZooAdmissionID INT REFERENCES ZooAdmission(ID)
);

CREATE TABLE HourlyRate (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  HourlyRate VARCHAR(255) NOT NULL
);

CREATE TABLE Animal (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  Status VARCHAR(255) NOT NULL,
  BirthYear DATE NOT NULL,
  SpeciesID INT REFERENCES Species(ID),
  EnclosureID INT REFERENCES Enclosure(ID),
  BuildingID INT REFERENCES Building(ID)
);

CREATE TABLE Species (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  FoodCost INT NOT NULL
);

CREATE TABLE Building (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(255) NOT NULL,
  Type VARCHAR(255) NOT NULL
);

CREATE TABLE Enclosure (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  BuildingID INT REFERENCES Building(ID),
  SqFt INT NOT NULL
);

CREATE TABLE RevenueType (
  ID INT PRIMARY KEY AUTO_INCREMENT,
  BuildingID INT REFERENCES Building(ID),
  Name VARCHAR(255) NOT NULL,
  Type VARCHAR(255) NOT NULL
);

CREATE TABLE RevenueEvents (
  ID INT REFERENCES RevenueType(ID),
  DateTime DATE PRIMARY KEY,
  Revenue INT NOT NULL,
  TicketsSold INT NOT NULL
);

CREATE TABLE AnimalShow (
  ID INT REFERENCES RevenueType(ID),
  ShowsPerDay INT NOT NULL,
  SeniorPrice INT NOT NULL,
  AdultPrice INT NOT NULL,
  ChildPrice INT NOT NULL
);

CREATE TABLE Concession (
  ID INT REFERENCES RevenueType(ID),
  Product VARCHAR(255) NOT NULL
);

CREATE TABLE ZooAdmission (
  ID INT REFERENCES RevenueType(ID),
  SeniorPrice INT NOT NULL,
  AdultPrice INT NOT NULL,
  ChildPrice INT NOT NULL
);

CREATE TABLE CaresFor (
  EmployeeID INT REFERENCES Employee(EmployeeID),
  SpeciesID INT REFERENCES Species(ID)
);

CREATE TABLE ParticipatesIN (
  SpeciesID INT REFERENCES Species(ID),
  AnimalShowID INT REFERENCES AnimalShow(ID),
  Reqd INT NOT NULL
);
CREATE TABLE ZooAdmissionTickets (
  TicketID INT PRIMARY KEY AUTO_INCREMENT,
  AnimalShowID INT REFERENCES AnimalShow(ID),
  AdultTickets INT NOT NULL,
  ChildTickets INT NOT NULL,
  SeniorTickets INT NOT NULL,
  Price DECIMAL(10, 2) NOT NULL,
  Attendance INT NOT NULL,
  Revenue DECIMAL(10, 2) NOT NULL,
  CheckoutTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE AnimalShowTickets (
  TicketID INT PRIMARY KEY AUTO_INCREMENT,
  AnimalShowID INT REFERENCES AnimalShow(ID),
  AdultTickets INT NOT NULL,
  ChildTickets INT NOT NULL,
  SeniorTickets INT NOT NULL,
  Price DECIMAL(10, 2) NOT NULL,
  Attendance INT NOT NULL,
  Revenue DECIMAL(10, 2) NOT NULL,
  CheckoutTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

```
