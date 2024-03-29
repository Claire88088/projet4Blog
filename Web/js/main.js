/*
	Future Imperfect by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

$(document).ready(function() {

	var	$window = $(window),
		$body = $('body'),
		$menu = $('#menu'),
		$sidebar = $('#sidebar'),
		$main = $('#main');

	// Breakpoints.
		breakpoints({
			xlarge:   [ '1281px',  '1680px' ],
			large:    [ '981px',   '1280px' ],
			medium:   [ '737px',   '980px'  ],
			small:    [ '481px',   '736px'  ],
			xsmall:   [ null,      '480px'  ]
		});

	// Play initial animations on page load.
		$window.on('load', function() {
			window.setTimeout(function() {
				$body.removeClass('is-preload');
			}, 100);
		});

	// Menu.
		$menu
			.appendTo($body)
			.panel({
				delay: 500,
				hideOnClick: true,
				hideOnSwipe: true,
				resetScroll: true,
				resetForms: true,
				side: 'right',
				target: $body,
				visibleClass: 'is-menu-visible'
			});

	// Search (header).
		var $search = $('#search'),
			$search_input = $search.find('input');

		$body
			.on('click', '[href="#search"]', function(event) {

				event.preventDefault();

				// Not visible?
					if (!$search.hasClass('visible')) {

						// Reset form.
							$search[0].reset();

						// Show.
							$search.addClass('visible');

						// Focus input.
							$search_input.focus();

					}

			});

		$search_input
			.on('keydown', function(event) {

				if (event.keyCode == 27)
					$search_input.blur();

			})
			.on('blur', function() {
				window.setTimeout(function() {
					$search.removeClass('visible');
				}, 100);
			});

	// Intro.
		var $intro = $('#intro');

		// Move to main on <=large, back to sidebar on >large.
			breakpoints.on('<=large', function() {
				$intro.prependTo($main);
			});

			breakpoints.on('>large', function() {
				$intro.prependTo($sidebar);
			});
	
	// WYSIWYG interface for editing episodes using TinyMCE
		tinymce.init({ 
			selector: '#newsContent',
			menubar: false,
			setup: function (editor) {
				editor.on('change', function (e) {
					//editor.save();
					tinymce.triggerSave();
				});
			}
		});
	
		// Debug TinyMCE : no required attribute possibility on textarea for insert a news 
		// Adding an alert window to inform the user that the textarea content is required
		$('#insertButton').on('click', function(e) {
			if (($('input[name="title"]').val()) && !($('textarea[name="content"]').val()))
			{
				alert('Veuillez renseigner le champ "Contenu"');
			}	
		});

	// Forms verifications when changing field
		// CommentForm author must begin by a letter min or MAJ, have letters or '-' characters
		let regexAuthor = /^[a-zA-Zàâéèêëôöù][a-zA-Z\s-àâéèêëôöù]*[a-zA-Zàâéèêëôöù]$/;
		
		let authorElt = $('input[name="author"]');
		
		authorElt.on('blur', function(e) {
			let author = e.target.value;
			if (!regexAuthor.test(author)) {
				alert('Vous devez saisir un nom d\'auteur valide !');
			}
		});
});