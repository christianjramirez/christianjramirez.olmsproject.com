const express = require('express');
const router = express.Router();
const db = require('../db');

//loan a book
router.post('/', async (req, res) => {
    const { user_id, book_id } = req.body;

    //input validation
    if (!user_id || !book_id) {
        return res.status(400).json({ error: 'user_id and book_id are required' });
    }

    try {
        //begin transaction
        await db.beginTransaction();

        //check if the book is available
        const [book] = await db.query(`SELECT available_copies FROM Books WHERE book_id = ?`, [book_id]);
        if (!book || book.available_copies <= 0) {
            return res.status(400).json({ error: 'Book is not available' });
        }

        //insert loan record
        await db.query(`INSERT INTO Loans (user_id, book_id, loan_date) VALUES (?, ?, CURDATE())`, [user_id, book_id]);

        //decrease available copies
        await db.query(`UPDATE Books SET available_copies = available_copies - 1 WHERE book_id = ?`, [book_id]);

        //commit transaction
        await db.commit();
        res.status(201).json({ message: 'Book loaned successfully' });
    } catch (error) {
        await db.rollback();
        console.error('Error loaning book:', error);
        res.status(500).json({ error: 'Internal server error' });
    }
});

//return a book
router.patch('/:loan_id', async (req, res) => {
    const { loan_id } = req.params;
    const { book_id } = req.body;

    //input validation
    if (!loan_id || !book_id) {
        return res.status(400).json({ error: 'loan_id and book_id are required' });
    }

    try {
        //begin transaction
        await db.beginTransaction();

        //update loan record
        const [loanResult] = await db.query(`UPDATE Loans SET return_date = CURDATE(), status = 'returned' WHERE loan_id = ?`, [loan_id]);
        if (loanResult.affectedRows === 0) {
            return res.status(404).json({ error: 'Loan not found or already returned' });
        }

        //increase available copies
        await db.query(`UPDATE Books SET available_copies = available_copies + 1 WHERE book_id = ?`, [book_id]);

        //commit transaction
        await db.commit();
        res.json({ message: 'Book returned successfully' });
    } catch (error) {
        await db.rollback();
        console.error('Error returning book:', error);
        res.status(500).json({ error: 'Internal server error' });
    }
});

module.exports = router;
