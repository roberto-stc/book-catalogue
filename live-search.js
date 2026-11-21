const box = document.getElementById('live-title');
const results = document.getElementById('live-results');
const message = document.getElementById('live-message');
box.addEventListener('input', function () {
    results.innerHTML = '';
    message.textContent = '';
    const text = box.value.trim();
    if (text == '') {
        return;
    }

    // personal note: THIS IS THE FETCH - it sends what was typed to live-search.php
    fetch('live-search.php?title=' + encodeURIComponent(text))
        // personal note: step 1 - check the answer and turn the JSON into JavaScript data
        .then(function (response) {
            if (!response.ok) {
                throw new Error('The server said: ' + response.status);
            }
            return response.json();
        })

        // personal note: step 2 - show the books on the page
        .then(function (books) {
            if (books.length == 0) {
                message.textContent = 'No books found.';
                return;
            }

            // personal note: add one table row for each book
            for (const book of books) {
                const row = document.createElement('tr');
                for (const value of [book.title, book.author, book.genre, book.year]) {
                    const cell = document.createElement('td');
                    cell.textContent = value;
                    row.appendChild(cell);
                }
                results.appendChild(row);
            }
        })

        // personal note: step 3 - if anything went wrong, show an error message
        .catch(function (error) {
            message.textContent = 'Sorry, the live search is not working right now.';
            console.log(error);
        });
});
