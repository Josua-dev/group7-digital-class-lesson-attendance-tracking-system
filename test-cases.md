# Test Cases – QR Code Attendance Tracking System

## Project Name
Attendance Tracking System

## Testing Role
Quality Assurance / Tester

## Objective
The purpose of this testing document is to verify that the QR Code Attendance Tracking System functions correctly, handles invalid input properly, records attendance accurately, and supports both lecturer and student activities without errors.

## Scope of Testing
This testing covers the following modules:
- Authentication
- QR Code Generation
- QR Code Scanning
- Attendance Recording
- Student Dashboard
- Lecturer Dashboard
- Attendance History and Session Details
- Input Validation
- Error Handling
- Integration of frontend, backend, and database

## Test Environment
- Operating System: Windows
- Editor/Platform: VS Code
- Local Server: WAMP
- Browser: Google Chrome / Microsoft Edge
- Database: MySQL / phpMyAdmin
- Device for QR scanning: Smartphone or laptop camera

---

## Test Case Format
Each test case includes:
- Test Case ID
- Module
- Test Description
- Preconditions
- Steps
- Expected Result
- Actual Result
- Status

---

# 1. Authentication Testing

## TC001 – Successful student signup
**Module:** Authentication  
**Preconditions:** Signup page is accessible.  
**Steps:**
1. Open `signup.html`.
2. Enter valid student details.
3. Submit the form.

**Expected Result:**  
Student account is created successfully and user is redirected to login page or shown a success message.

**Actual Result:**  
Account created successfully.

**Status:** PASS

---

## TC002 – Successful lecturer signup
**Module:** Authentication  
**Preconditions:** Signup page is accessible.  
**Steps:**
1. Open `signup.html`.
2. Enter valid lecturer details.
3. Submit the form.

**Expected Result:**  
Lecturer account is created successfully.

**Actual Result:**  
Lecturer account created successfully.

**Status:** PASS

---

## TC003 – Login with valid credentials
**Module:** Authentication  
**Preconditions:** User account already exists.  
**Steps:**
1. Open `index.html`.
2. Enter correct login details.
3. Click login.

**Expected Result:**  
User is authenticated and redirected to the correct dashboard.

**Actual Result:**  
User logged in successfully and redirected correctly.

**Status:** PASS

---

## TC004 – Login with invalid password
**Module:** Authentication  
**Preconditions:** User account already exists.  
**Steps:**
1. Open `index.html`.
2. Enter correct username and incorrect password.
3. Click login.

**Expected Result:**  
System displays an error message and denies access.

**Actual Result:**  
Error message displayed and login denied.

**Status:** PASS

---

## TC005 – Login with empty fields
**Module:** Authentication  
**Preconditions:** Login page is accessible.  
**Steps:**
1. Open `index.html`.
2. Leave username and password blank.
3. Click login.

**Expected Result:**  
System should not log in user and should display validation error.

**Actual Result:**  
Validation message displayed.

**Status:** PASS

---

## TC006 – Logout functionality
**Module:** Authentication  
**Preconditions:** User is logged in.  
**Steps:**
1. Click logout.

**Expected Result:**  
User session is destroyed and user is redirected to login page.

**Actual Result:**  
Logout successful.

**Status:** PASS

---

# 2. QR Code Generation Testing

## TC007 – Generate QR code for a valid session
**Module:** QR Generation  
**Preconditions:** Lecturer is logged in and session is available.  
**Steps:**
1. Open `lecturer/generate_qr.php`.
2. Generate QR code.

**Expected Result:**  
QR code is generated and displayed correctly.

**Actual Result:**  
QR code generated successfully.

**Status:** PASS

---

## TC008 – QR code displays without page error
**Module:** QR Generation  
**Preconditions:** Lecturer dashboard is accessible.  
**Steps:**
1. Navigate to QR generation page.
2. Generate QR code.

**Expected Result:**  
No PHP warnings or broken image errors appear.

**Actual Result:**  
Page loads correctly and QR displays properly.

**Status:** PASS

---

# 3. QR Scanning Testing

## TC009 – Student scans valid QR code
**Module:** QR Scanning  
**Preconditions:** Student is logged in and a valid QR code has been generated.  
**Steps:**
1. Open `student/scan.php`.
2. Scan a valid QR code.

**Expected Result:**  
QR data is read and sent for attendance processing.

**Actual Result:**  
QR scanned successfully and request processed.

**Status:** PASS

---

## TC010 – Student scans invalid QR code
**Module:** QR Scanning  
**Preconditions:** Student is logged in.  
**Steps:**
1. Open scanner.
2. Scan a QR code that does not belong to the attendance system.

**Expected Result:**  
System rejects the QR code and shows an invalid QR message.

**Actual Result:**  
Invalid QR rejected correctly.

**Status:** PASS

---

## TC011 – Student scans without being logged in
**Module:** QR Scanning  
**Preconditions:** No active user session.  
**Steps:**
1. Navigate directly to `student/scan.php`.
2. Attempt to scan QR.

**Expected Result:**  
System should block access or redirect user to login page.

**Actual Result:**  
Access denied / redirected to login.

**Status:** PASS

---

# 4. Attendance Recording Testing

## TC012 – Attendance is saved after valid scan
**Module:** Attendance  
**Preconditions:** Student is logged in and scans valid QR.  
**Steps:**
1. Scan valid QR.
2. Check database record.

**Expected Result:**  
A new attendance record is inserted into the database with correct user and session details.

**Actual Result:**  
Attendance record saved correctly.

**Status:** PASS

---

## TC013 – Duplicate attendance scan is prevented
**Module:** Attendance  
**Preconditions:** Student has already been marked present for the same session.  
**Steps:**
1. Scan valid QR once.
2. Scan the same QR again.

**Expected Result:**  
Second scan should be rejected or ignored, and no duplicate record should be inserted.

**Actual Result:**  
Duplicate attendance prevented.

**Status:** PASS

---

## TC014 – Attendance linked to correct student
**Module:** Attendance  
**Preconditions:** Multiple users exist.  
**Steps:**
1. Login as Student A and scan QR.
2. Check database.

**Expected Result:**  
Attendance record belongs to Student A only.

**Actual Result:**  
Record linked correctly.

**Status:** PASS

---

## TC015 – Attendance linked to correct session
**Module:** Attendance  
**Preconditions:** Session is active.  
**Steps:**
1. Scan QR for a specific session.
2. Check attendance table.

**Expected Result:**  
Attendance is recorded under the correct session.

**Actual Result:**  
Session mapping correct.

**Status:** PASS

---

# 5. Student Dashboard Testing

## TC016 – Student dashboard loads correctly
**Module:** Student Dashboard  
**Preconditions:** Student is logged in.  
**Steps:**
1. Open `student/dashboard.php`.

**Expected Result:**  
Student dashboard loads without errors.

**Actual Result:**  
Dashboard displayed correctly.

**Status:** PASS

---

## TC017 – Attendance history displays correctly
**Module:** Student History  
**Preconditions:** Student has attendance records.  
**Steps:**
1. Open `student/history.php`.

**Expected Result:**  
System displays previous attendance records correctly.

**Actual Result:**  
History shown correctly.

**Status:** PASS

---

# 6. Lecturer Dashboard Testing

## TC018 – Lecturer dashboard loads correctly
**Module:** Lecturer Dashboard  
**Preconditions:** Lecturer is logged in.  
**Steps:**
1. Open `lecturer/dashboard.php`.

**Expected Result:**  
Dashboard loads successfully.

**Actual Result:**  
Dashboard displayed correctly.

**Status:** PASS

---

## TC019 – Lecturer can view attendance list
**Module:** Lecturer Attendance  
**Preconditions:** Attendance records exist.  
**Steps:**
1. Open `lecturer/attendance.php`.

**Expected Result:**  
List of students who attended is displayed.

**Actual Result:**  
Attendance list displayed correctly.

**Status:** PASS

---

## TC020 – Lecturer can view session details
**Module:** Session Details  
**Preconditions:** Session exists.  
**Steps:**
1. Open `lecturer/session_details.php`.

**Expected Result:**  
System displays the correct session information.

**Actual Result:**  
Session details displayed correctly.

**Status:** PASS

---

# 7. Validation and Error Handling Testing

## TC021 – System handles missing form fields during signup
**Module:** Validation  
**Preconditions:** Signup page accessible.  
**Steps:**
1. Leave one or more required fields blank.
2. Submit form.

**Expected Result:**  
System prevents submission and shows validation error.

**Actual Result:**  
Validation works correctly.

**Status:** PASS

---

## TC022 – System handles direct page access without permission
**Module:** Security / Access Control  
**Preconditions:** No active login.  
**Steps:**
1. Directly enter lecturer or student page URL.

**Expected Result:**  
Access is denied or redirected.

**Actual Result:**  
Unauthorised access prevented.

**Status:** PASS

---

## TC023 – System handles invalid session QR
**Module:** Validation  
**Preconditions:** Invalid or expired session data used.  
**Steps:**
1. Scan QR code with invalid session reference.

**Expected Result:**  
Attendance is not marked and error is shown.

**Actual Result:**  
Invalid session rejected.

**Status:** PASS

---

# 8. Integration Testing

## TC024 – Full end-to-end attendance flow
**Module:** Integration  
**Preconditions:** Lecturer and student accounts exist.  
**Steps:**
1. Lecturer logs in.
2. Lecturer generates QR code.
3. Student logs in.
4. Student scans QR code.
5. System records attendance.
6. Lecturer checks attendance list.
7. Student checks history.

**Expected Result:**  
Entire workflow executes successfully without failure.

**Actual Result:**  
End-to-end flow successful.

**Status:** PASS

---

## TC025 – Frontend, backend, and database integration
**Module:** Integration  
**Preconditions:** System configured correctly.  
**Steps:**
1. Perform valid login.
2. Generate QR.
3. Scan QR.
4. Inspect database.

**Expected Result:**  
All connected components work together correctly.

**Actual Result:**  
Integration verified successfully.

**Status:** PASS

---

# 9. Usability Testing

## TC026 – Login interface is understandable
**Module:** Usability  
**Preconditions:** None.  
**Steps:**
1. Open login page.
2. Observe layout and fields.

**Expected Result:**  
User can easily understand how to log in.

**Actual Result:**  
Interface is clear and understandable.

**Status:** PASS

---

## TC027 – QR scanning process is easy to use
**Module:** Usability  
**Preconditions:** Student logged in.  
**Steps:**
1. Open scanner page.
2. Scan QR.

**Expected Result:**  
Scanner is simple to access and use.

**Actual Result:**  
Scanning process is straightforward.

**Status:** PASS

---

# 10. Summary of Results

## Total Test Cases Executed
27

## Total Passed
27

## Total Failed
0

## Total Blocked
0

## Overall Result
The QR Code Attendance Tracking System passed all planned core functional, validation, integration, and usability tests. The system is working correctly and is ready for submission.

---

# 11. Recommendations
- Maintain access control checks on all protected pages.
- Keep duplicate attendance prevention enabled.
- Continue testing after any new feature or bug fix is added.
- Add more security checks in future versions, such as QR expiry time or rotating QR codes.
