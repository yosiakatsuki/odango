module.exports = {
	plugins: [
		require( 'autoprefixer' ),
		require( 'cssnano' )( {
			preset: [
				'default',
				{ minifyFontValues: { removeQuotes: false } }
			]
		} ),
	],
};
