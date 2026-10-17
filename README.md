# Book Catalogue

A PHP and MySQL website for browsing, adding, editing, deleting and searching books.
Built for my web development assignment and run on localhost with MAMP.

## Running it on your computer (MAMP on Mac)

1. Open MAMP and click **Start** (this starts the web server and MySQL).
2. Put this folder inside MAMP's `htdocs` folder: `/Applications/MAMP/htdocs/book-catalogue`.
3. Click **WebStart**, then **Tools > phpMyAdmin**. Create a database called `book_catalogue`,
   click it, open the **SQL** tab, paste the contents of `sql/schema.sql` and click **Go**.
4. Visit http://localhost:8888/book-catalogue/

MAMP's default MySQL login is username `root`, password `root`, port `8889`.
