$(function(){
    function concatena_enderco(){
        var nome_logradouro = $('#mus_EnCorrespondencia_Nome_Logradouro').editable('getValue', true);
        var cep = $('#mus_EnCorrespondencia_CEP').editable('getValue', true);
        var numero = $('#mus_EnCorrespondencia_Num').editable('getValue', true);
        var complemento = $('#mus_EnCorrespondencia_Complemento').editable('getValue', true);
        var bairro = $('#mus_EnCorrespondencia_Bairro').editable('getValue', true);
        var municipio = $('#mus_EnCorrespondencia_Municipio').editable('getValue', true);
        var estado = $('#mus_EnCorrespondencia_Estado').editable('getValue', true);
        
        if(cep && nome_logradouro && numero && bairro && municipio && estado){
            var endereco =  nome_logradouro + ", " + numero + (complemento ? ", " + complemento : " ") + ", " + bairro + ", " + cep  + ", " + municipio + ", " + estado;
            $('#mus_endereco_correspondencia').editable('setValue', endereco);
        }
    };
    
    $('#mus_EnCorrespondencia_Nome_Logradouro, #mus_EnCorrespondencia_CEP, #mus_EnCorrespondencia_Num, #mus_EnCorrespondencia_Complemento, #mus_EnCorrespondencia_Bairro, #mus_EnCorrespondencia_Municipio, #mus_EnCorrespondencia_Estado, #mus_EnCorrespondencia_Estado').on('hidden', function(e, params) {
        concatena_enderco();
    });

    $('#mus_EnCorrespondencia_CEP').on('hidden', function(e, params){
        var cep = $('#mus_EnCorrespondencia_CEP').editable('getValue', true);
        cep = cep.replace('-','');
        $.getJSON('http://cep.correiocontrol.com.br/'+cep+'.json',function(r){
            $('#mus_EnCorrespondencia_Nome_Logradouro').editable('setValue', r.logradouro);
            $('#mus_EnCorrespondencia_Bairro').editable('setValue', r.bairro);
            $('#mus_EnCorrespondencia_Municipio').editable('setValue', r.localidade);
            $('#mus_EnCorrespondencia_Estado').editable('setValue', r.uf);
            concatena_enderco();
        });
    });
    
    function showHideCampos(){
        var mesmo = $('#mus_EnCorrespondencia_mesmo').editable('getValue', true);
        
        if(mesmo == 'sim'){
            $('.js-endereco-correspondencia').hide();
        }else{
            $('.js-endereco-correspondencia').show();
        }
    }
    
    if(MapasCulturais.entity.object.mus_EnCorrespondencia_mesmo == 'sim'){
        $('.js-endereco-correspondencia').hide();
    }
    
    $('#mus_EnCorrespondencia_mesmo').on('hidden', function(e, params){
        showHideCampos();
    });
});