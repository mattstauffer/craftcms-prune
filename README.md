# Twig Prune for [Craft CMS](http://buildwithcraft.com/)

Add a Twig filter for CraftCMS templates to "prune" out fields of entries.

## Installation
1. Move the `prune` directory into your `craft/plugins` directory.
2. Go to Settings &gt; Plugins from your Craft control panel and enable the `prune` plugin

## Usage
The primary reason for this is to control the fields being output to `json_encode`.

```twig
{{ craft.entries.section('news').find() | prune(['title', 'body']) | json_encode() | raw }}
```

The above template will get all entries from the "news" section, grab just the title and body fields from each, and then output it to JSON.
