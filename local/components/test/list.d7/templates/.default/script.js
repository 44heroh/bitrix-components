$(document).ready(function () {
   $('.js-delete').on('click', function () {
       $.ajax({
           url: 'ajax.php',
           type: 'post',
           data: {
               'id': $(this).data('id')
           },
           success: function (response) {
               console.log(response.status);

           }
       });
   })
});