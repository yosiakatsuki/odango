export function getLocalizeObject( objectName, defaultValue = undefined ) {
	if ( ! window.hasOwnProperty( objectName ) ) {
		return defaultValue;
	}
	return window[ objectName ];
}
