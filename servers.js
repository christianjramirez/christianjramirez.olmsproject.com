const express = require('express');
const cors = require('cors');
const path = require('path');
require('dotenv').config(); //environment variables

//initialize app
const app = express();
const PORT = process.env.PORT || 3000;

//middleware
app.use(express.json()); // Built-in JSON parser
app.use(cors()); // Enable CORS


// Import routes
const bookRoutes = require('./routes/books');
const userRoutes = require('./routes/users');
const loanRoutes = require('./routes/loans');

//serve static files (e.g., HTML, CSS, JS)
app.use(express.static(path.join(__dirname)));

//health check endpoint
app.get('/', (req, res) => {
    res.send('Library Management System API is running');
});

//use routes
app.use('/api/books', bookRoutes);
app.use('/api/users', userRoutes);
app.use('/api/loans', loanRoutes);

//error handling
app.use((err, req, res, next) => {
    console.error(err.stack);
    res.status(500).json({ error: 'Internal Server Error' });
});

//start server
app.listen(PORT, () => {
    console.log(`Server running at http://localhost:${PORT}`);
});
