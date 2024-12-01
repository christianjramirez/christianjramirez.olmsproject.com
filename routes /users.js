const express = require('express');
const bcrypt = require('bcrypt');
const { promisify } = require('util');
const router = express.Router();
const db = require('../db');

// Promisify database queries
const query = promisify(db.query).bind(db);

// Function for email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Register a user
router.post('/register', async (req, res) => {
    const { first_name, last_name, email, phone_number, password } = req.body;

    // Input validation
    if (!first_name || !last_name || !email || !phone_number || !password) {
        return res.status(400).json({ message: 'All fields are required' });
    }

    if (!isValidEmail(email)) {
        return res.status(400).json({ error: 'Invalid email format' });
    }

    try {
        // Check for duplicate email
        const existingUser = await query(`SELECT * FROM Users WHERE email = ?`, [email]);
        if (existingUser.length > 0) {
            return res.status(409).json({ error: 'Email already exists' }); // Conflict status code
        }

        // Hash password
        let hashedPassword;
        try {
            hashedPassword = await bcrypt.hash(password, 10);
        } catch (err) {
            console.error('Error hashing password:', err);
            return res.status(500).json({ error: 'Internal server error' });
        }

        // Insert new user
        const result = await query(
            `INSERT INTO Users (first_name, last_name, email, phone_number, password, membership_date) 
            VALUES (?, ?, ?, ?, ?, CURDATE())`,
            [first_name, last_name, email, phone_number, hashedPassword]
        );

        res.status(201).json({ message: 'User registered successfully', userId: result.insertId });
    } catch (err) {
        console.error('Database error:', err);
        res.status(500).json({ error: 'Internal server error' });
    }
});

// Get all users (exclude password)
router.get('/', async (req, res) => {
    try {
        const results = await query(`SELECT user_id, first_name, last_name, email, phone_number, membership_date FROM Users`);
        res.json(results);
    } catch (err) {
        console.error('Database error:', err);
        res.status(500).json({ error: 'Internal server error' });
    }
});

module.exports = router;

