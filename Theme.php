<?php

namespace MapasMuseus;

use MapasCulturais\App;
use MapasCulturais\Definitions;
use MapasCulturais\i;

class Theme extends \Subsite\Theme{

    static function _dict() {
        $dict = parent::_dict();

        foreach($dict as $key => $dic){
            $dict[$key]['text'] = str_replace(["espaços culturais", "Espaços culturais", "Espaços", "espaços", "Espaço", "espaço",], [i::__('museus'), i::__('Museus'), i::__('Museus'), i::__('museus'), i::__('Museu'), i::__('museu')], $dic['text']);
        }
        
        return $dict;
    }


    public function _init() {
        $app = App::i();

        /*
         *  Modifica a consulta da API de espaços para só retornar Museus
         *
         * @see protectec/application/conf/space-types.php
         */
        $app->hook('API.<<*>>(space).params', function(&$api_params) use ($app) {
            $api_params['type'] = 'BET(60,69)';
        });

        parent::_init();

         $app->hook('view.partial(modal/<<*>>):after', function($template, &$html){
            $terms = [
                i::__('espaço') => i::__('museu'),
            ];
            
            $html = str_replace(array_keys($terms), array_values($terms), $html);
         });

        $app->hook('GET(site.search):before', function () use ($app) {
            if ((count($app->config['busca.lista.municipios']) > 0)) {
                $metadata = $app->getRegisteredMetadataByMetakey("En_Municipio", "MapasCulturais\\Entities\\Space");
                $metadata->field_type = "select";
                $meta_config = $metadata->config;

                $meta_config['options'] = $app->config['busca.lista.municipios'];
                $metadata->config = $meta_config;
            }
        });

        $app->hook("view.partial(entity-opportunities--tabs-edit).params", function(&$data, &$template){
            $template = "_empty";
        });

        $app->hook("view.partial(entity-opportunities--content-edit).params", function(&$data, &$template){
            $template = "_empty";
        });

        $app->hook("view.partial(tab).params", function(&$data, &$template){
            if($data['id'] == 'permissao'){
                $template = "_empty";
            }
        });

        $app->hook("view.partial(permissions).params", function(&$data, &$template){
            if($this->controller->id == "space"){
                $template = "_empty";
            }
        });

        $app->hook('entity(<<Space>>).save:after', function() use ($app){
            if(!$this->getValidationErrors() && !$this->mus_cod){
                $getDvFromNumeroIdent = function($numIdent)
                {
                       $dgs = array();
                       for($i=0; $i < strlen($numIdent); $i++)
                               $dgs[] = $numIdent{$i};

                       $ft  = 9;
                       $sm  = 0;
                       foreach($dgs as $dg)
                       {
                               $sm += ($dg*$ft);
                               $ft -= 1;
                       }
                       $resto = $sm % 11;
                       return $resto > 1 ? (11 - $resto) : 0;
                };
                $existMusCod = function($new_cod) use($app){
                    $conn = $app->em->getConnection();
                    $tot = $conn->fetchColumn("SELECT count(*) FROM space_meta WHERE key = 'mus_cod' and value = '".$new_cod."'");
                    return $tot > 0;
                };
                $geraNumeroIdent = function () use($getDvFromNumeroIdent){
                       $pdg = array(1,2,5,6,8,9);
                       shuffle($pdg);

                       $dgs = array($pdg[0]);
                       for ($i=2; $i<=8; $i++)
                               $dgs[$i] = rand(0,9);

                       $nId = implode('',$dgs);
                       $nId .= $getDvFromNumeroIdent($nId);

                       return $nId;
                };
                do{
                    $mus_cod = $geraNumeroIdent();
                    // format mus_cod in mask 0.00.00.0000
                    $mus_cod = substr($mus_cod, 0, 1).'.'.substr($mus_cod, 1, 2).'.'.substr($mus_cod, 3, 2).'.'.substr($mus_cod, 5, 4);
                } while($existMusCod($mus_cod));
                $this->mus_cod = $mus_cod;
            }
        });

        // BUSCA POR CÓDIGO DO MUSEU
        // adiciona o join do metadado
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.join', function(&$joins, $keyword) {
            $joins .= "
                LEFT JOIN
                        e.__metadata mus_cod
                WITH
                        mus_cod.key = 'mus_cod'";
        });

        // filtra pelo valor do keyword
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword) {
            $where .= "OR lower(mus_cod.value) LIKE lower(:keyword)";
        });


        // modificações nos templates
        $app->hook('template(space.<<*>>.num-sniic):before', function(){
            $entity = $this->data->entity;

            if($entity->mus_cod)
                echo "<small><span class='label'>Código:</span> {$entity->mus_cod}</small>";
            else
                echo "<small><span class=\"label\">Código: </span><span>Preencha os campos obrigatorios e clique em salvar para gerar</span></small>";
        });

        $app->hook('template(space.<<create|edit|single>>.tabs):end', function(){
            $this->part('tabs-museu', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tabs-content):end', function(){
            $this->part('tab-publico', ['entity' => $this->data->entity]);
            $this->part('tab-mais', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tab-about-service):begin', function(){
            $this->part('about-service-begin', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.acessibilidade):after', function(){
            $entity = $this->data->entity;
            ?>
        <?php
        });

        $app->hook('template(space.<<*>>.location):after', function(){
            $this->enqueueScript('app', 'endereco-correspondencia', 'js/endereco-correspondencia.js');
            $this->part('endereco-correspondencia', ['entity' => $this->data->entity]);
        });


        // own
        $app->hook('POST(space.own)', function() use($app){
            $this->requireAuthentication();

            $entity = $this->getRequestedEntity();
            if($entity->mus_owned){
                throw new \MapasCulturais\Exceptions\PermissionDenied($app->user, $entity, 'own');
            }
            $app->disableAccessControl();
            $entity->mus_owned = true;
            $entity->owner = $app->user->profile;
            $entity->save(true);
            $app->enableAccessControl();

            $this->json(true);
        });

        $app->hook('view.render(space/<<*>>):before', function(){
            $this->addTaxonoyTermsToJs('mus_area');
        });

        $app->hook('view.render(<<*>>):before', function() use($app) {
            $this->assetManager->publishAsset('img/logo-ibram.png');
        });

        $app->hook('template(panel.<<*>>.highlighted-message):end', function() use($app){
            $this->part( 'panel/highlighted-message--numsniic');
        });
      
        $app->hook('view.render(<<*>>):before', function() use($app) {
            $this->jsObject['angularAppDependencies'][] = 'entity.controller.agentTypes';
        });
        
        $app->hook('template(<<space|agent|project|event>>.<<create|edit|single>>.name):after', function() use ($app){
            $this->enqueueScript('app', 'num-sniic', 'js/num-sniic.js');
            $entity = $this->data->entity;
            if($entity->num_sniic){
                $this->part('num-sniic', ['entity' => $entity]);
            }
        });
        
        // BUSCA POR NÚMERO SNIIC
        // adiciona o join do metadado
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.join', function(&$joins, $keyword) {
            $joins .= "
                LEFT JOIN 
                        e.__metadata num_sniic 
                WITH 
                        num_sniic.key = 'num_sniic'";
        });

        // filtra pelo valor do keyword
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword) {
            $where .= "OR lower(num_sniic.value) LIKE lower(:keyword)";
        });
        
        // BUSCA POR NÚMERO MUNICIPIO
        // adiciona o join do metadado
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.join', function(&$joins, $keyword) {
            $joins .= "
                LEFT JOIN 
                        e.__metadata En_Municipio 
                WITH 
                        En_Municipio.key = 'En_Municipio'";
        });

        // filtra pelo valor do keyword
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword) {
            $where .= "OR lower(En_Municipio.value) LIKE lower(:keyword)";
        });
    }

    public function includeAngularEntityAssets($entity) {
        parent::includeAngularEntityAssets($entity);
        
        $this->enqueueScript('app', 'entity.controller.agentType', 'js/ng.entity.controller.agentTypes.js', ['entity.app']);
    }

    public function includeOpeningTimeAssets(){
        $this->jsObject['templateUrl']['spaceOpeningTime'] = $this->asset('js/directives/openingTime.html', false);
        $this->jsObject['angularAppDependencies'][] = 'entity.directive.openingTime';
        $this->enqueueScript('app', 'entity.directive.openingTime', 'js/ng.entity.directive.openingTime.js', array('ng-mapasculturais'));
    }

    static function getThemeFolder() {
        return __DIR__;
    }

    public function getMetadataPrefix() {
        return 'mus_';
    }

    protected function _getAgentMetadata() {
        return [];
    }

    protected function _getEventMetadata() {
        return [];
    }

    protected function _getProjectMetadata() {
        return [];
    }

    protected function _getSpaceMetadata() {
        return [
            'verificado' => [
                'label' => 'O Museu é verificado?',
                'type' => 'boolean'
            ],

            'owned' => [
                'label' => 'Se o museu já apropriado por algum usuário'
            ],

            'cod' => [
                'label' => 'Número na Processada',
                'type' => 'readonly'
            ],

            'instituicaoMantenedora' => [
                'label' => 'Instituição mantenedora'
            ],
            'outros_cadastros' => [
                'label' => 'A instituição já possui cadastro',
                'type' => 'select',
                'options' => [
                    '' => 'Não possui',
                    'Museusbr',
                    'Cadastro nacional de museus',
                    'ICOM',
                    'Outros',
                ]
            ],
            'resp_formacao' => [
                'label' => 'Formação do responsável pela instituição',
                'type' => 'select',
                'options' => [
                    'Ensino fundamental',
                    'Ensino médio',
                    'Ensino técnico',
                    'Ensino tecnólogo',
                    'Ensino superior incompleto',
                    'Ensino superior completo',
                ]
            ],
            'area_formacao' => [
                'label' => 'Em caso de superior completo, especifique a área',
                'type' => 'text',
            ],
            'equipe_tecnica' => [
                'label' => 'O Museu possui equipe técnica',
                'type' => 'select',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'periodo_museologico' => [
                'label' => 'Período de vigência do plano museológico',
                'type' => 'select',
                'options' => [
                    '1',
                    '2',
                    '3',
                    '4',
                    '5',
                    '6',
                    '7',
                    '8',
                    '9',
                    '10',
                ]
            ],
            'instumentoCriacao_tipo' => [
                'label' => 'Instrumento de criação',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outro',
                'options' => [
                    '' => 'Não possui',
                    'Lei',
                    'Decreto-Lei',
                    'Decreto',
                    'Portaria',
                    'Resolução',
                    'Ata de Reunião'
                ]
            ],

            'instumentoCriacao_descricao' => [
                'label' => 'Ex: Lei XXX Nº 000 DATA DD/MM/AAAA',
                'type' => 'text',
            ],

            'status' => [
                'label' => 'Status do Museu',
                'type' => 'select',
                'options' => [
                    'aberto' => 'Aberto',
                    'fechado' => 'Fechado',
                    'implantacao' => 'Em implantação',
                    'extinto' => 'Extinto'
                ]
            ],

            // caso status == Fechado î
            'previsao_abertura_mes' =>[
                'label' => 'Previsão de Abertura (Mês)',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O Mês deve ser um campo inteiro'
                ]
            ],

            'previsao_abertura_ano' =>[
                'label' => 'Previsão de Abertura (Ano)',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O Ano deve ser um campo inteiro'
                ]
            ],

            'abertura_ano' => [
                'label' => 'Ano de abertura',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O ano de abertura deve ser um valor numérico inteiro'
                ]
            ],

            'itinerante' => [
                'label' => 'O museu é itinerante?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            // tipologia
            'tipo' => [
                'label' => 'Tipo',
                'type' => 'select',
                'options' => [
                    'Tradicional/Clássico',
                    'Virtual',
                    'Museu de território/Ecomuseu',
                    'Unidade de conservação da natureza',
                    'Jardim zoológico, botânico, herbário, oceanário ou planetário'
                ]
            ],

            'tipo_tematica' => [
                'label' => 'Temática do museu',
                'type' => 'select',
                'options' => [
                    'Artes, arquitetura e linguística',
                    'Antropologia e arqueologia',
                    'Ciências exatas, da terra, biológicas e da saúde',
                    'História',
                    'Educação, esporte e lazer',
                    'Meios de comunicação e transporte',
                    'Produção de bens e serviços',
                    'Defesa e segurança pública',
                ]
            ],
                
            'num_total_acervo' => [
                'label' => 'Informe o número total de bens culturais de caráter museológico que compõem o acervo:',
                'type' => 'text',
            ],

            'num_total_acervo_prec' => [
                'label' => 'O número informado é:',
                'type' => 'select',
                'options' => [
                    'Exato','Aproximado',
                ],
            ],

            'tipo_unidadeConservacao' => [
                'label' => 'Tipo/categoria de manejo da Unidade de Conservação',
                'type' => 'select',
                'options' => [
                    '' => 'Não se aplica',
                    'Proteção integral',
                    'Uso sustentável'
                ]
            ],

            'tipo_unidadeConservacao_protecaoIntegral' => [
                'label' => 'Tipo de unidade de proteção integral',
                'type' => 'select',
                'options' => [
                    '' => 'Não se aplica',
                    'Estação Ecológica',
                    'Monumento Natural',
                    'Parque',
                    'Refúgio da Vida Silvestre',
                    'Reserva Biológica'
                ]
            ],

            'tipo_unidadeConservacao_usoSustentavel' => [
                'label' => 'Tipo de unidade de uso sustentável',
                'type' => 'select',
                'options' => [
                    '' => 'Não se aplica',
                    'Floresta',
                    'Reserva Extrativista',
                    'Reserva de Desenvolvimento Sustentável',
                    'Reserva de Fauna',
                    'Área de Proteção Ambiental',
                    'Área de Relevante Interesse Ecológico',
                    'Reserva Particular do Patrimônio Natural'
                ]
            ],

            'instalacoes' => [
                'label' => 'Instalações básicas e serviços oferecidos',
                'multiselect',
                'options' => [
                    'Bebedouro',
                    'Estacionamento',
                    'Guarda-volumes',
                    'Livraria',
                    'Loja',
                    'Restaurante e/ou Lanchonete',
                    'Sanitário',
                    'Teatro/Auditório'
                ]
            ],
            'instalacoes_capacidadeAuditorio' => [
                'label' => 'Capacidade do teatro/auditório (assentos)',
                'type' => 'int',
                'validations' => [
                    'v::numeric()' => 'a capacidade do teatro/auditório deve ser um número inteiro'
                ]
            ],
            'equipe_dev_educativo' => [
                'label' => 'O museu possui equipe PRÓPRIA para desenvolvimento e realização de ações educativas e culturais?',
                'type' => 'select',
                'options' => ['Sim','Não']
            ],
            'servicos_visitaGuiada' => [
                'label' => 'O museu promove visitas guiadas?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_visitaGuiada_s' => [
                'label' => 'Em caso positivo, especifique',
                'type' => 'select',
                'options' => [
                    'SOMENTE mediante agendamento',
                    'Sem necessidade de agendamento'
                ]
            ],
            'servicos_atendimentoEstrangeiros' => [
                'label' => 'Atendimento em outros idiomas',
                'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Sinalização visual',
                    'Material de divulgação impresso',
                    'Audioguia',
                    'Guia, monitor,orientador e/ou mediador'
                ]
            ],
            'acess_visual_auditiva' => [
                'label' => 'O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e/ou visuais?',
                'type' => 'select',
                'options' => ['Sim','Não']
            ],

            'acessibilidade_visual' => [
                'label' => 'O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?',
                'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Guia multimídia (com monitor)',
                    'Maquetes táteis ou mapas em relevo',
                    'Obras e reproduções táteis',
                    'Piso tátil',
                    'Sinalização em braile',
                    'Tradutor de Linguagem Brasileira de Sinais (LIBRAS)',
                    'Texto/Etiquetas em braile com informações sobre os objetos expostos'
                ],
            ],
            'arquivo_possui' => [
                'label' => 'O museu possui arquivo histórico?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'arquivo_acessoPublico' => [
                'label' => 'O arquivo tem acesso ao público?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'biblioteca_possui' => [
                'label' => 'O Museu possui biblioteca?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'biblioteca_acessoPublico' => [
                'label' => 'A biblioteca tem acesso ao público?',
                'type' => 'select',
                'options' => [
                    '' => 'não se aplica',
                    'sim' => 'sim',
                    'não' => 'não',
                ]
            ],

            // acervo
            'acervo_propriedade' => [
                'label' => 'Propriedade do acervo',
                'type' => 'select',
                'options' => [
                    'Possui SOMENTE acervo próprio',
                    'Possui acervo próprio e em comodato',
                    'Acervo compartilhado entre órgãos/setores da mesma entidade mantenedora',
                    'Possui SOMENTE acervo em comodato/empréstimo',
                    'NÃO possui acervo',
                ]
            ],
            'num_acervo_prest' => [
                'label' => 'O comodato/empréstimo está formalizado por meio de documento legal?',
                 'type' => 'select',
                 'options' => [
                 'Sim','Não',
                ],
            ],

            'num_acervo_prest' => [
                'label' => 'O comodato/empréstimo está formalizado por meio de documento legal?',
                 'type' => 'select',
                 'options' => [
                 'Sim','Não',
                ],
            ],

            'acervo_material' => [
                'label' => 'O museu possui também acervo material?',
                'type' => 'select',
                'options' => [
                    'sim' => 'sim',
                    'não' => 'não'
                ]
            ],

            'acervo_material_emExposicao' => [
                'label' => 'O acervo material encontra-se em exposição?',
                'type' => 'select',
                'options' => [
                    '' => 'não se aplica',
                    'sim' => 'sim',
                    'não' => 'não'
                ]
            ],

            'caraterComunitario' => [
                'label' => 'O museu é de carater comunitário?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],

            'comunidadeRealizaAtividades' => [
                'label' => 'Em caso de museus comunitários, a comunidade realiza atividades museológicas?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],

            'metodo_contagem_pub' => [
                'label' => 'Método de contagem de publico',
                'type' => 'select',
                'options' => [
                    'Livro de assinaturas',
                    'Ingressos impressos',
                    'Catraca',
                    'Agendamento',
                    'Outros'
                ]
            ],

            'ingresso_cobrado' => [
                'label' => 'O ingresso ao museu é cobrado?',
                'type' => 'select',
                'options' => [ 'sim', 'não', 'contribuição voluntária']
            ],

            'ingresso_valor' => [
                'label' => 'Em caso positivo, informe o valor cobrado SOMENTE para o público em geral:',
                'type' => 'text'
            ],

            'desc_valor_ingresso' => [
                'label' => 'Observações sobre cobrança de entrada',
                'type' => 'text',
            ],

            'obs_horario' => [
                'label' => 'Observações dias e horários de abertura',
                'type' => 'text',
            ],

            // GESTÂO
            'gestao_regimentoInterno' => [
                'label' => 'O museu posui regimento interno?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            'gestao_planoMuseologico' => [
                'label' => 'O museu possui plano museológico?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            'gestao_politicaAquisicao' => [
                'label' => 'O museu possui política de aquisição de acervo?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],

            'gestao_politicaDescarte' => [
                'label' => 'O museu possui política de descarte de acervo?',
                'type' => 'select',
                'options' => ['sim', 'não']
            ],



            // FALTA DEFINIR SE VAI PARA O CORE
            'EnCorrespondencia_mesmo' => [
                'label' => 'O endereço de correspondência é o mesmo de visitação?',
                'type' => 'select',
                'options' => [ 'sim', 'não' ]
            ],

            'EnRegiao_desenvilvimento' => [
                'label' => 'Região de desenvolvimento',
                'type' => 'text',
            ],

            'EnMacro_regiao' => [
                'label' => 'Macro região',
                'type' => 'text',
            ],

            'endereco_correspondencia' => [
                'label' => 'Endereço de correspondência'
            ],

            'EnCorrespondencia_CEP' => [
                'label' => 'CEP',
            ],
            'EnCorrespondencia_Nome_Logradouro' => [
                'label' => 'Logradouro',
            ],
            'EnCorrespondencia_Num' => [
                'label' => 'Número',
            ],
            'EnCorrespondencia_Complemento' => [
                'label' => 'Complemento',
            ],
            'EnCorrespondencia_CaixaPostal' => [
                'label' => 'Caixa Postal',
            ],
            'EnCorrespondencia_Bairro' => [
                'label' => 'Bairro',
            ],
            'EnCorrespondencia_Municipio' => [
                'label' => 'Município',
            ],
            'EnCorrespondencia_Estado' => [
                'label' => 'Estado',
                'type' => 'select',
                'options' => array(
                    'AC'=>'Acre',
                    'AL'=>'Alagoas',
                    'AP'=>'Amapá',
                    'AM'=>'Amazonas',
                    'BA'=>'Bahia',
                    'CE'=>'Ceará',
                    'DF'=>'Distrito Federal',
                    'ES'=>'Espírito Santo',
                    'GO'=>'Goiás',
                    'MA'=>'Maranhão',
                    'MT'=>'Mato Grosso',
                    'MS'=>'Mato Grosso do Sul',
                    'MG'=>'Minas Gerais',
                    'PA'=>'Pará',
                    'PB'=>'Paraíba',
                    'PR'=>'Paraná',
                    'PE'=>'Pernambuco',
                    'PI'=>'Piauí',
                    'RJ'=>'Rio de Janeiro',
                    'RN'=>'Rio Grande do Norte',
                    'RS'=>'Rio Grande do Sul',
                    'RO'=>'Rondônia',
                    'RR'=>'Roraima',
                    'SC'=>'Santa Catarina',
                    'SP'=>'São Paulo',
                    'SE'=>'Sergipe',
                    'TO'=>'Tocantins',
                )
            ],
            'add_info' => [
                'label' => 'Informações Adicionais de Contato',
                'type' => 'text',
            ],
            'atividade_pub_especif' => [
                'label' => 'O museu realiza atividades educativas e culturais para públicos específicos?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'atividade_pub_especif_s' => [
                'label' => 'Em caso positivo, especifique: escolha a(s) que mais se adeque(m)',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outro',
                'options' => [
                    'Estudantes de ensino fundamental',
                    'Estudantes de ensino médio',
                    'Estudantes universitários',
                    'Professores',
                    'Terceira idade',
                    'Pessoas com deficiência',
                    'Indígenas, quilombolas ou outras comunidades tradicionais',
                    'Turistas nacionais ',
                    'Turistas estrangeiros',
                    'Pessoas em situação de vulnerabilidade social '
                ]
            ],
            'mais_ent_federal' => [
                'label' => 'Caso o museu seja formado por dois ou mais entes da Federação, especifique quais:',
                'type' => 'text',
            ],
            'esfera_tipo_federal' => [
                'label' => 'Em caso de Museu federal, especifique vinculação ministerial',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outro',
                'options' => [
                    'Agricultura, Pecuária e Abastecimento',
                    'Cidades',
                    'Ciência, Tecnologia, Inovação e Comunicações',
                    'Cultura',
                    'Defesa',
                    'Desenvolvimento, Indústria e Comércio Exterior ',
                    'Desenvolvimento Social e Agrário',
                    'Educação',
                    'Esporte',
                    'Fazenda',
                    'Integração Nacional',
                    'Justiça e Cidadania',
                    'Meio Ambiente',
                    'Minas e Energia',
                    'Planejamento, Orçamento e Gestão',
                    'Relações Exteriores',
                    'Saúde',
                    'Trabalho e Previdência Social',
                    'Transparência, Fiscalização e Controle    ',
                    'Transportes, Portos e Aviação Civil',
                    'Turismo ',
                    'Secretaria de Governo  ',
                    'Casa Civil   ',
                    'Gabinete de Segurança Institucional'
                ]
            ],
            'priv_esfera_tipo' => [
                'label' => 'Em caso de privado, especifique',
                'type' => 'select',
                'options' => [
                   'Associação',
                   'Fundação',
                   'Organização Religiosa',
                   'Entidade Sindical'
                ]
            ],
            'contrato_gestao' => [
                'label' => 'O museu possui algum contrato para sua gestão?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'contrato_gestao_s_outros' => [
                'label' => 'Caso outros, informe',
                'type' => 'text'
            ],
            'contrato_gestao_s' => [
                'label' => 'Em caso positivo especifique a estrutura jurídica da instituição contratada',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outra',
                'options' => [
                    'Associação',
                    'Fundação',
                    'Sociedade (incluem-se aqui as sociedades de economia mista, empresas públicas e privadas)',
                    'Outros'
                ]
            ],
            'contrato_qualificacoes' => [
                'label' => 'A contratada possui qualificações?',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Outra',
                'options' => [
                    'OS',
                    'OSCIP',
                    'Não possui qualificações',
                    'Outra'
                ]
            ],
            'num_pessoas' => [
                'label' => 'Quantas pessoas trabalham no museu (contabilizar terceirizados, estagiários e voluntários)?',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O Mês deve ser um campo inteiro'
                ]
            ],
            'func_tercerizado' => [
                'label' => 'O museu possui funcionários terceirizados?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'func_tercerizado_s' => [
                'label' => 'Em caso positivo, especifique quantos',
                'type' => 'int',
                'validations' => [
                    'v::intVal()' => 'O número de funcionários deve ser um número inteiro'
                ]
            ],
            'func_voluntario' => [
                'label' => 'O museu possui voluntários?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'func_estagiario' => [
                'label' => 'O museu possui estagiários?',
                'type' => 'select',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'instr_documento' => [
                'label' => 'Indique os instrumentos de documentação de acervo utilizados pelo Museu',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outro(s)',
                'options' => [
                    'Livro de registro/tombo/inventário manuscritos',
                    'Listagem digital (Word, Excel...)',
                    'Ficha de catalogação',
                    'Software/sistemas de catalogação informatizado'
                ]
            ],
            'instr_documento_n' => [
                'label' => 'Caso o Museu não realize nenhuma ação de documentação de seu acervo, justifique',
                'type' => 'text'
            ]
        ];
    }

    function register() {
        parent::register();
        $app = App::i();
        $app->hook('app.register', function(&$registry) {
            $group = null;
            $registry['entity_type_groups']['MapasCulturais\Entities\Space'] = array_filter($registry['entity_type_groups']['MapasCulturais\Entities\Space'], function($item) use (&$group) {
                if ($item->name === 'Museus') {
                    $group = $item;
                    return $item;
                } else {
                    return null;
                }
            });

            $registry['entity_types']['MapasCulturais\Entities\Space'] = array_filter($registry['entity_types']['MapasCulturais\Entities\Space'], function($item) use ($group) {
                if ($item->id >= $group->min_id && $item->id <= $group->max_id) {
                    return $item;
                } else {
                    return null;
                }
            });
        });

        $metadata = [
            'MapasCulturais\Entities\Event' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],
            ],

            'MapasCulturais\Entities\Project' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],
            ],

            'MapasCulturais\Entities\Space' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ],
                
                'cnpj' => [
                    'label' => 'CNPJ',
                    'private' => false,
                    
                ],
                
                'esfera' => [
                    'label' => 'Esfera',
                    'type' => 'select',
                    'options' => [
                        'Pública',
                        'Privada'
                    ]
                ],
                
                'esfera_tipo' => [
                    'label' => 'Tipo de esfera',
                    'type' => 'select',
                    'options' => [
                        'Federal',
                        'Estadual',
                        'Distrital',
                        'Municipal',
                        'Associação',
                        'Empresa',
                        'Fundação',
                        'Particular',
                        'Religiosa',
                        'Mista',
                        'Entidade Sindical',
                        'Outra',
                    ],
                ],
                
                'certificado' => [
                    'label' => 'Títulos e Certificados',
                    'type' => 'select',
                    'options' => [
                        'ONG'   => 'Organização não Governamental (ONG)',
                        'OSCIP' => 'Organização da Sociedade Civil de Interesse Público (OSCIP)',
                        'OS'    => 'Organização Social (OS)',
                        'CEBAS' => 'Certificado de Entidade Beneficente de Assistência Social (CEBAS)',
                        'UPF'   => 'Certificado de Utilidade Pública Federal (UPF)',
                        'UPE'   => 'Certificado de Utilidade Pública Estadual (UPE)',
                        'UPM'   => 'Certificado de Utilidade Pública Municipal (UPM)'
                    ]
                ],
            ],

            'MapasCulturais\Entities\Agent' => [
                'num_sniic' => [
                    'label' => 'Nº SNIIC:',
                    'private' => false
                ]
            ]
        ];
                    
        $prefix = $this->getMetadataPrefix();
                    
        foreach($this->_getAgentMetadata() as $key => $cfg){
            $key = $prefix . $key;
            
            $metadata['MapasCulturais\Entities\Agent'][$key] = $cfg;
        }
                    
        foreach($this->_getSpaceMetadata() as $key => $cfg){
            $key = $prefix . $key;
            
            $metadata['MapasCulturais\Entities\Space'][$key] = $cfg;
        }
                    
        foreach($this->_getEventMetadata() as $key => $cfg){
            $key = $prefix . $key;
            
            $metadata['MapasCulturais\Entities\Event'][$key] = $cfg;
        }
                    
        foreach($this->_getProjectMetadata() as $key => $cfg){
            $key = $prefix . $key;
            
            $metadata['MapasCulturais\Entities\Project'][$key] = $cfg;
        }

        foreach($metadata as $entity_class => $metas){
            foreach($metas as $key => $cfg){
                $def = new \MapasCulturais\Definitions\Metadata($key, $cfg);
                $app->registerMetadata($def, $entity_class);
            }
        }

        $terms = [
            'Antropologia e Etnografia',
            'Arqueologia',
            'Arquivístico',
            'Artes Visuais',
            'Ciências Naturais e História Natural',
            'Ciência e Tecnologia',
            'História',
            'Imagem e Som',
            'Virtual',
            'Outros'
        ];

        $taxo_def = new \MapasCulturais\Definitions\Taxonomy(101, 'mus_area', 'Tipologia de Acervo', $terms, false, true);

        $app->registerTaxonomy('MapasCulturais\Entities\Space', $taxo_def);


        $add_project_types = [
            120 => 'Inscrições',
            121 => 'Pesquisa',
            122 => 'Consulta'
        ];
        foreach($add_project_types as $k => $v)
            $app->registerEntityType(new Definitions\EntityType('MapasCulturais\Entities\Project', $k, $v));
    }


    /**
    * Returns a verified entity
    * @param type $entity_class
    * @return \MapasCulturais\Entity
    */
    function getOneVerifiedEntity($entity_class) {
        $app = \MapasCulturais\App::i();

        $cache_id = __METHOD__ . ':' . $entity_class;

        if($app->cache->contains($cache_id)){
            return $app->cache->fetch($cache_id);
        }



        $controller = $app->getControllerByEntity($entity_class);

        if ($entity_class === 'MapasCulturais\Entities\Event') {
            $entities = $controller->apiQueryByLocation(array(
                '@from' => date('Y-m-d'),
                '@to' => date('Y-m-d', time() + 28 * 24 * 3600),
                '@verified' => 'IN(1)',
                '@select' => 'id'
            ));

        }elseif ($entity_class === 'MapasCulturais\Entities\Space') {
            $entities = $controller->apiQuery([
                '@select' => 'id',
                'mus_verificado' => 'EQ(1)'
            ]);
        }else{

            $entities = $controller->apiQuery([
                '@select' => 'id',
                '@verified' => 'IN(1)',
            ]);
        }

        $ids = array_map(function($item) {
            return $item['id'];
        }, $entities);

        if ($ids) {
            $id = $ids[array_rand($ids)];
            $result = $app->repo($entity_class)->find($id);
            $result->refresh();
        } else {
            $result = null;
        }

        $app->cache->save($cache_id, $result, 120);

        return $result;
    }

    protected function _getFilters()
    {
        $filters = parent::_getFilters();

        $app = App::i();


        $filter_municipio_selext  = [
            'label' => 'Município',
            'placeholder' => 'Pesquisar por Município',
            'filter' => [
                'param' => 'En_Municipio',
                'value' => 'IIN({val})'
            ]
        ];

        $fielder_municipio_txt = [
            'fieldType' => 'text',
            'label' => 'Município',
            'isArray' => false,
            'placeholder' => 'Pesquisar por Município',
            'isInline' => false,
            'filter' => [
                'param' => 'En_Municipio',
                'value' => 'ILIKE(*{val}*)'
            ]
        ];

        $filter_municipio = (count($app->config['busca.lista.municipios']) > 0) ? $filter_municipio_selext : $fielder_municipio_txt;

        $filters['space'] = [
            $filter_municipio,
            [
                'label' => 'Tipologia',
                'placeholder' => 'Selecione os Tipos',
                'filter' => [
                    'param' => 'mus_tipo',
                    'value' => 'IN({val})'
                ],
            ],
            [
                'label' => 'Temática do museu',
                'placeholder' => 'Selecione as Temáticas',
                'filter' => [
                    'param' => 'mus_tipo_tematica',
                    'value' => 'IN({val})'
                ],
            ],
            'verificados' => [
                'label' => $this->dict('search: verified results', false),
                'tag' => $this->dict('search: verified', false),
                'placeholder' => 'Exibir somente ' . $this->dict('search: verified results', false),
                'fieldType' => 'checkbox-verified',
                'addClass' => 'verified-filter',
                'isArray' => false,
                'filter' => [
                    'param' => '@verified',
                    'value' => 'IN(1)'
                ]
            ],

            [
                'isInline' => false,
                'label' => 'Situação de funcionamento',
                'placeholder' => 'Selecione a Situação de funcionamento',
                'filter' => [
                    'param' => 'mus_status',
                    'value' => 'IN({val})'
                ],
            ],
            [
                'label' => 'Esfera',
                'placeholder' => 'Selecione a esfera',
                'isInline' => false,
                'filter' => [
                    'param' => 'esfera',
                    'value' => 'IN({val})'
                ],
            ],
            [
                'isInline' => false,
                'label' => 'Tipo de Esfera',
                'placeholder' => 'Selecione o tipo da esfera',
                'filter' => [
                    'param' => 'esfera_tipo',
                    'value' => 'IN({val})'
                ]
            ]
        ];

        return $filters;
    }
}
