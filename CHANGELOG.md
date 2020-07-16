# Changelog - Shorten Link

## TODO

* Write the documentation
* API

## XX-XX-2019 - @avimimoun

* Adding delete button when you wan't to modify one element
* Adding a redirection in the views of `list.php`
* Adding a button in `list.php` that redirects to `create.php`
* Adding card in all page `template.php`

## 25-08-2019 - @avimimoun

* Database: We can have duplicates for `longUrl` but not for` shortCode`
* Create one ShortenURL page
* Edit one ShortenURL page
* List all shortenURLS page
* Delete one shortenURL page
* Redirect page
* All urls are redirected to redirect.php
* The error handling was reviewed: we can display several errors in the same page:
  * Instead of using a String, we use an array
  * We manage errors with `try/catch`
* Fix bug in `_websiteUrlWithoutFile()` (in `/modal/_init.php`) : the function return now the path /routing/~~modal~~
