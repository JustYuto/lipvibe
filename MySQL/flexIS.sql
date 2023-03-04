CREATE DATABASE IF NOT EXISTS `flexIS`;
USE `flexIS`;

CREATE TABLE EMPLOYEE(     
    employeeID VARCHAR(5) NOT NULL, 
    password VARCHAR(30) NOT NULL, 
    name VARCHAR (30) NOT NULL, 
    email VARCHAR (30) NOT NULL, 
    position VARCHAR (20) NOT NULL CHECK (position IN('Employee', 'Supervisor','HR Admin')), 
    FWAStatus VARCHAR (15) NOT NULL,  
    departmentID VARCHAR (5), 
    supervisorID VARCHAR (5), 
    CONSTRAINT EMP_PK PRIMARY KEY (employeeID), 
    CONSTRAINT EMP_FK1 FOREIGN KEY (supervisorID) REFERENCES EMPLOYEE(employeeID) ON DELETE CASCADE ON UPDATE CASCADE
); 

CREATE TABLE DEPARTMENT( 
    departmentID VARCHAR(5) NOT NULL, 
    deptName VARCHAR(20) NOT NULL, 
    employeeID VARCHAR(5),
    CONSTRAINT DEPARTMENT_PK PRIMARY KEY (departmentID)
); 

CREATE TABLE FWA_Rquest(     
    requestID VARCHAR(5) not null,     
    requestDate DATE not null,     
    workType VARCHAR(30) not null CHECK (workType IN('Flexi-hour', 'Work-from-home','Hybrid')), 
    description VARCHAR(255) not null, 
    reason VARCHAR(255) not null, 
    status VARCHAR(20) not null CHECK (status IN('Rejected','Accepted','Pending')), 
    comment VARCHAR(255), 
    employeeID VARCHAR(5), 
    CONSTRAINT fwa_Rqu_PK2 PRIMARY KEY (requestID)
); 

ALTER TABLE EMPLOYEE ADD 
	CONSTRAINT EMP_FK2 FOREIGN KEY (departmentID) REFERENCES DEPARTMENT (departmentID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DEPARTMENT ADD 
	CONSTRAINT Dp_FK FOREIGN KEY (employeeID) REFERENCES EMPLOYEE (employeeID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE FWA_Rquest ADD
    CONSTRAINT FWA_Rqu_FK FOREIGN KEY (employeeID) REFERENCES Employee(employeeID) ON DELETE CASCADE ON UPDATE CASCADE;
