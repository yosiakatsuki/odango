import classnames from 'classnames';
/**
 * WordPress.
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Block
 */
import './editor.scss';


const edit = ( props ) => {
	const { attributes } = props;
	const blockProps = useBlockProps( {
		className: classnames( 'ooo-breadcrumbs-edit' ),
	} );
	return (
		<div { ...blockProps }>
			<Disabled>
				<ServerSideRender
					block="ooo/breadcrumbs"
					attributes={ attributes }
				/>
			</Disabled>
		</div>
	);
}

export default edit;
