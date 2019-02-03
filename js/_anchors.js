(function(document) {
	var content = document.querySelector( '.entry-content' );

	var tags = [ 'h2', 'h3', 'h4', 'h5', 'h6' ]
	var headers = [];

	for ( var i = 0; i < tags.length; i++ ) {
		var headers = content.querySelectorAll( tags[i] );
		if ( headers.length ) {
			break;
		}
	}

	var links = {};
	for ( var i = 0; i < headers.length; i++ ) {
		var h = headers[i];
		var id = "";
		if ( h.id ) {
			id = h.id;
		} else {
			id = 'link-' + i;
			h.id = id;
		}

		links[id] = h.innerText;
	}

	var ul = document.createElement( 'ul' );
	ul.className = 'anchor-links'

	for ( var id in links ) {
		var a = document.createElement( 'a' );
		a.href = '#' + id;
		a.title = links[id];
		a.innerText = links[id];
		a.className = "scrollto";
		a.dataset.target = id;

		var li = document.createElement( 'li' );
		li.appendChild( a );

		ul.appendChild( li );

		a.addEventListener( 'click', function( event ) {
			document.querySelector( '#' + this.dataset.target ).scrollIntoView( {
				behavior: "smooth"
			} );
			event.preventDefault();
		} );
	}

	content.insertBefore( ul, content.firstChild );
})(document);
