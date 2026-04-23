# Digital Garden for WordPress

| **Description**       | A plugin to create a digital garden with notes and tags.                             |
| --------------------- | ------------------------------------------------------------------------------------ |
| **Contributors**      | wolfpaw, binarygary                                                                  |
| **Donate link**       | [https://david.garden/plugins](https://david.garden/plugins)                         |
| **Tags**              | digital garden, custom post type, taxonomy, block editor                             |
| **Requires at least** | 6.7                                                                                  |
| **Tested up to**      | 6.9                                                                                  |
| **Requires PHP**      | 7.0                                                                                  |
| **Stable tag**        | 1.3.0                                                                                |
| **License**           | GPLv2 or later                                                                       |
| **License URI**       | [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html) |


## Description

Digital Garden is a WordPress plugin that helps you create a digital garden with notes and tags. It provides a custom post type for notes, a custom taxonomy for tags, and a fully customizable archive block built with WordPress inner blocks. The plugin also includes bidirectional linking between notes, filtering by tags and completeness, and dedicated single-note blocks for breadcrumbs, backlinks, and related notes.

## Features

- Custom post type for notes with rich metadata (completeness status, tags, featured image)
- Fully customizable archive block built with WordPress inner blocks
- 16 composable blocks: archive container, note card, note title, content, tags, completeness, featured image, publish date, modify date, garden title, search, tag filter, completeness filter, active filter display, linked from, related notes, and note breadcrumbs
- Live filtering by tag and completeness status with active filter indicators
- Full-text note search in the archive
- `[[wikilink]]` double-bracket autocomplete with "Create draft" option for new notes
- `#hashtag` autocomplete for note tags in the editor
- Bidirectional link tracking between notes
- Linked From block showing all notes that link to the current note
- Related Notes block scoring notes by shared tags, backlinks, and forward links
- Note Breadcrumbs block showing a browser-local recently visited notes trail
- Single item: Note block template for the Full Site Editor
- GitHub-based automatic update mechanism

## Installation

1. Upload the plugin files to the `/wp-content/plugins/digital-garden` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. The plugin will automatically create a page called "Digital Garden" with the slug "garden". This page will display an archive of all notes.

## Frequently Asked Questions

### How do I add a note?

To add a note, go to the Notes menu in the WordPress admin dashboard and click on "Add New". Enter your note content and publish the note.

### How do I use the Digital Garden block?

The Digital Garden block is automatically added to the "Digital Garden" page created during plugin activation. You can also add the block to any page or post using the block editor.

### How do I filter notes by tags?

On the "Digital Garden" page, click on the tag buttons at the top of the archive to filter notes by the selected tags. You can select multiple tags to display notes that match any of the selected tags. Click the "Clear" button to reset the filter.

### How do I link between notes?

Type `[[` in the note editor to trigger the wikilink autocomplete. Search for an existing note to link to it, or select "Create draft" to create a new note with that title. Use `#` to autocomplete note tags.

### How do I display backlinks and related notes on a single note?

Add the "Linked From" block and "Related Notes" block to your single note template in the Site Editor. A "Single item: Note" template is provided by the plugin and available in the Site Editor under Templates.

## Screenshots


## Changelog

### 1.3.0
* Adds `[[wikilink]]` double-bracket autocomplete in the note editor with "Create draft" option for new notes
* Adds `#hashtag` autocomplete in the note editor
* Adds Related Notes block — scores and displays related notes by shared tags, backlinks, and forward links
* Adds Linked From block — displays notes that link to the current note (backlinks)
* Adds Note Breadcrumbs block — browser-local recently visited notes trail, configurable via block settings
* Adds Single item: Note block template for the Full Site Editor (requires a block theme)
* Makes date blocks editable directly in the block editor
* Limits allowed inner blocks in the Note card block for a cleaner editing experience
* Removes timestamp display settings and the now-empty plugin settings page
* Reduces custom CSS for Linked From and Related Notes blocks to defer to active theme styles
* Fixes block rendering on plugin activation
* Fixes permalink flush timing on activation

### 1.2.0
* Refactors archive to use WordPress inner blocks, making the note card template fully customizable in the editor
* Adds 13 new blocks: note card, note title, note content, note tags, note completeness, note featured image, note publish date, note modify date, garden title, search, tag filter, completeness filter, and active filter
* Adds live tag and completeness filtering with active filter display
* Adds full-text note search to the archive
* Adds editor previews for all blocks matching the frontend
* Syncs editor and frontend styles for filters, search, and layout
* Rewrites automatic updater to pull version info and zip directly from GitHub Releases

### 1.1.0
* Fixes multiple init issue
* Fixes static methods
* Builds a url to the auto-created page with note tag ID
* Exposes completeness in list table
* Refactors recent notes breadcrumbs to local storage in js
* Adds GitHub based update mechanism

### 1.0.0
* Initial release
