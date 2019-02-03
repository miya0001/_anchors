(function(document) {
	var content = document.querySelector( '.entry-content' );

	var headers = content.querySelectorAll( 'h2' );
	var links = {};
	for (var i = 0; i < headers.length; i++ ) {
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

		var li = document.createElement( 'li' );
		li.appendChild( a );

		ul.appendChild( li );
	}

	content.insertBefore( ul, content.firstChild );
})(document);
