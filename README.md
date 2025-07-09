# 🖼️ NFT Marketplace

A modern, full-featured NFT (Non-Fungible Token) Marketplace built with PHP and MySQL. This platform allows users to mint, buy, sell, and manage NFTs, with robust account and wallet management, and a secure admin panel.

---

## 🚀 Features

- **User Authentication:** Secure registration, login, and password recovery.
- **NFT Minting:** Create collections and mint unique NFTs.
- **Marketplace:** Buy, sell, and transfer NFTs.
- **Wallet System:** Manage balances and transaction history.
- **Admin Dashboard:** Manage users, collections, and oversee platform activity.
- **Responsive Design:** Clean, mobile-friendly UI.
- **Security:** Password hashing, email verification, and session management.

---

## 🗂️ Project Structure

```
NFT/
├── Account/                # User account management pages
├── Admin/                  # Admin dashboard and management
├── ajaxValidation/         # AJAX handlers for validation
├── Assets/                 # Images, CSS, JS, and static files
├── Collection/             # NFT collection management
├── Database File/          # SQL schema and scripts
├── Docs/                   # Documentation
├── Functions/              # Reusable PHP functions
├── mailpage/               # Email templates and handlers
├── Trans/                  # Transactional and wallet pages
├── config.php              # Database configuration
├── Navbar.php, footer.php  # Layout components
├── index.php               # Landing page
├── login.php, register.php # Authentication
├── forgotpassword.php      # Password reset
└── ...                     # Other core files
```

---

## 🔑 Password Reset Flow

1. **User requests reset:**  
   Via [`forgotpassword.php`](forgotpassword.php), user submits their registered email.
2. **Verification:**  
   If email exists, a secure token is generated and emailed (see [`mailpage/forgotPassword.php`](mailpage/forgotPassword.php)).
3. **Reset Link:**  
   User clicks the link, sets a new password on the reset page.
4. **Confirmation:**  
   Password is securely updated in the database.

---

## 🛠️ Technologies Used

- **Backend:** PHP (Composer, PHPMailer)
- **Frontend:** HTML, CSS (Bootstrap), JavaScript
- **Database:** MySQL

---

## ⚡ Getting Started

1. **Clone the repository:**
   ```sh
   git clone https://github.com/viveksurti-dev/nft-marketplace.git
   ```
2. **Database setup:**  
   Import SQL files from `Database File/` into your MySQL server.

3. **Configure database:**  
   Edit `config.php` with your DB credentials.

4. **Install dependencies:**  
   If using Composer:
   ```sh
   composer install
   ```

5. **Run locally:**  
   Place the project in your XAMPP/WAMP `htdocs` folder and visit:  
   `http://localhost/NFT Marketplace/`

---

## 📧 Email Setup

- Configure SMTP in `mailpage/forgotPassword.php` for password reset emails.

---

## 📄 License

This project is for educational purposes. See [LICENSE](LICENSE) for details.

---

## 🤝 Contributing

Pull requests are welcome! For major changes, please open an issue first.

---

**Questions?**  
Open an issue or contact the
