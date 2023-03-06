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
		'simple-local-avatars-style': path.resolve( process.cwd(), 'assets/scss', 'simple-local-avatars-style.scss' ), 
    }
};
