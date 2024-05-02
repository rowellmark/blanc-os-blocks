// import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {

    const { title, description } = attributes;

    return (
        <>
            <div>
                <h2>{title}</h2>
                <p>{description}</p>
            </div>
        </>
    );
}