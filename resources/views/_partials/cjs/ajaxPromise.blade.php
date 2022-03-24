<script>
    function HitData(url, data, type) {
        return new Promise((resolve, reject) => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function(response) {
                    resolve(response)
                },
                error: function(error) {
                    reject(error)
                }
            })
        })
    }
</script>
