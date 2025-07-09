<script>
    var isSubjectFocus = false;
    $('input[type=button]').on('click', function() {
        console.log(isSubjectFocus);
        if (isSubjectFocus) {
            insertKeyword(this);
            return;
        }
        insertKeywordByTextArea(this);
        return;
    });

    function insertKeywordByTextArea(that) {
        const current_cursor = $('.text_editor').summernote('editor.getLastRange');
        current_cursor.pasteHTML($(that).val());
    }

    function insertKeyword(that) {

        var idToBeChecked = "#subjectField";
        var cursorPos = $(idToBeChecked).prop('selectionStart');
        var v = $(idToBeChecked).val();
        var textBefore = v.substring(0, cursorPos);
        var textAfter = v.substring(cursorPos, v.length);
        $(idToBeChecked).val(textBefore + $(that).val() + textAfter);
    }

    function checkSubjectFocus() {
        const elem = document.querySelector('.subject');
        if (elem === document.activeElement) {
            isSubjectFocus = true;
        } else {
            isSubjectFocus = false;
        }
    }
    setInterval(checkSubjectFocus, 400);
</script>