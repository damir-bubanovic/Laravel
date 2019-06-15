<?php 
/*

!! INTER - ADV TEXT EDITOR - create WYSIWYG !!

- abr. - What You See Is What You Get

- use plugin, popular ones:
	+) CKEditor -> http://ckeditor.com/
	+) TinyMCE -> https://www.tinymce.com/ (This is what we will use)

Folow documentation - we are using cdn
1) load file
2) implement / initialize editor () - this adds TinyMCE to any html textarea
3) you can customize layout of the buttons	
4) saving to database is ok - it stores HTML items
	>> ALERT <<
		Get rid of parsley verification for textarea
5) we have to work to display correcty from database
	A) OUTPUT HTML from DATABASE ( use {!! !!} )
	B) STRING HTML characters
6) Set UP Security
*/
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script type="text/javascript">
	tinymce.init({
		selector: 'textarea',
		plugins: 'link'
	});
</script>

/*
5.A.) when displayin text from database, instead of this use this, 
{!! !!} - it says that the information is 100% safe to display to browser as it is
	- we WANT the text to be formated!!
*/
<p>{{ $post->body }}</p>

<p>{!! $post->body !!}</p>
/*
5.B.) when displayin text from database, instead of this use strip_tags
	- we DON'T WANT the text to be formated!!
*/
<p>{{ $post->body }}</p>

<p>{{ strip_tags($post->body) }}</p>

/*
6) you can use a plugin for PHP (purify & filter HTML)
	A) htmLawed - http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/
	B) HTML Purifier - http://htmlpurifier.org/ (we are going to use this)
		- google HTMLPurifier for Laravel 5
> use wherever you are storing & updating data to database (in Controllers)
- do not forget to include Purifier in namespace
* in purifier you have to tell it (for the sake of TinyMCE) that heading tags should not be stripped & it's OK
	- look up in database to se what you get
	- for creating config file folow instructions on site
	-> config > purifier.php
		CHANGE:
			'HTML.Allowed' => add headings
			'CSS.AllowedProperties'	=> add whatever
			'AutoFormat.AutoParagraph' => false,
*/
$post->body = Purifier::clean($request->body);

?>


<?php 
/*
!! FOR VUE.JS !!

// Get the HTML contents of the currently active editor
tinyMCE.activeEditor.getContent();

// Get the raw contents of the currently active editor
tinyMCE.activeEditor.getContent({format : 'raw'});

// Get content of a specific editor:
tinyMCE.get('content id').getContent()
*/
?>
<script>
	export default {
        data() {
            return {
                pm: {
                    message: '',
                    selected: ''
                }
            }
        }
        methods: {
            postMessage() {
                var data = {
                    message: tinyMCE.activeEditor.getContent(),
                    selected: this.pm.selected
                };
                console.log(data);
            }
        }
    }
</script>