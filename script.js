async function searchBooks() {
    const query = document.getElementById('searchInput').value;

    if (!query.trim()) {
        alert('Please enter a search query!');
        return;
    }

    try {
        const response = await fetch(`/api/books/search?query=${encodeURIComponent(query)}`);
        if (!response.ok) {
            throw new Error('Failed to fetch search results');
        }

        const books = await response.json();
        displaySearchResults(books);
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while searching. Please try again.');
    }
}

function displaySearchResults(books) {
    const resultsContainer = document.getElementById('resultsContainer') || document.createElement('div');
    resultsContainer.id = 'resultsContainer';
    resultsContainer.innerHTML = ''; 

    if (books.length === 0) {
        resultsContainer.innerHTML = '<p>No books found.</p>';
    } else {
        books.forEach((book) => {
            const bookItem = document.createElement('div');
            bookItem.textContent = `${book.title} by ${book.author}`;
            resultsContainer.appendChild(bookItem);
        });
    }

    document.body.appendChild(resultsContainer);
}

//document.getElementById('searchButton').addEventListener('click', function() {
 // let query = document.getElementById('searchInput').value;
 // alert('You searched for: ' + query);
//});

document.getElementById('button1').addEventListener('click', function() {
  alert('Should return to home page');
});

document.getElementById('button2').addEventListener('click', function() {
  alert('Should send to about page');
});

document.getElementById('button3').addEventListener('click', function() {
  alert('Should send to credits');
});

document.getElementById('button4').addEventListener('click', function() {
  alert('Should send to contact info');
});
