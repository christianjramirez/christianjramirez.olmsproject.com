const express = require('express');
const cors = require('cors');
require('dotenv').config(); // Load environment variables

// Initialize app
const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.json()); // Built-in JSON parser
app.use(cors()); // Enable CORS

// Import routes
const bookRoutes = require('./routes/books');
const userRoutes = require('./routes/users');
const loanRoutes = require('./routes/loans');

// Health check endpoint
app.get('/', (req, res) => {
    res.send('Library Management System API is running');
});

// Use routes
app.use('/api/books', bookRoutes);
app.use('/api/users', userRoutes);
app.use('/api/loans', loanRoutes);

// Error handling middleware
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Internal Server Error' });
});

// Start server
app.listen(PORT, () => {
    console.log(`Server running at http://localhost:${PORT}`);
});
