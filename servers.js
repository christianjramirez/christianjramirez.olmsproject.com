const express = require('express');
const cors = require('cors');
require('dotenv').config(); //environment variables

//initialize app
const app = express();
const PORT = process.env.PORT || 3000;


app.use(express.json()); //built-in JSON parser
app.use(cors()); //enable CORS

//import routes
const bookRoutes = require('./routes/books');
const userRoutes = require('./routes/users');
const loanRoutes = require('./routes/loans');

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
