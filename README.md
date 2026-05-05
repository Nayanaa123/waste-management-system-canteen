Smart Canteen Waste Management System

1. Project Overview

The Smart Canteen Waste Management System is a web-based application developed using PHP and MySQL to monitor, manage, and reduce food and plastic waste in college canteens.

The system enables multiple administrators to record daily waste data, analyze trends, and receive recommendations for improving waste management practices.

---

2. Objectives

- Track daily food and plastic waste
- Provide data visualization for better analysis
- Compare performance across canteens
- Generate alerts for high waste levels
- Suggest corrective actions to reduce waste

---

3. Technologies Used

- Frontend: HTML, CSS
- Backend: PHP
- Database: MySQL
- Server: XAMPP
- Visualization: Chart.js
- Version Control: GitHub

---

4. System Architecture

The system follows a three-tier architecture:

1. Presentation Layer – User interface (HTML, CSS)
2. Application Layer – Business logic (PHP)
3. Data Layer – Database (MySQL)

---

5. User Roles

Super Admin

- Access to all canteens and data
- Can monitor overall waste statistics

Admin

- Assigned to a specific canteen
- Can add and view waste entries for their canteen
- Receives alerts and recommendations

---

6. Features

6.1 Login System

- Secure login using email and password
- Session-based authentication
- Role-based access control

6.2 Add Waste Entry

- Enter food waste (in kilograms)
- Enter plastic waste (in kilograms)
- Select canteen
- Data stored in database

6.3 View Entries

- Displays all recorded waste data
- Includes date, canteen name, and waste values

6.4 High Waste Alert

- Threshold values:
  - Food waste > 20 kg
  - Plastic waste > 5 kg
- Displays alert message when threshold is exceeded

6.5 Recommendation System

- Provides suggestions when waste is high
- Example recommendations:
  - Reduce excess food preparation
  - Improve inventory management
  - Minimize use of plastic materials

6.6 Delete Entry

- Allows removal of incorrect or unwanted records

6.7 Data Visualization

- Graphs generated using Chart.js
- Displays waste trends for analysis

6.8 Leaderboard

- Ranks canteens based on total waste
- Uses SQL aggregation and sorting

6.9 Multi-User Support

- Multiple admins supported
- Each admin linked to a specific canteen
- Data access restricted based on role

---

7. Database Structure

Admin Table

- admin_id (Primary Key)
- name
- email
- password
- role
- college_id

Canteen Table

- canteen_id (Primary Key)
- name
- location
- college_id

WasteEntry Table

- entry_id (Primary Key)
- canteen_id (Foreign Key)
- date
- food_waste_kg
- plastic_waste_kg

---

8. System Workflow

1. User logs in
2. Adds waste entry
3. Data stored in database
4. Data displayed in table
5. System checks for threshold conditions
6. Alerts generated if limits exceeded
7. Recommendations provided
8. Charts and leaderboard displayed

---

9. How to Run the Project

Step 1: Install XAMPP

Install XAMPP and ensure Apache and MySQL services are available.

Step 2: Start Server

Open XAMPP Control Panel and start:

- Apache
- MySQL

Step 3: Project Setup

Copy the project folder into:
C:\xampp\htdocs\WASTE_MANAGEMENT_SK

Step 4: Access the Application

Open a web browser and use:
http://localhost:8080/WASTE_MANAGEMENT_SK/login.php

Step 5: Database Setup

1. Open:
   http://localhost:8080/phpmyadmin

2. Create a database named:
   waste_canteen_system

3. Import the SQL file or manually create tables:
   
   - admin
   - canteen
   - wasteentry

Step 6: Login

Use credentials stored in the admin table to log in.

---

10. Screenshots


- Login Page

  ![Login](
- Dashboard
- Add Waste Entry
- View Entries
- Charts
- Leaderboard

---

11. Challenges Faced

- MySQL port conflicts
- Managing multiple user roles
- Ensuring responsive user interface

---

12. Future Enhancements

- AI-based waste prediction
- Mobile application support
- Real-time alert notifications
- Cloud deployment
- Integration with smart waste monitoring systems

---

13. Conclusion

This system provides an efficient and structured approach to monitor and reduce canteen waste using data tracking, visualization, and decision support features.

---

14. Repository Link

Add your GitHub repository link here.
