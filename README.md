# QR Code Attendance Tracking System

## Overview
The QR Code Attendance Tracking System is a web-based application that allows lecturers to generate QR codes for sessions and enables students to scan them to mark attendance.

The system ensures:
- Accurate attendance tracking
- Prevention of duplicate records
- Secure access through authentication
- Real-time interaction between frontend and backend

---

## Features
 
### Authentication
- Student and Lecturer signup
- Login and logout functionality
- Session-based access control

### QR Code System
- Lecturer generates QR codes for sessions
- Students scan QR codes to mark attendance

### Attendance Management
- Automatic attendance recording
- Duplicate scan prevention
- Session-based attendance tracking

### Dashboards
- Student dashboard (view attendance history)
- Lecturer dashboard (view session attendance)

---

## System Architecture

### Frontend
- HTML, CSS, JavaScript
- QR Scanner (JavaScript)

### Backend
- PHP
- REST-style request handling

### Database
- MySQL (via WAMP/phpMyAdmin)

### QR Library
- `phpqrcode` (QR generation)

---

## ⚙️ Setup Instructions (WAMP)

### 1. Install WAMP
Download and install WAMP server.

### 2. Place Project
Move project folder to: C:\wamp64\www\

### 3. Start WAMP
- Ensure WAMP icon is green
- Apache and MySQL must be running

### 4. Create Database
- Open: http://localhost/phpmyadmin
- Create database (e.g. `attendance_db`)
- Import or create required tables

### 5. Configure Database
Update:config/db.php

### 6. Run Application
Open in browser: http://localhost/attendance-system/


---

## User Roles

### Student
- Sign up and log in
- Scan QR code
- View attendance history

### Lecturer
- Generate QR codes
- View attendance records
- Manage sessions

---

## Agile / Scrum Workflow

This project follows Scrum principles:

### Roles
- Product Owner
- Scrum Master
- Backend Developers (2)
- Frontend Developers (2)
- Tester (QA)

---

### Sprint Breakdown

#### Sprint 1
- Authentication system
- QR generation
- QR scanning
- Basic attendance recording

#### Sprint 2
- Dashboards (student + lecturer)
- Validation and error handling
- Testing and bug fixing

---
## Testing

Testing includes:

- Functional testing
- Validation testing
- Integration testing
- Usability testing

### Key Tested Scenarios
- Valid and invalid login
- QR generation and scanning
- Duplicate attendance prevention
- Dashboard data accuracy
- Unauthorized access prevention

---

## Known Issues (Resolved)

- Duplicate attendance risk → Fixed with validation
- Invalid QR codes accepted → Fixed with verification logic
- Unauthorized page access → Fixed with session checks
- Empty form submission → Fixed with validation

---

## Future Improvements

- Time-based QR code expiration
- GPS/location validation
- Real-time attendance updates
- Improved UI/UX design

---


## Contributors

Natasha Chilinda	221143122

Chamelda Gertze	224022024

Hermaine Kharugas	224001833

Josua Uuyuni	223064831

Kuiiri Hengari	220125384

Jordan Hashikuni	224081306


