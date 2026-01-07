# Arwa Travel

A travel booking website showcasing tour packages with details, pricing, and booking functionality.

## Features

- Browse tour packages by category (International, Adventure, Local, Leisure, Honeymoon, Trekking)
- View tour details with pricing and duration
- Responsive design with mobile menu
- WhatsApp integration for bookings
- Tour carousel with navigation

## Project Structure

```
├── index.php                 # Home page
├── tour-details.php          # Tour details page
├── view-all-deals.php        # All tours listing
├── home.css                  # Home page styles
├── tour-details.css          # Tour details styles
├── view-all-deals.css        # All deals styles
├── home.js                   # Home page scripts
├── tour-details.js           # Tour details scripts
├── view-all-deals.js         # All deals scripts
├── includes/
│   └── db.php               # Database connection (not in repo)
├── Photos/                   # Image assets
├── Home/                     # Home page components
├── Me The Admin/             # Admin panel
└── ARWA TRAVEL/              # Travel data
```

## Setup Instructions

### Prerequisites
- PHP 7.4+
- MySQL/MariaDB
- Web server (Apache/Nginx)

### Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/arwa-travel.git
cd arwa-travel
```

2. Create environment configuration
```bash
cp .env.example .env
```

3. Update `.env` with your database credentials
```
DB_HOST=your_host
DB_USER=your_username
DB_PASSWORD=your_password
DB_NAME=your_database_name
```

4. Create `includes/db.php` with your database connection:
```php
<?php
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

5. Set up your web server to point to this directory

6. Access the application at `http://localhost` (or your configured domain)

## Database Schema

The application expects a `tours` table with the following structure:
- `tour_id` - Primary key
- `tour_name` - Tour name
- `main_image` - Path to tour image
- `price` - Tour price
- `duration` - Tour duration
- `currency_code` - Currency code (e.g., PKR, USD)
- Additional fields as needed for tour details

## Contact

- Phone: +92 333 55 111 00
- Email: arwatravels@gmail.com
- WhatsApp: https://wa.me/923335511100

## License

All rights reserved © 2023 Arwa Travel
