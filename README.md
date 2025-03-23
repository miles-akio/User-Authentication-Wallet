# User-Authentication-Wallet

INTRO: 

"I developed a user authentication system integrated with wallet balance management and a Stripe payment gateway. It includes signup, login, a dashboard to display wallet balances, and a deposit feature, ensuring transaction logging for both success and failure cases."

---

Backend Explanation:

1. Routes (API):
   - "I defined routes in `routes/japi.php` to handle user signup, login, and authenticated actions such as fetching wallet balances and processing deposits. The routes are protected with middleware to ensure only authenticated users can access dashboard and deposit features."

2. Authentication (JWT):
   - "JWT is used for authentication and session management. Upon login, the server issues a token that the client includes in subsequent requests for secure access."

3. Controllers:

   - AuthController:
     - "The `signup` method validates user inputs, hashes passwords, and stores user data in the database. The `login` method verifies credentials, issues a JWT token, and returns it to the client."

   - UserController:
     - "The `dashboard` method retrieves the authenticated user’s wallet balance from the database and returns it in JSON format."

   - TransactionController:
     - "The `deposit` method integrates with the Stripe API. It takes the deposit amount from the client, processes the payment, and logs the transaction. On success, the wallet balance is updated in the `users` table. On failure, it logs the failed transaction with a 'failed' status for transparency."

4. Stripe Integration:
   - "I used the Stripe PHP library to handle payment processing. The deposit amount is sent to Stripe for secure handling, ensuring compliance with payment gateway standards."

---

### Frontend Explanation: React.js

1. API Layer (api.js):
   - "To streamline API communication, I created an Axios instance with a base URL and included the JWT token in headers for authentication. This makes API calls more secure and consistent."

2. Signup Page:
   - "Users can register by entering a username and password. The form submits the data via a POST request to the backend's `/signup` endpoint. If registration succeeds, the user is notified; otherwise, they see an error."

3. Login Page:
   - "For login, the username and password are sent to the `/login` endpoint. On success, the server returns a JWT token, which is stored in localStorage for future authenticated requests."

4. Dashboard:
   - "After logging in, the user is redirected to the dashboard. It fetches and displays the user’s wallet balance from the backend. There’s also a feature to make deposits by entering an amount and clicking the 'Deposit' button. This triggers a POST request to the `/deposit` endpoint, and the wallet balance updates upon success."

5. Deposit Feature:
   - "When the user initiates a deposit, the amount is sent to the backend. If Stripe processes the payment successfully, the wallet balance updates, and the user is notified. If the transaction fails, an error message is displayed, and the failure is logged."

---

### Database Models and Tables:

1. Users Table:
   - "The `users` table stores user details like `username`, `password`, and `wallet_balance`. The `wallet_balance` field dynamically updates on successful deposits."

2. Transactions Table:
   - "The `transactions` table logs all deposits. Each entry includes the user ID, deposit amount, and transaction status (success/failed), ensuring traceability and accountability."

---

### Key Design Choices:

1. JWT Authentication:
   - "JWT is stateless and secure, allowing the server to avoid maintaining session data and reducing overhead."

2. Stripe Integration:
   - "Stripe simplifies payment processing and handles compliance with security standards like PCI-DSS, reducing implementation complexity."

3. Modular Code:
   - "The backend uses separate controllers for authentication, user data, and transactions, keeping the code clean and maintainable."

4. Error Handling:
   - "Comprehensive error handling ensures that failed transactions are logged for auditing and that the user receives clear feedback."

---

Challenges and Solutions:

1. Challenge: Securing Payment Data
   - "I ensured sensitive payment data was handled only by Stripe and not stored on our servers."

2. Challenge: Real-time Balance Updates
   - "To reflect balance changes immediately after a deposit, the frontend reloads the balance dynamically using React state and a fresh API call."

---

Impact:

"This system ensures robust user authentication, secure transaction handling, and detailed logging for auditing purposes. It is scalable and easily extendable for features like transaction history or advanced analytics."

---
