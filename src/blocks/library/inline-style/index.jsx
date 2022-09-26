import metadata from './block.json';
import registerInlineStyleSlot from './slot';
import registerInlineStyleFill from './fill';

function registerInlineStyle( blockName ) {
	registerInlineStyleSlot( blockName );
	registerInlineStyleFill( blockName )
}
registerInlineStyle( metadata.name );
