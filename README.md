# Drug Dispensary Project

The **Drug Dispensary Project** is a web-based system developed using PHP, HTML, JavaScript, and MySQL to manage patients, doctors, pharmacists, and prescriptions in a healthcare setting. The system streamlines drug dispensing, prescription tracking, and patient management while providing secure access for different user roles.

---

## Project Overview

This system was designed to simplify and automate the workflow of a pharmacy or healthcare facility. It allows doctors to prescribe drugs to patients, pharmacists to dispense medications, and administrators to manage users, drugs, and inventory efficiently. The platform also includes reminders for patients and reporting tools for monitoring prescriptions.

**Key objectives:**

- Efficient management of prescriptions and drug dispensing
- Role-based access for doctors, pharmacists, and administrators
- Secure storage of patient and prescription data
- Tracking of dispensed drugs and inventory
- Simplified user interface for all roles

---

## Key Features

- User authentication for **admin**, **doctor**, **pharmacist**, and **patient**
- Doctor module: Create, edit, and view prescriptions, manage appointments
- Pharmacist module: Dispense drugs, manage inventory, view prescriptions
- Admin module: Manage users, drugs, and system configuration
- Patient module: View prescriptions, appointments, and reminders
- Search functionality for patients and prescriptions
- Reminders for patients on medication schedules
- Responsive and interactive UI using HTML, CSS, and JavaScript

---

## Technologies Used

- **Backend:** PHP (XAMPP localhost)  
- **Frontend:** HTML, CSS, JavaScript  
- **Database:** MySQL (XAMPP)  
- **Tools:** VSCode, XAMPP  

---

## System Requirements

- XAMPP with Apache and MySQL
- PHP 7.4+ (compatible with XAMPP version)
- Web browser (Chrome, Firefox, or Edge)
- VSCode or preferred code editor

---

## Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/P-Alingo/drugdispensaryproject.git
cd drugdispensaryproject

2. Move Project to XAMPP htdocs

Copy the project folder to the htdocs directory of your XAMPP installation:

C:\xampp\htdocs\

3. Start XAMPP

Start Apache and MySQL modules in XAMPP Control Panel

4. Database Setup

Open phpMyAdmin (http://localhost/phpmyadmin
)

Create a database (e.g., drug_dispensary)

Import the SQL file if provided, or create tables manually using the included PHP scripts

5. Configure Database Connection

Open connection.php

Update the database credentials if necessary:

$host = "localhost";
$user = "root";
$password = "";
$dbname = "drug_dispensary";

6. Access the Application

Open your browser and navigate to:

http://localhost/drugdispensaryproject/


Use the login pages to access Admin, Doctor, Pharmacist, or Patient modules

Project Structure
drugdispensaryproject/
├── admin_add_drug.php
├── admin_edit_drugs.php
├── admin_login.php
├── admin_manage_drugs.php
├── admin_profile.php
├── connection.php
├── doctor_login.php
├── doctor_prescription.php
├── doctor_profile.php
├── patient_login.php
├── patient_prescription.php
├── pharmacist_dispense_drug.php
├── pharmacist_login.php
├── pharmacist_profile.php
├── project.css
├── uploads/                 # Images of drugs
├── .html files              # Signup/login pages
├── .php files               # Backend scripts
└── README.md

User Roles

Admin: Manage users, drugs, and system settings

Doctor: Create and update prescriptions, manage appointments

Pharmacist: Dispense drugs, manage inventory, view prescriptions

Patient: View prescriptions, appointments, and reminders

Notes for Reviewers

Demonstrates practical use of PHP, MySQL, and JavaScript for a healthcare workflow

Implements role-based access control

Includes prescription tracking, reminders, and inventory management

Fully functional on localhost using XAMPP

License

This project was developed for academic and learning purposes.
