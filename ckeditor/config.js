/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:ckeditor/
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	config.filebrowserBrowseUrl = "../ckeditor/ckfinder/ckfinder.html",
	config.filebrowserImageBrowseUrl = "../ckeditor/ckfinder/ckfinder.html?type=Images",
	config.filebrowserFlashBrowseUrl = "../ckeditor/ckfinder/ckfinder.html?type=Flash",
	config.filebrowserUploadUrl = "../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Files",
	config.filebrowserImageUploadUrl = "../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Images",
	config.filebrowserFlashUploadUrl = "../ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Flash"

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
};
