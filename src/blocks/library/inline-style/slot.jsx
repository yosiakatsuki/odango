import { isObject } from 'lodash';
import classnames from 'classnames';
/**
 * WordPress
 */
import { __ } from '@wordpress/i18n';
import { BlockFormatControls } from '@wordpress/block-editor';
import { Icon, edit } from '@wordpress/icons';
import { registerFormatType } from '@wordpress/rich-text';
import {
	DropdownMenu,
	Slot,
	ToolbarItem,
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
const POPOVER_PROPS = {
	position: 'bottom right',
	isAlternate: true,
};

const registerInlineStyleSlot = ( blockName ) => {
	const items = getLocalizeObject( OBJECT_NAME );
	console.log( { items } );
	if ( ! items || ! isObject( items ) ) {
		return;
	}
	registerInlineStyleFormatType(
		blockName,
		'ooo',
		items?.ooo,
		SLOT_NAME_ORIGINAL,
		__( '[ooo]インラインスタイル', 'odango' )
	);
	registerInlineStyleFormatType(
		blockName,
		'custom',
		items?.custom,
		SLOT_NAME_CUSTOM,
		__( '[ooo]カスタムインラインスタイル', 'odango' )
	);
}
export default registerInlineStyleSlot;

const registerInlineStyleFormatType = ( blockName, type, items, slotName, buttonTitle ) => {
	registerFormatType( `${ blockName }-slot--${ type }`, {
		title: buttonTitle,
		tagName: 'span',
		className: `inline-style-slot--${ type }`,
		edit() {
			return (
				<InlineStyleSlotEdit
					items={ items }
					slotName={ slotName }
					buttonTitle={ buttonTitle }
				/>
			);
		}
	} );
}

const InlineStyleSlotEdit = ( { items, slotName, buttonTitle } ) => {
	if ( ! isObject( items ) ) {
		return null;
	}
	return (
		<BlockFormatControls>
			<Slot name={ slotName }>
				{ ( fills ) => {
					if ( ! fills.length ) {
						return null;
					}
					const allProps = fills.map(
						( [ { props } ] ) => props
					);
					const hasActive = allProps.some(
						( { isActive } ) => isActive
					);
					return (
						<ToolbarItem>
							{ ( toggleProps ) => (
								<DropdownMenu
									icon={ <Icon icon={ edit }/> }
									label={ buttonTitle }
									toggleProps={ {
										...toggleProps,
										className: classnames(
											toggleProps.className,
											{ 'is-pressed': hasActive }
										),
									} }
									controls={ fills.map(
										( [ { props } ] ) => props
									) }
									popoverProps={ POPOVER_PROPS }
								/>
							) }
						</ToolbarItem>
					);
				} }
			</Slot>
		</BlockFormatControls>
	);
}
