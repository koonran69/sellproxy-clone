document.querySelectorAll(".ckeditor-classic").forEach((editorElement) => {
    ClassicEditor.create(editorElement)
        .then(editor => {
            editor.ui.view.editable.element.style.height = "200px";
        })
        .catch(error => {
            console.error("Lỗi CKEditor:", error);
        });
});
