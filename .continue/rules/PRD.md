---
description: A description of your rule
---

# 📜 Business Requirements Document (BRD)

## 1. Introduction

### 1.1. Project Overview

This document outlines the business requirements for a new web and mobile-optimized application designed to manage Quranic schools, facilitate Quranic education, track student progress, and provide a secure, interactive social platform for students, teachers, parents, and administrators.

### 1.2. Business Goals

The primary goals of the application are to:

* **Streamline School Management:** Provide digital tools for managing classes, student enrollment, and administrative tasks.
* **Enhance Learning & Progress Tracking:** Offer a structured system for teaching the Quran and its sciences, and meticulously track student memorization (`hifz`) progress.
* **Improve Communication:** Facilitate effective and secure communication between teachers, students, and parents.
* **Foster Community:** Create an engaging social platform for members through posts, comments, and direct messaging.

### 1.3. Scope

The project scope encompasses a single, unified web application built using the specified technology stack, designed to be fully responsive for desktop/tablet use (fixed sidebar) and mobile devices (bottom navigation bar and shortcut menu).

***

## 2. Stakeholders & User Profiles

The application will serve the following primary user roles:

| Role | Key Responsibilities & Access |
| :--- | :--- |
| **Administrator** | Full system control (User management, school configuration, reporting). |
| **Teacher** | Class management, student progress tracking, teaching tools, communication with students/parents. |
| **Parent** | Monitoring child's progress, direct communication with teachers, accessing class announcements. |
| **Student** | Accessing learning materials, tracking personal progress, interacting socially, participating in class chat. |

***

## 3. High-Level Requirements (Features)

The application requires the following core functionalities:

### 3.1. School & Class Management (Admin/Teacher)

* Ability to create, edit, and archive **schools** and **branches**.
* Tools for creating and scheduling **classes** (e.g., *Tajweed Level 1*, *Hifz Group B*).
* System for **enrolling** and **assigning** students and teachers to classes.

### 3.2. Quranic Progress Tracking (Teacher/Student/Parent)

* **Memorization (Hifz) Tracking:** Teachers must be able to record **daily assignments** (e.g., a *new portion* or *review*) by Surah and Ayat range.
* **Performance Rating:** Teachers can log a **score/grade** for each assignment.
* **Progress Dashboard:** Students and Parents can view a visual representation of **memorization progress** (e.g., total Juz' memorized).
* **Curriculum Management:** Ability to define and assign specific Quranic and Islamic studies curricula.

### 3.3. Communication & Instant Messaging (Laravel Reverb)

* **Direct Messaging (DM):** Ability for any member to send private messages to any other member (based on defined user permissions).
* **Class Private Chat:** A **dedicated, persistent chat room** for every created class, accessible only by the assigned students and teachers.
* **Real-Time Notifications:** Use **Laravel Reverb** for instant, real-time alerts for:
    * New DM/Class Chat messages.
    * New assignment grades.
    * System announcements.

### 3.4. Social Interaction

* **Post Feed:** A central area where members (with permissions) can **create, view, and share** textual and/or media posts.
* **Comments:** Ability to **comment** on any post and **like/react** to posts/comments.
* **Moderation Tools:** Admin/Teachers need tools to review and moderate inappropriate content.

### 3.5. Reporting (Admin/Teacher)

* **Student Performance Reports:** Generate reports on individual or class-wide memorization progress and academic standing.
* **Attendance Reports:** Log and report student attendance.
* **System Activity Reports:** Overview of user sign-ups, post activity, and school usage.

***

## 4. Technical Requirements & Design

### 4.1. Technology Stack (Mandatory)

| Component | Technology | Rationale |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 12** | PHP MVC framework for robust, secure backend logic and API. |
| **Frontend Integration** | **Inertia.js (Vue 3)** | Building a modern Single Page Application (SPA) experience with Vue 3 components and Laravel routing. |
| **Styling** | **Tailwind CSS** | Utility-first CSS framework for rapid, responsive front-end design. |
| **Real-Time Layer** | **Laravel Reverb** | Handling instant messaging, notifications, and real-time updates. |
| **Database** | **MySQL** | Reliable and scalable relational data storage. |
| **Environment** | **Ubuntu** | Development environment as specified. |

### 4.2. User Interface (UI) Design

The application must adhere to a fully responsive design:

#### 4.2.1. Mobile Design (Smartphones)

* **Bottom Navigation Bar:** Fixed bar for the **4-5 most used sections** (e.g., *Home/Feed*, *My Classes*, *Messages*, *Progress*).
* **Shortcut Menu (Hamburger/FAB):** A menu to access **less frequently used sections** (*Admin Panel*, *Settings*, *Reports*).

#### 4.2.2. Desktop/Tablet Design

* **Fixed Sidebar Navigation:** A persistent sidebar on the left for easy access to all primary sections.

### 4.3. Performance & Security

* **Authentication & Authorization:** Secure user login and role-based access control (RBAC) must be implemented for all features.
* **Scalability:** The application must be designed to handle a growing number of schools, classes, and users. Laravel Reverb must be configured for high availability and concurrent users.
* **Data Security:** All sensitive student and progress data must be stored securely and transmitted via HTTPS.

***

## 5. Success Metrics

The project will be considered successful if:

* **80%** of school administrators find the class management feature **easier** than their previous method within the first month of use.
* **90%** of teachers successfully log daily student progress.
* **The real-time chat functionality (Reverb) experiences less than 1% downtime** during peak hours.
* The application receives positive feedback regarding its **ease of use and responsive design** from all user groups.

***

## 6. Assumptions & Constraints

### 6.1. Assumptions

* The school/organization is responsible for providing high-quality internet connectivity.
* All users have access to a supported web browser or mobile device.

### 6.2. Constraints

* **Technology Stack:** The chosen technologies (Laravel 12, Inertia/Vue 3, Tailwind, Reverb, MySQL) **cannot be changed**.
* **Timeline & Budget:** To be determined in the subsequent Project Plan (PMP).

***

Would you like me to now focus on a specific aspect of this BRD, such as breaking down the **data model** (e.g., tables for Students, Classes, and Memorization Progress) or generating **user stories** for the Teachers?