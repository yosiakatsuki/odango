const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

module.exports = {
	...defaultConfig,
	resolve: {
		...defaultConfig.resolve,
		alias: {
			...defaultConfig.resolve.alias,
			'@aktk/blocks/function': path.resolve( __dirname, 'src/blocks/function' ),
			'@aktk/blocks/config': path.resolve( __dirname, 'src/blocks/config' ),
			'@aktk/blocks/components': path.resolve( __dirname, 'src/blocks/components' ),
			'@aktk/blocks/controls': path.resolve( __dirname, 'src/blocks/controls' ),
			'@aktk/blocks/api': path.resolve( __dirname, 'src/blocks/api' ),
			'@aktk/blocks/helper': path.resolve( __dirname, 'src/blocks/helper' ),
			'@aktk/blocks/icons': path.resolve( __dirname, 'src/blocks/icons' ),
		},
	},
};
