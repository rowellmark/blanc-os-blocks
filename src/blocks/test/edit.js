import {
	RichText,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';


import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { title, description } = attributes;

	return (
		<>
			<div {...useBlockProps()}>
				<InspectorControls>
					This inspector
				</InspectorControls>
				<h2>{title}</h2>
				<p>{description}</p>
			</div>
		</>
	);
}
