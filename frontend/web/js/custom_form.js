// Custom form
$( document ).ready(function() {

    $('.create_form').on('click', function () {

        var successMessage = $(this).closest('form').data('success-message');

        $('.validate-done').remove();

        var formId = $(this).closest('form').attr('id');
        var formIndex = $('form').index($('#'+formId));

        var form = document.forms[formIndex];

        var formData = new FormData(form);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", $(this).closest('form').data('url'));


        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if(xhr.status == 200) {

                    data = xhr.responseText;
                    if(data == "true") {
                        $('.exit-btn').click();
                        $('#popup-success').fadeIn();
                        $("#popup-success h2").html(successMessage);


                        clearForm(form);
                    } else {

                    }
                }
            }
        };

        xhr.send(formData);

    });

    function addError(elementId, value) {
        var element = $('#'+elementId);
        element.parent().append('<div class="help-block">'+value+'</div>');
    }

    function clearForm(form) {
        $.each(form.find('.input, textarea'), function() {
            $(this).val('')
        });
    }
});