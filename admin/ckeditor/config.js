/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.filebrowserUploadUrl = '/admin/ckeditor/upload.php';
	config.filebrowserImageBrowseLinkUrl = '/admin/ckeditor/browse.php';
	config.filebrowserFlashBrowseUrl = '/admin/ckeditor/browse.php';

	config.allowedContent = true;

	config.height = 400;
	
	config.toolbar_user = [
		{ name: 'styles',   items: [ 'Bold','Italic','Underline','NumberedList','BulletedList','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','Link','Unlink','Format','FontSize','Undo','Redo' ] },
	];
	
	config.toolbar = [
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript', '-','Table','TextColor','BGColor','-','RemoveFormat', 'Format','Font','FontSize' ] },
		{ name: 'paragraph', items : [ 'Undo','Redo', '-', 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-' ,'Image', 'Link','Unlink','Anchor', '-', 'Source', '-', 'Maximize' ] },
	];

	/*
	config.toolbar_Full = [
		{ name: 'document', items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
	'/',
		{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'tools', items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];
	*/
};



