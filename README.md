# Silverstripe yml preset links

Adds link types preset in your config.yml for [gorriecoe/silverstripe-link](https://github.com/gorriecoe/silverstripe-link).

This is useful for defining commonly used links, js functions and/or anchors.

## Installation

Composer is the recommended way of installing SilverStripe modules.

```
composer require gorriecoe/silverstripe-ymlpresetlinks
```

## Example usage

```yml
gorriecoe\Link\Models\Link:
  preset_types:
    'hello-world':
      Title: "Hello world alert"
      LinkURL: "javascript:alert('Hello World!');"
    'back-to-top':
      Title: "Scroll to top"
      LinkURL: "#back-to-top"
    'google':
      Title: "Google"
      LinkURL: "https://www.google.com/"
      OpenInNewWindow: true
```
