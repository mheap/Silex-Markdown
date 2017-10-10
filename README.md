# Silex-Markdown

[![Build Status](https://secure.travis-ci.org/mheap/Silex-Markdown.png?branch=master)](http://travis-ci.org/mheap/Silex-Markdown)

### Requirements

This extension only works with *PHP 7.1+* and *Silex 2*.
[Version 1.0.0](https://github.com/mheap/Silex-Markdown/releases/tag/1.0.0) is compatible
with Silex 1.

### Installation

Install with composer:

```bash
composer require mheap/silex-markdown
```

### Usage

First, you need to register the Markdown extension. This will use the default settings
for the extension.

```php
$app->register(new \SilexMarkdown\MarkdownExtension());
```

If you'd like to disable certain transformations, you can provide them when registering
the extension. This will not convert headers from markdown to HTML.

```php
$app->register(new MarkdownExtension(), array(
    'markdown.features'   => array(
        'header' => false,
    )
));
```

To render markdown, use `$app['markdown']`:

```php
$app->get('/', function() use($app) {
    $html = $app['markdown']->transform('# Hello World'); // <h1>Hello World</h1>
});
```

If you're using Twig via `Silex\Provider\TwigServiceProvider()`, a `markdown` filter will
be automatically registered for you. This allows you do do the following:

```php
// In your route
$app->get('/', function() use($app) {
    $text = '# Hello World';
    $html = $app['twig']->render('example.twig', array(
        'input' => $text
    ));
});
```

```twig
// In your twig file
{{ input | markdown }}
```

### Running the tests

There are no external dependencies for this library. Just `composer install` then run `./vendor/bin/phpunit`
