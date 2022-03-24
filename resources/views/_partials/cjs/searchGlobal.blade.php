<script>
    $(document).ready(function (e) {
        var searchBox = $('#navbar-search-main');
        searchBox.removeClass('card');
        searchBox.find('#result-search').hide();
        var inputSearch = $('#searchGlobal');

        $(this).on('keyup', (event) => {
            if (event.key === '/') {
                inputSearch.focus().attr('placeholder', 'Masukkan minimal 3 karakter')
            }
        })

        inputSearch.on('keyup', function () {
            $(this).attr('placeholder', 'Masukkan minimal 3 karakter')
            var searchTerm = $(this).val().toLowerCase();
            var len = searchTerm.length;
            if(len > 2) {
                const response = HitData("{{ route('search') }}", {
                    search: searchTerm,
                }, 'GET').then((res)=>{
                    var result = res.results;
                    var html = '';
                    if(result.length > 0) {
                        result.forEach(function (item) {
                            html += `<li class="list-group-item">
                                        <a href="${item.route}">${item.name}</a>
                                    </li>`;
                        });
                    } else {
                        html = `<li class="list-group-item">
                                    <a href="#">No result found</a>
                                </li>`;
                    }
                    searchBox.find('#result-search').show();
                    searchBox.find('#result-search').html(html);
                    searchBox.addClass('card');
                }).catch((err) => {
                    console.log(err);
                });
            } else {
                searchBox.find('#result-search').hide();
                searchBox.removeClass('card');
            }
        });
    });
</script>