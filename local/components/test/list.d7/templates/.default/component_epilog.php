<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
//print_r($componentPath);
?>
<script>
    $(document).ready(function () {
        $('.js-delete').on('click', function () {
            $.ajax({
                url: "/ajax/ajax.php",
                type: 'post',
                data: {
                    'id': $(this).data('id')
                },
                success: function (response) {
                    console.log(response.status);
                    if(response.status == 'success'){
                        setTimeout(function(){
                            window.location.href = window.location.href;
                        }, 500);
                    }
                }
            });
        })
    });
</script>
