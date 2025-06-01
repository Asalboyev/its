const {
    ClassicEditor,
    Autoformat,
    AutoImage,
    AutoLink,
    Autosave,
    BlockQuote,
    Bold,
    CloudServices,
    CodeBlock,
    Essentials,
    Heading,
    Highlight,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Indent,
    Italic,
    Link,
    List,
    MediaEmbed,
    Paragraph,
    PasteFromOffice,
    SourceEditing,
    Strikethrough,
    Table,
    TableToolbar,
    Underline,
    WordCount
} = window.CKEDITOR;

const LICENSE_KEY = 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDQ5MzQzOTksImp0aSI6ImQ3MGE5MWUzLWJkYzgtNDBjMS04ZTI3LWYxZGVmZDE2MjJjZiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6ImY0N2FmYzVkIn0.q9QgX4Na9NDRzbD04IvZ-Pajv371bRtnWj6PrEjJ_ZPGPgc2J8bIJmp_hHS5Vv_TfUMc1eU-EwjJ7AAuacfmug';

const CLOUD_SERVICES_TOKEN_URL = 'https://qe0wptbmuhue.cke-cs.com/token/dev/05ff684bad3b1e264fdcd43cb1a230f1bcc5f71f48dd3966df80d3a02371?limit=10';

const editorConfig = {
    licenseKey: LICENSE_KEY,
    placeholder: 'Введите или вставьте свой текст здесь!', // CKEditor placeholder
    toolbar: {
        items: [
            'sourceEditing', '|',
            'heading', '|',
            'bold', 'italic', 'underline', '|',
            'link', 'insertImage', 'insertTable', '|',
            'bulletedList', 'numberedList', 'outdent', 'indent'
        ],
        shouldNotGroupWhenFull: false
    },
    plugins: [
        Autoformat, AutoImage, AutoLink, Autosave, BlockQuote, Bold, CloudServices,
        CodeBlock, Essentials, Heading, Highlight, Image, ImageCaption, ImageResize,
        ImageStyle, ImageTextAlternative, ImageToolbar, ImageUpload, Indent, Italic,
        Link, List, MediaEmbed, Paragraph, PasteFromOffice, SourceEditing, Strikethrough,
        Table, TableToolbar, Underline, WordCount
    ],
    cloudServices: {
        tokenUrl: CLOUD_SERVICES_TOKEN_URL
    },
    simpleUpload: {
        uploadUrl: '/upload-image',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }
};

// CKEditor ni yuklash
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('textarea[id^="edit_"]').forEach(textarea => {
        // Textarea qiymatini olish
        const initialValue = textarea.value;

        ClassicEditor.create(textarea, editorConfig)
            .then(editor => {
                // CKEditor ichida qiymatni o'rnatish
                editor.setData(initialValue);

                // CKEditor ma'lumotlarini textarea ga yozish
                editor.model.document.on('change:data', () => {
                    textarea.value = editor.getData();
                });

                // WordCount ni chiqarish (Agar kerak bo'lsa)
                const wordCount = editor.plugins.get('WordCount');
                if (wordCount) {
                    const wordCountContainer = wordCount.wordCountContainer;
                    if (wordCountContainer) {
                        document.querySelector('#editor-word-count').appendChild(wordCountContainer);
                    }
                }
            })
            .catch(error => console.error('CKEditor yuklashda xatolik:', error));
    });
});
