$(function(){
    $('body').on('click', '.js-botao-meu-museu', function(){
        var $button = $(this);
        if(confirm('Você confirma que este museu é seu?')){
            $.post($(this).attr('href'), function(){
                $button.remove();
                document.location.reload();
            });
        }

        return false;
    });
});