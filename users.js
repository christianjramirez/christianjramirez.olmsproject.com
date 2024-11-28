const express = require('express');
const router = express.Router();
const db = require('../db');

// Utility function for email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Register a user
router.post('/', (req, res) => {
    const { first_name, last_name, email } = req.body;

    // Input validation
    if (!first_name || !last_name || !email) {
        return res.status(400).json({ error: 'All fields (first_name, last_name, email) are required' });
    }
    if (!isValidEmail(email)) {
        return res.status(400).json({ error: 'Invalid email format' });
    }

    // Check for duplicate email
    const checkEmailQuery = `SELECT * FROM Users WHERE email = ?`;
    db.query(checkEmailQuery, [email], (err, results) => {
        if (err) {
            console.error('Database error:', err);
            return res.status(500).json({ error: 'Internal server error' });
        }
        if (results.length > 0) {
            return res.status(409).json({ error: 'Email already exists' }); // Conflict status code
        }

        // Insert new user
        const insertQuery = `INSERT INTO Users (first_name, last_name, email, membership_date) VALUES (?, ?, ?, CURDATE())`;
        db.query(insertQuery, [first_name, last_name, email], (err, results) => {
            if (err) {
                console.error('Database error:', err);
                return res.status(500).json({ error: 'Internal server error' });
            }
            res.status(201).json({ message: 'User registered successfully', userId: results.insertId });
        });
    });
});

// Get all users
router.get('/', (req, res) => {
    const query = `SELECT * FROM Users`;
    db.query(query, (err, results) => {
        if (err) {
            console.error('Database error:', err);
            return res.status(500).json({ error: 'Internal server error' });
        }
        res.json(results);
    });
});

module.exports = router;
