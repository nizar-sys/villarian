<script>
    var buttonActionVilla = $('#action-villa');
    var deskripsiEditor = $('#editor');
    buttonActionVilla.attr('disabled', true);

    var countDeskripsi = $('#count-deskripsi');
    var countDeskripsiText = $('#count-deskripsi-text');
    function countTextDeskripsi() {

        countDeskripsiText.text(100 - deskripsiEditor.text().length + ' karakter tersisa');

        if (deskripsiEditor.text().length > 100) {
            countDeskripsi.removeClass('invalid-feedback').addClass('valid-feedback');
            countDeskripsiText.hide()
            buttonActionVilla.attr('disabled', false);
        } else {
            countDeskripsi.removeClass('valid-feedback').addClass('invalid-feedback');
            countDeskripsiText.show()
            buttonActionVilla.attr('disabled', true);
        }
    }
</script>
