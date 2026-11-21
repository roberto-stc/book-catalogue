// personal note: this file is the JavaScript side of the Ajax live search.
// It uses fetch() to ask live-search.php for books, WITHOUT reloading the page.

// personal note: find the search box, the empty table body and the message line
const box = document.getElementById('live-title');
const results = document.getElementById('live-results');
const message = document.getElementById('live-message');

// personal note: every time something is typed in the box, run this
box.addEventListener('input', function () {

    // personal note: clear the old results and the old message
    results.innerHTML = '';
    message.textContent = '';

    // personal note: if the box is empty, stop here (no need to ask the server)
    const text = box.value.trim();
    if (text == '') {
        return;
    }

    // personal note: THIS IS THE FETCH - it sends what was typed to live-search.php
    // encodeURIComponent makes the text safe to put in a link (spaces, & and so on)
    fetch('live-search.php?title=' + encodeURIComponent(text))

        // personal note: step 1 - check the answer and turn the JSON into JavaScript data
        .then(function (response) {
            if (!response.ok) {
                // personal note: the server said something went wrong (for example 401 not logged in)
                throw new Error('The server said: ' + response.status);
            }
            return response.json();
        })

        // personal note: step 2 - show the books on the page
        .then(function (books) {

            // personal note: if no books came back, show a message
            if (books.length == 0) {
                message.textContent = 'No books found.';
                return;
            }

            // personal note: add one table row for each book
            for (const book of books) {
                const row = document.createElement('tr');

                for (const value of [book.title, book.author, book.genre, book.year]) {
                    const cell = document.createElement('td');
                    // personal note: textContent shows the text as plain text, never as HTML (stops XSS)
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
