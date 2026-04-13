# Digital Garden for WordPress

| **Description**       | A plugin to create a digital garden with notes and tags.                             |
| --------------------- | ------------------------------------------------------------------------------------ |
| **Contributors**      | wolfpaw, binarygary                                                                  |
| **Donate link**       | [https://david.garden/plugins](https://david.garden/plugins)                         |
| **Tags**              | digital garden, custom post type, taxonomy, block editor                             |
| **Requires at least** | 5.0                                                                                  |
| **Tested up to**      | 6.6.2                                                                                |
| **Requires PHP**      | 7.0                                                                                  |
| **Stable tag**        | 1.2.0                                                                                |
| **License**           | GPLv2 or later                                                                       |
| **License URI**       | [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html) |


## Description

Digital Garden is a WordPress plugin that helps you create a digital garden with notes and tags. It provides a custom post type for notes, a custom taxonomy for tags, and a custom block for displaying an archive of notes. The plugin also includes functionality for bidirectional linking between notes and filtering notes by tags.

## Features

- Custom post type for notes with rich metadata (completeness status, tags, featured image)
- Fully customizable archive block built with WordPress inner blocks
- 13 composable blocks: archive container, note card, note title, content, tags, completeness, featured image, publish date, modify date, garden title, search, tag filter, completeness filter, and active filter display
- Live filtering by tag and completeness status with active filter indicators
- Full-text note search in the archive
- Bidirectional linking between notes
- Editor previews that match the frontend for all blocks
- GitHub-based automatic update mechanism

## Installation

1. Upload the plugin files to the `/wp-content/plugins/digital-garden` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. The plugin will automatically create a page called "Digital Garden" with the slug "garden". This page will display an archive of all notes.
4. To update the title and slug of the "Digital Garden" page, go to the Digital Garden settings page under the Notes menu.

## Frequently Asked Questions

### How do I add a note?

To add a note, go to the Notes menu in the WordPress admin dashboard and click on "Add New". Enter your note content and publish the note.

### How do I use the Digital Garden block?

The Digital Garden block is automatically added to the "Digital Garden" page created during plugin activation. You can also add the block to any page or post using the block editor.

### How do I filter notes by tags?

On the "Digital Garden" page, click on the tag buttons at the top of the archive to filter notes by the selected tags. You can select multiple tags to display notes that match any of the selected tags. Click the "Clear" button to reset the filter.

## Screenshots


## Changelog

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
