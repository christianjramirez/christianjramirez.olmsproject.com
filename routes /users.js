const express = require('express');
const bcrypt = require('bcrypt');
const router = express.Router();
const db = require('../db');

//function for email validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

//register a user
router.post('/register', async (req, res) => {
    const { first_name, last_name, email, phone_number, password } = req.body;

    if (!first_name || !last_name || !email || !phone_number || !password) {
        return res.status(400).json({ message: 'All fields are required' });
    }

    if (!isValidEmail(email)) {
        return res.status(400).json({ error: 'Invalid email format' });
    }

    try {
        //check for duplicate email
        const checkEmailQuery = `SELECT * FROM Users WHERE email = ?`;
        const [existingUser] = await new Promise((resolve, reject) => {
            db.query(checkEmailQuery, [email], (err, results) => {
                if (err) return reject(err);
                resolve(results);
            });
        });

        if (existingUser) {
            return res.status(409).json({ error: 'Email already exists' }); // Conflict status code
        }

        //hash password
        const hashedPassword = await bcrypt.hash(password, 10);

        //insert new user
        const insertQuery = `
            INSERT INTO Users (first_name, last_name, email, password, membership_date) 
            VALUES (?, ?, ?, ?, CURDATE())
        `;
        const result = await new Promise((resolve, reject) => {
            db.query(insertQuery, [first_name, last_name, email, hashedPassword], (err, results) => {
                if (err) return reject(err);
                resolve(results);
            });
        });

        res.status(201).json({ message: 'User registered successfully', userId: result.insertId });
    } catch (err) {
        console.error('Database error:', err);
        res.status(500).json({ error: 'Internal server error' });
    }
});

//get all users (exclude password)
router.get('/', (req, res) => {
    const query = `SELECT user_id, first_name, last_name, email, membership_date FROM Users`;
    db.query(query, (err, results) => {
        if (err) {
            console.error('Database error:', err);
            return res.status(500).json({ error: 'Internal server error' });
        }
        res.json(results);
    });
});

module.exports = router;
