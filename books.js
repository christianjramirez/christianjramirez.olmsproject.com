const express = require('express');
const router = express.Router();
const db = require('../db');

// Add a book
router.post('/', (req, res) => {
    const { title, author, isbn, copies } = req.body;
    const query = `INSERT INTO Books (title, author, isbn, copies, available_copies) VALUES (?, ?, ?, ?, ?)`;
    db.query(query, [title, author, isbn, copies, copies], (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.status(201).json({ message: 'Book added successfully', bookId: results.insertId });
    });
});

// Get all books
router.get('/', (req, res) => {
    const query = `SELECT * FROM Books`;
    db.query(query, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json(results);
    });
});

// Update book availability
router.patch('/:id', (req, res) => {
    const { id } = req.params;
    const { available_copies } = req.body;
    const query = `UPDATE Books SET available_copies = ? WHERE book_id = ?`;
    db.query(query, [available_copies, id], (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.json({ message: 'Book updated successfully' });
    });
});

// Search for books by title, author, or ISBN
router.get('/search', (req, res) => {
    const { query } = req.query;

    if (!query) {
        return res.status(400).json({ error: 'Search query is required' });
    }

    const searchQuery = `
        SELECT * FROM Books
        WHERE title LIKE ? OR author LIKE ? OR isbn LIKE ?
    `;
    const searchTerm = `%${query}%`;

    db.query(searchQuery, [searchTerm, searchTerm, searchTerm], (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }

        res.json(results);
    });
});

module.exports = router;
