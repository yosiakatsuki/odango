/**
 * WordPress
 */
import { registerBlockType } from '@wordpress/blocks';
import { Icon, page } from '@wordpress/icons'
/**
 * Block.
 */
import metadata from './block.json';
import Edit from './edit';
import './style.scss';

function registerBlock( name, data ) {
	if ( ! name || ! data ) {
		return;
	}
	registerBlockType( name, {
		attributes: data.attributes,
		icon: <Icon icon={ page }/>,
		edit: Edit,
	} );
}

registerBlock( metadata.name, metadata );
