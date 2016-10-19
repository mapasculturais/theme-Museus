<?php
define('EXTRACT_MUSEUS_FILE', 1);
$time_start = microtime(true);
$save_log = isset($argv[1]) && $argv[1];
if($save_log)
    ob_start();

require realpath(__DIR__ . '/../../'). '/bootstrap.php';


// $em = $app->em;
$spaces = $app->controller('space');
$r = $spaces->apiQuery([
    '@select' => 'id,singleUrl,name,type,shortDescription,terms,endereco,acessibilidade,id,location,name,public,shortDescription,longDescription,createTimestamp,status,type,isVerified,updateTimestamp,emailPublico,telefonePublico,acessibilidade,acessibilidade_fisica,capacidade,endereco,En_CEP,En_Nome_Logradouro,En_Num,En_Complemento,En_Bairro,En_Municipio,En_Estado,horario,criterios,site,facebook,twitter,googleplus,geoEstado,geoMunicipio,num_sniic,cnpj,esfera,esfera_tipo,certificado,mus_verificado,mus_owned,mus_cod,mus_instituicaoMantenedora,mus_instumentoCriacao_tipo,mus_instumentoCriacao_descricao,mus_status,mus_abertura_ano,mus_abertura_publico,mus_itinerante,mus_itinerante_dependeRecursos,mus_exposicoes_duracao,mus_horario_segunda_das,mus_horario_segunda_ate,mus_horario_terca_das,mus_horario_terca_ate,mus_horario_quarta_das,mus_horario_quarta_ate,mus_horario_quinta_das,mus_horario_quinta_ate,mus_horario_sexta_das,mus_horario_sexta_ate,mus_horario_sabado_das,mus_horario_sabado_ate,mus_horario_domingo_das,mus_horario_domingo_ate,mus_tipo,mus_tipo_tematica,mus_tipo_unidadeConservacao,mus_tipo_unidadeConservacao_protecaoIntegral,mus_tipo_unidadeConservacao_usoSustentavel,mus_instalacoes,mus_instalacoes_capacidadeAuditorio,mus_servicos_visitaGuiada,mus_servicos_atendimentoEstrangeiros,mus_acessibilidade_visual,mus_arquivo_possui,mus_arquivo_acessoPublico,mus_biblioteca_possui,mus_biblioteca_acessoPublico,mus_acervo_comercializacao,mus_acervo_propriedade,mus_acervo_comodato_formalizado,mus_acervo_comodato_duracao,mus_acervo_material,mus_acervo_material_emExposicao,mus_acervo_nucleoEdificado,mus_atividadePrincipal,mus_caraterComunitario,mus_comunidadeRealizaAtividades,mus_ingresso_cobrado,mus_ingresso_valor,mus_gestao_regimentoInterno,mus_gestao_planoMuseologico,mus_gestao_politicaAquisicao,mus_gestao_politicaDescarte,mus_EnCorrespondencia_mesmo,mus_endereco_correspondencia,mus_EnCorrespondencia_CEP,mus_EnCorrespondencia_Nome_Logradouro,mus_EnCorrespondencia_Num,mus_EnCorrespondencia_Complemento,mus_EnCorrespondencia_CaixaPostal,mus_EnCorrespondencia_Bairro,mus_EnCorrespondencia_Municipio,mus_EnCorrespondencia_Estado,mus_add_info',
    '@order' => 'name ASC'
    ]);


$toCsv = function($l, $k = false){
    $r = '';
    foreach ($l as $key => $value) {
        if (is_object($value) || is_array($value)) {
            $r .= $GLOBALS['toCsv']($value, $k);
        }else{
            if ($k)
                $r .= ';' . $key;
            else
                $r .= ';"' . str_replace('"', '""', $value) . '"';
        }
    }
    return $r;
};

foreach ($r as $i => $l)
    echo ($i + 1) . $toCsv($l)."\n";


if($save_log)
    $log = ob_get_clean();

$time_end = microtime(true);

$execution_time = number_format($time_end - $time_start, 4);


$exec_time = "
=================================================
museus extracted in {$execution_time} seconds.
=================================================\n";

if($save_log && $log){
    $log_path = MapasCulturais\App::i()->config['app.log.path'];
    $log_filename = 'db-updates-' . date('Y.m.d-H.i.s') . '.log';
    file_put_contents( $log_path . $log_filename, $exec_time . $log);
}else{
    echo $exec_time;
}