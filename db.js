const mysql = require('mysql2');

// Create and export the database connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'beepboop',
    database: 'library_db',
    port: 3306
});

// Connect to the database
db.connect(err => {
    if (err) {
        console.error('Error connecting to the database:', err);
        process.exit(1);
    }
    console.log('Connected to the MySQL database.');
});

module.exports = db;
