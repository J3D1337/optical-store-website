# Laravel Reservation, Day Management and Landing Page System For A Optical Store Buissness

This system is made to help my cliend handle appointment bookings.

---

## 🛠 Features

- Admin panel for:
  - Creating, editing, deleting days
  - Creating, editing, deleting news(sale discounts, new products etc.)
  - Adding, updating, removing time slots
  - Separate handling for two shops
- Customer-facing view for selecting available dates and times
- Real-time feedback using AJAX and notifications
- Custom Blade views and responsive Tailwind layout
- Scroll-based animations for a smooth user experience

## 💻 Tech Used

### 🔙 Backend
- PHP 8+
- Laravel Framework
- MySQL Database
- Laravel Eloquent ORM

### 🎨 Frontend
- Blade Templating Engine
- Tailwind CSS
- Vanilla JavaScript
- Font Awesome (icons)

### 🛠 Tools & Features
- Composer (PHP dependency manager)
- AJAX for dynamic UI
- Responsive layout
- Scroll-based animations

---


## 📸 Landing Page

![Admin View](public/images/landing-page.png)

### 🧑‍💼 Admin Panel - Day Management

Admin is able to enter a date, pick a optical shop store location(Rijeka or Crikvenica) and add timeslots in a range from - to.

Meaning if he enters FROM (8:00) TO (16:00) the system will generate all the timeslots in the given timeframe split by 30 minutes each(what is exacly what client asked for) which makes it
user firendly.

![Admin View](public/images/create-day.png)

---

### 🕒 Add/Edit Time Slots

If Admin confirms booking to a client he has to manually remove the booked timeslot client asked for(it had to be done this way since no online payments and to prevent false booking spams).

![Timeslot Modal](public/images/edit-timeslots.png)

---

### 👤 Customer Reservation View

Client is able to pick one of two given locations.

When location is picked he is redirected to a view file that contains all dates with timeslots for a desired store.

![Customer View](public/images/client-reservation-view.png)

---

### 👤 Customer Book View

The idea is for user click on the any given avalible timeslot to proceed with the booking process, which sends an booking request to Admin via SMPT.

![Customer View](public/images/book.png)

---

### 👤 Booking Received

Admin gets an email in the following format


![Customer View](public/images/mail-format.png)

---

### 🧑‍💼 Admin Panel - News Management

News are displayed on a landing page (no pagination inclueded because client states that there will be no more than 3 at the time).

![Customer View](public/images/news.png)

---

### 👤 Add News

Admin is able to add news, enter title, main content and images optionally.

![Customer View](public/images/create-news.png)

---





