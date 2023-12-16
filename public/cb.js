import Plugin from '@ckeditor/ckeditor5-core/src/plugin';

export default class CodeBlockPlugin extends Plugin {
    static get pluginName() {
        return 'CodeBlock';
    }

    init() {
        const editor = this.editor;

        // Register the code block command
        editor.commands.add('insertCodeBlock', {
            exec: (editor) => {
                editor.model.change((writer) => {
                    const codeBlock = writer.createElement('codeBlock');
                    editor.model.insertContent(codeBlock, editor.model.document.selection);
                });
            },
        });

        // Define the schema for the code block
        editor.model.schema.register('codeBlock', {
            isObject: true,
            allowWhere: '$block',
        });

        // Define the view for the code block
        editor.conversion.for('upcast').elementToElement({
            view: {
                name: 'code',
                classes: 'code-block',
            },
            model: 'codeBlock',
        });

        editor.conversion.for('downcast').elementToElement({
            model: 'codeBlock',
            view: (modelElement, { writer }) => {
                return writer.createText('Code Block', { classes: 'code-block' });
            },
        });
    }
}
