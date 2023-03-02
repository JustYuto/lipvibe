CREATE DATABASE IF NOT EXISTS `flexIS`;
USE `flexIS`;

CREATE TABLE EMPLOYEE(     
    employeeID VARCHAR(5) NOT NULL, 
    password VARCHAR(30) NOT NULL, 
    name VARCHAR (30) NOT NULL, 
    email VARCHAR (30) NOT NULL, 
    position VARCHAR (20) NOT NULL, 
    FWAStatus VARCHAR (15) NOT NULL,  
    departmentID CHAR(5) NOT NULL, 
    supervisorID CHAR(5), 
    CONSTRAINT EMP_PK PRIMARY KEY (employeeID), 
    CONSTRAINT EMP_FK1 FOREIGN KEY (supervisorID) REFERENCES EMPLOYEE(employeeID) on delete cascade
); 

CREATE TABLE DEPARTMENT( 
    departmentID CHAR(5) NOT NULL, 
    deptName VARCHAR(20) NOT NULL, 
    CONSTRAINT DEPARTMENT_PK PRIMARY KEY (departmentID), 
    CONSTRAINT FWA_Rqu_FK FOREIGN KEY (employeeID) REFERENCES Employee(employeeID) on delete cascade
); 

CREATE TABLE FWA_Rquest(     
    requestID CHAR(5) not null,     
    requestDate DATE not null,     
    workType VARCHAR(30) not null, 
    description VARCHAR(255) not null, 
    reason VARCHAR(255) not null, 
    status VARCHAR(20) not null, 
    comment VARCHAR(255), 
    employeeID CHAR(5) not null, 
    CONSTRAINT FWA_Rqu_PK PRIMARY KEY (requestID), 
    CONSTRAINT FWA_Rqu_FK FOREIGN KEY (employeeID) REFERENCES Employee(employeeID) on delete cascade, 
    CONSTRAINT FWA_Rqu_CHK check (workType = 'Flexi-hour' or workType = 'Work-from-home', or workType = 'Hybrid'), 
    CONSTRAINT FWA_Rqu_CHK1 check (status ='Failed' or status ='Accepted' or status='Progress')
); 

ALTER TABLE DEPARTMENT
  ADD CONSTRAINT EMP_FK2 FOREIGN KEY (departmentID) REFERENCES DEPARTMENT (departmentID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DEPARTMENT
  ADD CONSTRAINT FWA_Rqu_FK FOREIGN KEY (employeeID) REFERENCES EMPLOYEE (employeeID) ON DELETE CASCADE ON UPDATE CASCADE;