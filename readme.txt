=== Digital Garden ===
Contributors: wolfpaw, binarygary
Donate link: https://david.garden
Tags: notes, digital garden, custom post type, taxonomy, block editor
Requires at least: 5.0
Tested up to: 6.5.3
Stable tag: 1.1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin to create a digital garden with notes and tags.

== Description ==

Digital Garden is a WordPress plugin that helps you create a digital garden with notes and tags. It provides a custom post type for notes, a custom taxonomy for tags, and a custom block for displaying an archive of notes. The plugin also includes functionality for bidirectional linking between notes and filtering notes by tags.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/digital-garden` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. The plugin will automatically create a page called "Digital Garden" with the slug "garden". This page will display an archive of all notes.
4. To update the title and slug of the "Digital Garden" page, go to the Digital Garden settings page under the Notes menu.

== Frequently Asked Questions ==

= How do I add a note? =

To add a note, go to the Notes menu in the WordPress admin dashboard and click on "Add New". Enter your note content and publish the note.

= How do I use the Digital Garden block? =

The Digital Garden block is automatically added to the "Digital Garden" page created during plugin activation. You can also add the block to any page or post using the block editor.

= How do I filter notes by tags? =

On the "Digital Garden" page, click on the tag buttons at the top of the archive to filter notes by the selected tags. You can select multiple tags to display notes that match any of the selected tags. Click the "Clear" button to reset the filter.

== Changelog ==

= 1.1.0 =
* Fixes multiple init issue
* Fixes static methods
* Builds a url to the auto-created page with note tag ID
* Exposes completeness in list table
* Refactors recent notes breadcrumbs to local storage in js
* Adds GitHub based update mechanism

= 1.0.0 =
* Initial release

== License ==

This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this plugin; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
