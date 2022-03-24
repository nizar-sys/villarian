<script>
    function seePassword(icon) {
        try {
            var inputPass = $('input[data-toggle="password"]');
            var icon = $(`#${icon.id} i`);
            inputPass.map(function(index, element) {
                if (element.type === 'password') {
                    element.type = 'text';
                    icon.removeClass().addClass('fas fa-eye-slash');
                } else {
                    element.type = 'password';
                    icon.removeClass().addClass('fas fa-eye');
                }
            });
        } catch (error) {
            console.log(error);
        }
    }
</script>
