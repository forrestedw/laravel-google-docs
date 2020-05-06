# laravel-google-docs
A convenient chainable wrapper for `google/apiclient`

It's simple now. More functions are added when I need them.

## Get started
Watch [this](https://www.youtube.com/watch?v=iTZyuszEkxI) video to set up your `credetials.json`, then:

```php
use Forrestedw\GoogleDocs\GoogleDoc;

$document = (new GoogleDoc);
```

Get a document by its id:
```php
$document->getById('1QbVPiSgv8FR30Ap22cv5frIiO4VCUkRA5srdYSc8D3w'); // id from the url, eg https://docs.google.com/document/d/1QbVPiSgv8FR30Ap22cv5frIiO4VCUkRA5srdYSc8D3w/
```

# Functions
Find and replace all instances of `lead` in the document with `gold`:
```php
$document->findAndReplace('lead', 'gold'); // returns the number of replacements made.
```

```php
$title = $document->getTitle() // eg 'Document 1'
