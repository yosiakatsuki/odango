document.addEventListener( 'DOMContentLoaded', () => {
	const links = document.querySelectorAll( 'a[href*="#"]' );
	links.forEach( ( element ) => {
		element.addEventListener( 'click', ( e ) => {
			const urlSplit = e.currentTarget
				.getAttribute( 'href' )
				.split( '#' );
			const targetPageUrl = urlSplit[ 0 ]
				.split( '?' )[ 0 ]
				.replace( /\/$/, '' );
			const currentPageUrl = location.href
				.split( '#' )[ 0 ]
				.split( '?' )[ 0 ]
				.replace( /\/$/, '' );
			const id = urlSplit[ 1 ].split( '?' )[ 0 ];
			if ( '' !== targetPageUrl && targetPageUrl !== currentPageUrl ) {
				location.href = e.currentTarget.getAttribute( 'href' );
				return;
			}
			e.preventDefault();
			const target = document.getElementById( id );
			if ( ! target && '' !== id ) {
				return;
			}
			let top = 0;
			const behavior = window?.oooScrollBehavior || 'smooth';
			const scrollBuffer = window?.oooScrollBuffer || 0;
			if ( target ) {
				const pos = target.getBoundingClientRect().top;
				top = pos + window.scrollY - scrollBuffer;
			}
			window.scroll( {
				top,
				behavior,
			} );
		} );
	} );
} );
