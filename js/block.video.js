(function(blocks, element) {
    var el = element.createElement;

    blocks.registerBlockType('codewp/video', {
        title: 'Video Block',
        category: 'common',
        attributes: {
            videoEmbedCode: {
                type: 'string',
                source: 'attribute',
                selector: 'div',
                attribute: 'data-embed-code',
            },
        },
        edit: function(props) {
            var videoEmbedCode = props.attributes.videoEmbedCode || '';

            function onChangeVideoEmbedCode(newEmbedCode) {
                props.setAttributes({ videoEmbedCode: newEmbedCode });
            }

            return el(
                'div',
                { className: 'br_solid', 'data-embed-code': videoEmbedCode },
                el('input', {
                    type: 'text',
                    value: videoEmbedCode,
                    onChange: function(e) {
                        onChangeVideoEmbedCode(e.target.value);
                    },
                })
            );
        },
        save: function(props) {
            var videoEmbedCode = props.attributes.videoEmbedCode || '';

            return el(
                'div',
                { className: 'br_solid', 'data-embed-code': videoEmbedCode },
                el('div', {
                    dangerouslySetInnerHTML: { __html: videoEmbedCode },
                })
            );
        },
    });
})(window.wp.blocks, window.wp.element);
