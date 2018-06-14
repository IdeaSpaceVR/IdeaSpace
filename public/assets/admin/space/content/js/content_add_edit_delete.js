jQuery(document).ready(function($) {
		
		tinymce.init({
  			selector: '.field-type-textarea',  
				menubar: false,
				plugins: [
    			'autolink lists link charmap textcolor emoticons paste'
  			],
				paste_as_text: true,
				/*block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3',*/
				content_css: 'https://fonts.googleapis.com/css?family=Bangers|Bungee+Shade|Codystar|Dr+Sugiyama|Indie+Flower|Lobster|Pacifico|Skranji',
				fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt 38pt 40pt 42pt 44pt 46pt 48pt 50pt 52pt 54pt 56pt 58pt 60pt 62pt 64pt 66pt 68pt 70pt 72pt 74pt 76pt 78pt 80pt 82pt 84pt 86pt 88pt 90pt 92pt 94pt 96pt 98pt 100pt 102pt 104pt 106pt 108pt 110pt 112pt 114pt 116pt 118pt 120pt 122pt 124pt 126pt 128pt 130pt',
				toolbar: 'insert | undo redo | fontselect fontsizeselect emoticons | bold italic color forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist outdent indent | removeformat',
				font_formats: "Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Bangers='Bangers',arial,helvetica,sans-serif;Book Antiqua=book antiqua,palatino;Bungee Shade='Bungee Shade',arial,helvetica,sans-serif;Codystar='Codystar',arial,helvetica,sans-serif;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Dr Sugiyama='Dr Sugiyama',arial,helvetica,sans-serif;Georgia=georgia,palatino;Helvetica=helvetica;Indie Flower='Indie Flower',arial,helvetica,sans-serif;Impact=impact,chicago;Lobster='Lobster',arial,helvetica,sans-serif;Pacifico='Pacifico',arial,helvetica,sans-serif;Skranji='Skranji',arial,helvetica,sans-serif;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Verdana=verdana,geneva"
		});


		tinymce.init({
  			selector: '.field-type-textfield',  
				menubar: false,
				plugins: [
    			'autolink lists link charmap textcolor emoticons paste'
  			],
				paste_as_text: true,
				/*block_formats: 'Paragraph=p;Heading 1=h1;Heading 2=h2;Heading 3=h3',*/
				content_css: 'https://fonts.googleapis.com/css?family=Bangers|Bungee+Shade|Codystar|Dr+Sugiyama|Indie+Flower|Lobster|Pacifico|Skranji',
				fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt 38pt 40pt 42pt 44pt 46pt 48pt 50pt 52pt 54pt 56pt 58pt 60pt 62pt 64pt 66pt 68pt 70pt 72pt 74pt 76pt 78pt 80pt 82pt 84pt 86pt 88pt 90pt 92pt 94pt 96pt 98pt 100pt 102pt 104pt 106pt 108pt 110pt 112pt 114pt 116pt 118pt 120pt 122pt 124pt 126pt 128pt 130pt',
				toolbar: 'insert | undo redo | fontselect fontsizeselect emoticons | bold italic color forecolor backcolor  | alignleft aligncenter alignright alignjustify | bullist outdent indent | removeformat',
				font_formats: "Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Bangers='Bangers',arial,helvetica,sans-serif;Book Antiqua=book antiqua,palatino;Bungee Shade='Bungee Shade',arial,helvetica,sans-serif;Codystar='Codystar',arial,helvetica,sans-serif;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Dr Sugiyama='Dr Sugiyama',arial,helvetica,sans-serif;Georgia=georgia,palatino;Helvetica=helvetica;Indie Flower='Indie Flower',arial,helvetica,sans-serif;Impact=impact,chicago;Lobster='Lobster',arial,helvetica,sans-serif;Pacifico='Pacifico',arial,helvetica,sans-serif;Skranji='Skranji',arial,helvetica,sans-serif;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Verdana=verdana,geneva"
		});


    $('.content-add-save').click(function() {

        $(this).addClass('disabled');
        $('form').submit();

    });


    $('.content-delete').click(function() {

        $(this).addClass('disabled');
        $('form').submit();
    });


});
