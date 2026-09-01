<div align="center">

# Jule Public Speaking - Academy and Workshop Portal

### *Masterclass Registration, Testimonials API, and Google Sheets / Webhook Sync*

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![JSON](https://img.shields.io/badge/JSON-API-000000?style=for-the-badge&logo=json&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)

---

</div>

## Overview

Jule Public Speaking is an online platform for executive public speaking workshops, masterclass registrations, and communication coaching. It features automated synchronization with Google Forms and Google Sheets via custom PHP webhooks and a JSON API for live client testimonials.

---

## Key Features and Architecture

### 1. Google Sheets and Webhook Integration (sync-sheets.php, webhook.php)
- Instant synchronization of workshop participant registrations from Google Forms.
- Webhook handler processing inbound lead notifications and updating database records.

### 2. Live Testimonials API (api-get-testimonials.php, testimonials.json)
- Dynamic JSON API providing verified participant reviews and video testimonials.
- Asynchronous frontend rendering with zero page reload latency.

### 3. Comprehensive Setup Guides (GOOGLE_FORM_SETUP.md, DEPLOYMENT_GUIDE.md)
- Step-by-step documentation for configuring Google Apps Script triggers and webhooks.

---

## File Architecture

- index.php: Public landing page and workshop registration interface.
- db.php: PDO Database connection and utility helper.
- api-get-testimonials.php: Public JSON API endpoint for client reviews.
- sync-sheets.php: Google Sheets API synchronization script.
- webhook.php: Real-time webhook listener for external form submissions.
- testimonials.json: Local JSON cache for client testimonials.
- GOOGLE_FORM_SETUP.md: Setup guide for Google Form Apps Script integration.
- DEPLOYMENT_GUIDE.md: Server deployment and environment guide.

---

## How to Run

`ash
git clone https://github.com/raphlv/jule-publicspeaking.git
cd jule-publicspeaking

# Run via PHP Built-in Server
php -S localhost:8000
`

---

## License and Author

Distributed under the MIT License.

Author: Pangeran Ryan Pahlevi (https://github.com/raphlv)  
Email: pangeranryan080504@gmail.com  

---
<div align="center">
  <sub>Automated Sync Enabled for Contribution Tracking | Last Updated: 2026-08-18 14:40:47</sub>
</div>

<!-- Last updated: 2026-09-01 13:06:26 -->


