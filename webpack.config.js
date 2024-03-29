const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

module.exports = {
    ...defaultConfig,
	output: {
		...defaultConfig.output,
		path: path.resolve( process.cwd(), 'dist' ),
	},
    entry: {
        'simple-local-avatars': path.resolve( process.cwd(), 'assets/js', 'simple-local-avatars.js' ),
    }
};
