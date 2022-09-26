import { isObject } from 'lodash';
import classnames from 'classnames';
/**
 * WordPress
 */
import { registerFormatType, toggleFormat } from '@wordpress/rich-text';
import { Icon, edit } from '@wordpress/icons';
import {
	Fill,
	ToolbarButton,
} from '@wordpress/components';
/**
 * Theme
 */
import { getLocalizeObject } from '@aktk/blocks/helper/localize-object';

/**
 * Block
 */
const OBJECT_NAME = 'oooInlineStyles';
const SLOT_NAME_ORIGINAL = 'ooo.InlineStyle.Items';
const SLOT_NAME_CUSTOM = 'ooo.InlineStyle.CustomItems';

const registerInlineStyleFill = ( blockName ) => {
	const items = getLocalizeObject( OBJECT_NAME );
	if ( ! items || ! isObject( items ) ) {
		return;
	}
	registerInlineStyleFillFormatType(
		blockName,
		'ooo',
		items?.ooo,
		SLOT_NAME_ORIGINAL
	);
	registerInlineStyleFillFormatType(
		blockName,
		'custom',
		items?.custom,
		SLOT_NAME_CUSTOM
	);

}

export default registerInlineStyleFill;

const registerInlineStyleFillFormatType = ( blockName, type, items, slotName ) => {
	if ( ! items || ! isObject( items ) ) {
		return null;
	}
	Object.keys( items ).map( ( key ) => {
		const item = items[ key ];
		const name = `${ blockName }-item-${ type }-${ key }`;
		registerFormatType( name, {
			title: item.label,
			tagName: 'span',
			className: item.class,
			edit( { isActive, value, onChange } ) {
				return (
					<InlineStyleFillEdit
						name={ name }
						item={ item }
						slotName={ slotName }
						isActive={ isActive }
						value={ value }
						onChange={ onChange }
					/>
				);
			},
		} );
		return true;
	} );
}

const InlineStyleFillEdit = ( { name, item, slotName, isActive, value, onChange } ) => {
	const handleOnClick = () => {
		onChange(
			toggleFormat( value, {
				type: name,
			} )
		);
	}

	const titleClass = classnames(
		'ooo-inline-style-button',
		item.class
	);
	return (
		<>
			<Fill name={ slotName }>
				<ToolbarButton
					title={
						<span className={ titleClass }>{ item.label }</span>
					}
					icon={ <Icon icon={ edit }/> }
					isActive={ isActive }
					onClick={ handleOnClick }
				/>
			</Fill>
		</>
	);
}
