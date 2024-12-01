async function searchBooks() {
    const query = document.getElementById('searchInput').value.trim();

    if (!query) {
        alert('Please enter a search query!');
        return;
    }

    //Show a loading indicator
    const resultsContainer = document.getElementById('resultsContainer') || document.createElement('div');
    resultsContainer.id = 'resultsContainer';
    resultsContainer.innerHTML = '<p>Loading...</p>';
    document.body.appendChild(resultsContainer);

    try {
        const response = await fetch(`/api/books/search?query=${encodeURIComponent(query)}`);
        if (!response.ok) {
            throw new Error('Failed to fetch search results');
        }

        const books = await response.json();
        displaySearchResults(books);
    } catch (error) {
        console.error('Error:', error);
        resultsContainer.innerHTML = '<p>An error occurred while searching. Please try again.</p>';
    }
}

function displaySearchResults(books) {
    const resultsContainer = document.getElementById('resultsContainer') || document.createElement('div');
    resultsContainer.id = 'resultsContainer';
    resultsContainer.innerHTML = ''; //Clear previous results

    //Add a heading for results
    const heading = document.createElement('h2');
    heading.textContent = 'Search Results';
    resultsContainer.appendChild(heading);

    if (books.length === 0) {
        resultsContainer.innerHTML += '<p>No books found.</p>';
    } else {
        const list = document.createElement('ul'); // Use semantic HTML
        books.forEach((book) => {
            const listItem = document.createElement('li');
            listItem.textContent = `${book.title} by ${book.author}`;
            list.appendChild(listItem);
        });
        resultsContainer.appendChild(list);
    }

    document.body.appendChild(resultsContainer);
}



document.getElementById('button1').addEventListener('click', function() {
  alert('Should return to home page');
});

document.getElementById('button2').addEventListener('click', function() {
  alert('Should send to about page');
});

document.getElementById('button3').addEventListener('click', function() {
  //alert('Should send to credits');
  if (!event.target.matches(#button3"))
    return;
  fetch("credits.html");
});

document.getElementById('button4').addEventListener('click', function() {
  alert('Should send to contact info');
});
