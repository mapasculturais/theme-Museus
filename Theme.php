<?php

namespace MapasMuseus;

use MapasCulturais\App;
use MapasCulturais\Definitions;
use MapasCulturais\i;
use MapasCulturais\Utils;

class Theme extends \MapasCulturais\Themes\BaseV2\Theme{

    public function _init() {
        $app = App::i();
        $self = $this;
        $requiredSpaceFields = [
            'acessibilidade_fisica',
            'mus_resp_formacao',
            'mus_acess_visual_auditiva',
            'mus_acessibilidade_visual',
            'mus_servicos_atendimentoEstrangeiros',
            'mus_subordinado_museu_matriz',
            'mus_museu_matriz',
            'mus_nome_responsavel_instituicao',
            'mus_cpf_responsavel_instituicao',
            'mus_email_responsavel_instituicao',
            'mus_telefone_responsavel_instituicao',
            'mus_funcao_responsavel_instituicao',
            'mus_endereco_correspondencia_visitacao',
            'En_CEP',
            'En_Nome_Logradouro',
            'En_Num',
            'En_Bairro',
            'En_Municipio',
            'En_Estado',
            'emailPublico',
            'emailPrivado',
            'telefonePublico',
            'telefone1',
            'telefone2',
            'capacidade',
            'horario',
            'mus_status',
            'mus_metodo_contagem_pub',
            'mus_ingresso_cobrado',
            'mus_instalacoes',
            'mus_instalacoes_capacidadeAuditorio',
            'mus_arquivo_possui',
            'mus_arquivo_acessoPublico',
            'mus_biblioteca_possui',
            'mus_biblioteca_acessoPublico',
            'mus_equipe_dev_educativo',
            'mus_servicos_visitaGuiada',
            'mus_servicos_visitaGuiada_s',
            'mus_atividade_pub_especif',
            'mus_num_total_acervo_prec',
            'mus_acervo_propriedade',
            'mus_num_acervo_prest', //
            'mus_instr_documento_n',
            'mus_gestao_politicaAquisicao',
            'mus_gestao_politicaDescarte',
            'mus_equipe_tecnica',
            'mus_acervo_material',
            'mus_acervo_material_emExposicao',
            'mus_instumentoCriacao_tipo',
            'esfera',
            'mus_mais_ent_federal',
            'mus_esfera_tipo_federal',
            'mus_priv_esfera_tipo',
            'mus_contrato_gestao',
            'mus_contrato_gestao_s',
            'metodo_contagem_pub_outro', //
            'mus_num_total_acervo',
            'mus_area_outros', //
            'mus_outros_cadastros',
            'mus_tipo_unidadeConservacao',
            'mus_tipo_unidadeConservacao_protecaoIntegral',
            'mus_tipo_unidadeConservacao_usoSustentavel',
            'mus_possui_certificado',
            'possui_certificado',
            'certificado', //
            'cnpj',
            'razao_social',
            'mus_abertura_ano',
            'mus_instituicaoMantenedora',
            'mus_contrato_qualificacoes',
            'mus_contrato_qualificacoes_outra', //
            'mus_num_pessoas',
            'mus_func_tercerizado',
            'mus_func_voluntario',
            'mus_func_estagiario',
            'mus_gestao_regimentoInterno',
            'mus_gestao_planoMuseologico',
            'mus_gestao_planoMuseologico_outro', //
            'mus_tipo',
            'mus_tipo_outro', //
            'mus_ponto_memoria',
            'mus_possui_certificado_ibram', //
            'mus_itinerante',
            'mus_comunidadeRealizaAtividades',
            'mus_tipo_tematica',
            'mus_tipo_tematica_outro', //
            'mus_exposicao_formato',
            'mus_exposicao_formato_outros', //
            'mus_exposicao_museu_cartaz',
            'mus_realiza_atualizacao_expositivo',
            'mus_instituicao_pesquisa',
            'mus_instituicao_informacao_pesquisa',
            'mus_instituicao_informacao_pesquisa_outros', //
            'mus_recebe_pesquisadores',
            'mus_pesquisa_devolutiva',
            'mus_realiza_captacao_recurso',
            'mus_fonte_captacao_recurso',
            'mus_fonte_captacao_recurso_outros', //
            'mus_foi_contemplado_editais',
            'mus_foi_contemplado_editais_quais', //
            'mus_foi_contemplado_editais_secult'
        ];

        /*
         *  Modifica a consulta da API de espaços para só retornar Museus
         *
         * @see protectec/application/conf/space-types.php
         */
        $app->hook('ApiQuery(Space).joins', function(&$joins) use($app) {
            if($seal_id = $app->config['museus.memoryPoint.sealId']) {
                $joins.= "
                    LEFT JOIN 
                            e.__sealRelations sr 
                    WITH
                        sr.seal = {$seal_id}
                ";
            }
        });

        $app->hook('ApiQuery(Space).where', function(&$where) use ($app) {
            $complement = "";
            if($memory_point_seal_id = $app->config['museus.memoryPoint.sealId']) {
                $complement.= "OR sr.seal = {$memory_point_seal_id}";
            }

            $where.= "
                AND (e._type BETWEEN 60 AND 69 {$complement})
            ";
        });

        $app->hook('GET(search.memory)', function() use ($app) {
            $app = App::i();

            $initial_pseudo_query = [];

            $app->applyHookBoundTo($this, 'search-memory-point-initial-pseudo-query', [&$initial_pseudo_query]);

            if($seal_id = $app->config['museus.memoryPoint.sealId']) {
                $initial_pseudo_query['@seals'] = "$seal_id";
            }

            $this->render('space', ['initial_pseudo_query' => $initial_pseudo_query]);
        });

        // Ajusta pseudo query para identificarmos a tela de busca de pontos de memoria
        $app->hook('search-spaces-initial-pseudo-query', function(&$initial_pseudo_query){
            $initial_pseudo_query['@museus'] = 1;
        });

        // Evita que seja carregado os pontos de memoria na tela de busca de museus
        $app->hook('ApiQuery(Space).params', function(&$params){
            if(($params['@museus'] ?? false) && empty($params['type'])) {
                $params['type'] = "BET(60,69)";
                unset($params['@museus']);
            }
        });

        // Remove tipos de museus com relação a rota que esteja acessando Museus ou ponto de memoria
        $app->hook('mapas.printJsObject:before', function() use ($app) {
            /** @var Theme $this */
            if($this->controller->id == "space" && $this->controller->action == "edit") {
                $space = $this->controller->requestedEntity;
                $seal_id = $app->config['museus.memoryPoint.sealId'];

                foreach($space->relatedSeals as $seal) {
                    if($seal->id == $seal_id) {
                        
                        return;
                    }
                }

            } else if($this->controller->id == "search" && $this->controller->action == "memory") {
                return;                
            }

            $options = $this->jsObject['EntitiesDescription']['space']['type']['options'];
            $options_order = $this->jsObject['EntitiesDescription']['space']['type']['optionsOrder'];

            $new_options = [];
            foreach($options as $id => $value) {
                if($id >= 60 && $id <= 69) {
                    $new_options[$id] = $value;
                }
            }

            $options_order = array_filter($options_order, fn($id) => $id >= 60 && $id <= 69);

            $this->jsObject['EntitiesDescription']['space']['type']['options'] = $new_options;
            $this->jsObject['EntitiesDescription']['space']['type']['optionsOrder'] = $options_order;

        }, 1000);

        $app->hook('GET(space.edit):before', function () use($self, $requiredSpaceFields) {
            /** @var Controllers\Space $this */

            $self->spaceRequiredProperties($requiredSpaceFields);
        });

        $app->hook('PUT(space.single):before', function () use($self, $requiredSpaceFields) {
            /** @var Controllers\Space $this */
            $self->spaceRequiredProperties($requiredSpaceFields);
        });

        /* ALTERA O TIPO DE REQUISIÇÃO DO SALVAMENTO DE ESPAÇOS PARA PUT */
        $app->hook('view(space.edit).updateMethod', function(&$update_method) {
            $update_method = 'PUT';
        });

        $app->hook('entity(Space).validationErrors', function (&$errors) use($requiredSpaceFields) {
            /** @var Entities\Space $this */

            if($this->isNew()) {
               return; 
            }

            foreach($requiredSpaceFields as $field) {
                if(!$this->$field && !isset($errors[$field])) {
                    $errors[$field] = [i::__('campo obrigatório')];
                }
            }
        });

        // Ajuste textos entre as paginas de busca de museus e ponto de memoria
        $app->hook('GET(<<*>>):before', function() use ($app) {
            $replacements = [
                // [
                //     "espaço cultural",
                //     "ponto de memória",
                // ],
                // [
                //     "espaços culturais",
                //     "pontos de memória",
                // ],
                // [
                //     "espaços",
                //     "pontos de memória",
                // ],
                // [
                //     "espaço",
                //     "ponto de memória",
                // ],
            ];

            if($this->id == "space" && $this->action == "edit") {
                $space = $this->requestedEntity;
                $seal_id = $app->config['museus.memoryPoint.sealId'];
                foreach($space->relatedSeals as $seal) {
                    if($seal->id == $seal_id) {
                        i::$replacements = $replacements;
                    }
                }

            } else if($this->id == "search" && $this->action == "memory") {

                i::$replacements = $replacements;
            }
        });



        parent::_init();

        $app->hook("component(mc-icon).iconset", function(&$icon){
            $icon['space'] = "fluent:building-bank-16-filled";
        });

        $app->hook('entity(Space).save:after', function() use ($app){
            if(!$this->getValidationErrors() && !$this->mus_cod){
                $getDvFromNumeroIdent = function($numIdent)
                {
                       $dgs = array();
                       for($i=0; $i < strlen($numIdent); $i++)
                               $dgs[] = $numIdent[$i];

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
                    $tot = $conn->fetchScalar("SELECT count(*) FROM space_meta WHERE key = 'mus_cod' and value = '".$new_cod."'");
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
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword, $alias) {
            $where .= "OR lower(mus_cod.value) LIKE lower(:{$alias})";
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
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword, $alias) {
            $where .= "OR lower(num_sniic.value) LIKE lower(:{$alias})";
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
        $app->hook('repo(<<*>>).getIdsByKeywordDQL.where', function(&$where, $keyword, $alias) {
            $where .= "OR lower(En_Municipio.value) LIKE lower(:{$alias})";
        });
        
        $app->hook("template(space.edit.tabs):end", function () {
            $this->part('museus/tab-edit-visitacao');
            $this->part('museus/tab-edit-acervo');
            $this->part('museus/tab-edit-gestao');
            $this->part('museus/tab-edit-pesquisa');
        });
        
        $app->hook("template(space.single.tabs):end", function(){
            $this->part('museus/tab-single-visitacao');
            $this->part('museus/tab-single-acervo');
            $this->part('museus/tab-single-gestao');
            $this->part('museus/tab-single-pesquisa');
        });

        $app->hook("template(space.edit.entity-field-label):after", function(){
           $this->part('museus/field-descriptions-customizations');
        });

        $app->hook("template(space.edit.entity-info):end", function(){
            $this->part('museus/entity-info-fields');
        });

        $app->hook('template(site.index.home-header-content):after', function(){
            $this->part('museus/home-header-content');
        });

        $app->hook('template(<<*>>.<<*>>.mc-header-menu-spaces):after', function() {
            $this->part('museus/mc-header-menu-memory-point');
        });

        $app->hook("template(space.edit.main-mc-card):begin", function(){
            $this->part('museus/card-edit-subordinacao');
        });

        $app->hook("template(space.edit.mc-card-content-address):end", function(){
            $this->part('museus/card-address');
        });

        $app->hook("template(space.edit.mc-card-content-acessibilidade_fisica):end", function(){
            $this->part('museus/card-acessibilidade');
        });
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
                'label' => 'Código do museu',
                'type' => 'text'
            ],

            'instituicaoMantenedora' => [
                'label' => 'Instituição mantenedora'
            ],
            'outros_cadastros' => [
                'label' => 'A instituição já possui cadastro?',
                'type' => 'radio',
                'options' => [
                    '' => 'Não possui',
                    'Cadastro Nacional de Museus - Museusbr',
                    'Conselho Internacional de Museus - ICOM',
                    // 'Cadastro nacional de museus',
                    'Outros',
                ]
            ],
            'resp_formacao' => [
                'label' => 'Formação do responsável',
                'type' => 'radio',
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
                'type' => 'radio',
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
                'type' => 'radio',
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
                'type' => 'radio',
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
                'type' => 'text',
                'validations' => [
                    'v::intVal()' => 'O Mês deve ser um campo inteiro'
                ]
            ],

            'previsao_abertura_ano' =>[
                'label' => 'Previsão de Abertura (Ano)',
                'type' => 'text',
                'validations' => [
                    'v::intVal()' => 'O Ano deve ser um campo inteiro'
                ]
            ],

            'abertura_ano' => [
                'label' => 'Ano de abertura',
                'type' => 'integer',
                'validations' => [
                    'v::intVal()' => 'O ano de abertura deve ser um valor numérico inteiro'
                ]
            ],

            'itinerante' => [
                'label' => 'O museu é itinerante?',
                'type' => 'radio',
                'options' => ['sim', 'não']
            ],

            // tipologia
            'tipo' => [
                'label' => 'Tipo',
                'type' => 'radio',
                'options' => [
                    'Tradicional/Clássico',
                    'Virtual',
                    'Museu de território/Ecomuseu',
                    'Unidade de conservação da natureza',
                    'Jardim zoológico, botânico, herbário, oceanário ou planetário',
                    'Outro'
                ]
            ],
            'tipo_outro' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],
            'ponto_memoria' => [
                'label' => 'O museu é Ponto de Memória',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não'
                ]
            ],
            'possui_certificado_ibram' => [
                'label' => 'Possui Certificação do instituto Brasileiro de Museus - IBRAM',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não'
                ]
            ],

            'tipo_tematica' => [
                'label' => 'Temática do museu',
                'type' => 'radio',
                'options' => [
                    'Artes, arquitetura e linguística',
                    'Antropologia e arqueologia',
                    'Ciências exatas, da terra, biológicas e da saúde',
                    'História',
                    'Educação, esporte e lazer',
                    'Meios de comunicação e transporte',
                    'Produção de bens e serviços',
                    'Defesa e segurança pública',
                    'Outro'
                ]
            ],
            'tipo_tematica_outro' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],
                
            'num_total_acervo' => [
                'label' => 'Informe o número total de bens culturais de caráter museológico que compõem o acervo:',
                'type' => 'text',
            ],

            'num_total_acervo_prec' => [
                'label' => 'O número informado é:',
                'type' => 'radio',
                'options' => [
                    'Exato','Aproximado',
                ],
            ],

            'tipo_unidadeConservacao' => [
                'label' => 'Tipo/categoria de manejo da Unidade de Conservação',
                'type' => 'radio',
                'options' => [
                    '' => 'Não se aplica',
                    'Proteção integral',
                    'Uso sustentável'
                ]
            ],

            'tipo_unidadeConservacao_protecaoIntegral' => [
                'label' => 'Tipo de unidade de proteção integral',
                'type' => 'radio',
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
                'type' => 'radio',
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
                'type' => 'multiselect',
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
                'type' => 'number',
                'validations' => [
                    'v::numericVal()' => 'a capacidade do teatro/auditório deve ser um número inteiro'
                ]
            ],
            'equipe_dev_educativo' => [
                'label' => 'O museu possui equipe PRÓPRIA para desenvolvimento e realização de ações educativas e culturais?',
                'type' => 'radio',
                'options' => ['Sim','Não']
            ],
            'servicos_visitaGuiada' => [
                'label' => 'O museu promove visitas guiadas/mediadas?',
                'type' => 'radio',
                'options' => [ 'sim', 'não']
            ],
            'servicos_visitaGuiada_s' => [
                'label' => 'Em caso positivo, especifique',
                'type' => 'radio',
                'options' => [
                    'SOMENTE mediante agendamento',
                    'Sem necessidade de agendamento'
                ]
            ],
            'servicos_atendimentoEstrangeiros' => [
                'label' => 'Atendimento em outros idiomas',
                'type' =>'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Sinalização visual',
                    'Material de divulgação impresso',
                    'Audioguia',
                    'Guia, monitor,orientador e/ou mediador',
                    '@NA' => 'Não possui'
                ]
            ],
            'acess_visual_auditiva' => [
                'label' => 'O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e/ou visuais?',
                'type' => 'radio',
                'options' => ['Sim', 'Não']
            ],

            'acessibilidade_visual' => [
                'label' => 'Qual/quais?',
                'type'=>'multiselect',
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
                'type' => 'radio',
                'options' => [ 'sim', 'não']
            ],
            'arquivo_acessoPublico' => [
                'label' => 'O arquivo histórico está aberto para consulta de usuários externos?',
                'type' => 'radio',
                'options' => [ 'sim', 'não']
            ],
            'biblioteca_possui' => [
                'label' => 'O Museu possui biblioteca?',
                'type' => 'radio',
                'options' => [ 'sim', 'não']
            ],
            'biblioteca_acessoPublico' => [
                'label' => 'O acervo bibliográfico está aberto para consulta de usuários externos?',
                'type' => 'radio',
                'options' => [
                    '' => 'não se aplica',
                    'sim' => 'sim',
                    'não' => 'não',
                ]
            ],

            // novos campos informações
            'subordinado_museu_matriz' => [
                'label' => 'Está subordinado a algum Museu Matriz?',
                'type' => 'radio',
                'options' => ['Sim', 'Não']
            ],
            'museu_matriz' => [
                'label' => 'Nome do Museu Matriz',
                'type' => 'text',
            ],
            'nome_responsavel_instituicao' => [
                'label' => 'Nome do responsável',
                'type' => 'text',
            ],
            'cpf_responsavel_instituicao' => [
                'label' => 'CPF do responsável',
                'type' => 'cpf',
                'validations' => [
                    'v::cpf()' => 'O número de CPF informado é inválido.'
                ],
                'serialize' => function($value, $entity = null) {
                    return Utils::formatCnpjCpf($value);
                },
                'unserialize' => function($value, $entity) {
                    if (!$value) {
                        $value = $entity->cpf_responsavel_instituicao ?: '';
                    }

                    return Utils::formatCnpjCpf($value);
                }, 
            ],
            'email_responsavel_instituicao' => [
                'label' => 'E-mail do responsável',
                'validations' => [
                    'v::email()' => 'O endereço informado não é um email válido.'
                ],
                'field_type' => 'email',
            ],
            'telefone_responsavel_instituicao' => [
                'label' => 'Telefone do responsável',
                'type' => 'string',
                'validations' => [
                    'v::brPhone()' => 'O número de telefone informado é inválido.'
                ],
                'field_type' => 'brPhone'
            ],
            'funcao_responsavel_instituicao' => [
                'label' => 'Função exercida no museu ',
                'type' => 'textarea',
            ],

            'endereco_correspondencia_visitacao' => [
                'label' => 'O endereço de correspondência é o mesmo de visitação?',
                'type' => 'radio',
                'options' => ['Sim', 'Não']
            ],

            'cep_visitacao' => [
                'label' => 'CEP',
                'type' => 'cep',
            ],

            'logradouro_visitacao' => [
                'label' => 'Logradouro',
            ],

            'numero_visitacao' => [
                'label' => 'Número',
            ],

            'bairro_visitacao' => [
                'label' => 'Bairro',
            ],

            'complemento_visitacao' => [
                'label' => 'Complemento ou ponto de referência',
            ],

            'estado_visitacao' => [
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
                ),
            ],

            'municipio_visitacao' => [
                'label' => 'Município',
                'validations' => [
                    // 'required' => 'O campo é obrigatório'
                ],
            ],

            // acervo
            'acervo_propriedade' => [
                'label' => 'Propriedade do acervo',
                'type' => 'multiselect',
                'options' => [
                    'Possui SOMENTE acervo próprio',
                    'Possui acervo próprio e de doações',
                    'Acervo compartilhado entre órgãos/setores da mesma entidade mantenedora',
                    'Possui SOMENTE acervo em comodato/empréstimo',
                    'NÃO possui acervo'
                ]
                // 'type' => 'radio',
                // 'options' => [
                //     'Possui SOMENTE acervo próprio',
                //     'Possui acervo próprio e em comodato',
                //     'Acervo compartilhado entre órgãos/setores da mesma entidade mantenedora',
                //     'Possui SOMENTE acervo em comodato/empréstimo',
                //     'NÃO possui acervo',
                // ]
            ],

            'num_acervo_prest' => [
                'label' => 'O comodato/empréstimo está formalizado por meio de documento legal?',
                 'type' => 'radio',
                 'options' => [
                 'Sim', 'Não',
                ],
            ],

            'area_outros' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],

            'acervo_material' => [
                'label' => 'O museu possui também acervo material?',
                'type' => 'radio',
                'options' => [
                    'sim' => 'sim',
                    'não' => 'não'
                ]
            ],

            'acervo_material_emExposicao' => [
                'label' => 'O acervo material encontra-se em exposição?',
                'type' => 'radio',
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
                'type' => 'radio',
                'options' => [ 'sim', 'não']
            ],

            'metodo_contagem_pub' => [
                'label' => 'Método de contagem de público',
                'type' => 'select',
                'options' => [
                    'Ingresso',
                    'Livro de assinatura',
                    'Listagem de agendamento',
                    'Outro',
                    '@NA' => 'Não possui'
                ]
            ],
            'metodo_contagem_pub_outro' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],

            'ingresso_cobrado' => [
                'label' => 'O ingresso ao museu é cobrado?',
                'type' => 'radio',
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
                'label' => 'O museu possui regimento interno?',
                'type' => 'radio',
                'options' => ['sim', 'não']
            ],

            'gestao_planoMuseologico' => [
                'label' => 'O museu possui plano museológico?',
                'type' => 'radio',
                'options' => ['sim', 'não']
            ],
            'gestao_planoMuseologico_outro' => [
                'label' => 'Tempo de vigência',
                'type' => 'number',
                'validations' => [
                    'v::numericVal()' => 'a capacidade do teatro/auditório deve ser um número inteiro'
                ]
            ],

            'gestao_politicaAquisicao' => [
                'label' => 'O museu possui política de aquisição de acervo?',
                'type' => 'radio',
                'options' => ['sim', 'não']
            ],

            'gestao_politicaDescarte' => [
                'label' => 'O museu possui política de descarte de acervo?',
                'type' => 'radio',
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
                'type' => 'radio',
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
                'type' => 'radio',
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
                'type' => 'radio',
                'allowOther' => true,
                'allowOtherText' => 'Outra',
                'options' => [
                    'Associação',
                    'Fundação',
                    'Sociedade (incluem-se aqui as sociedades de economia mista, empresas públicas e privadas)',
                    'Outros'
                ]
            ],
            'contrato_gestao_s_outros_outros' => [
                'label' => 'Quais?',
                'type' => 'text'
            ],

            'contrato_qualificacoes' => [
                'label' => 'A contratada possui qualificações?',
                'type' => 'radio',
                'allowOther' => true,
                'allowOtherText' => 'Outra',
                'options' => [
                    'OS',
                    'OSCIP',
                    'Não possui qualificações',
                    'Outra'
                ]
            ],
            'contrato_qualificacoes_outra' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],

            'num_pessoas' => [
                'label' => 'Quantas pessoas trabalham no museu (contabilizar terceirizados, estagiários e voluntários)?',
                'type' => 'integer',
                'validations' => [
                    'v::intVal()' => 'O Mês deve ser um campo inteiro'
                ]
            ],
            'func_tercerizado' => [
                'label' => 'O museu possui funcionários terceirizados?',
                'type' => 'radio',
                'options' => [
                    's' => 'Sim', 
                    'n' => 'Não'
                ]
            ],
            'func_tercerizado_s' => [
                'label' => 'Em caso positivo, especifique quantos',
                'type' => 'integer',
                'validations' => [
                    'v::intVal()' => 'O número de funcionários deve ser um número inteiro'
                ]
            ],
            'func_voluntario' => [
                'label' => 'O museu possui voluntários?',
                'type' => 'radio',
                'options' => [
                    's' => 'Sim',
                    'n' => 'Não'
                ]
            ],
            'func_estagiario' => [
                'label' => 'O museu possui estagiários?',
                'type' => 'radio',
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
            ],

            // Pesquisa
            'exposicao_formato' => [
                'label' => 'O Museu realiza exposições de qual formato?',
                'type' => 'multiselect',
                'options' => [
                    'Curta duração',
                    'Itinerantes',
                    'Virtuais',
                    'Mantém apenas a exposição de longa duração',
                    'Outros'
                ]
            ],
            'exposicao_formato_outros' => [
                'label' => 'Quais?',
                'type' => 'text'
            ],
            'exposicao_museu_cartaz' => [
                'label' => 'Há quanto tempo a exposição do museu está em cartaz?',
                'type' => 'select',
                'options' => [
                    '1 a 3 anos',
                    '4 a 7 anos',
                    '8 a 10 anos',
                    'Mais de 10 anos',
                    'Não possui exposição de longa duração'
                ]
            ],
            'realiza_atualizacao_expositivo' => [
                'label' => 'O Museu realiza atualização do seu conteúdo/acervo expositivo',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'instituicao_pesquisa' => [
                'label' => 'A instituição desenvolve atividade de pesquisa?',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'instituicao_informacao_pesquisa' => [
                'label' => '',
                'type' => 'select',
                'options' => [
                    'Mediações',
                    'Contribuem para produção de conteúdos para o museu',
                    'Contribuem produção de artigos científicos',
                    'Outros'
                ]
            ],
            'instituicao_informacao_pesquisa_outros' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],
            'recebe_pesquisadores' => [
                'label' => 'O Museu recebe pesquisadores e/ou instituições para realização de pesquisas?',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'pesquisa_devolutiva' => [
                'label' => 'As pesquisas que utilizam a instituição do museu como instrumento, fornecem algum tipo de devolutiva?',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'realiza_captacao_recurso' => [
                'label' => 'O museu realiza captação de recursos financeiros?',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'fonte_captacao_recurso' => [
                'label' => '',
                'type' => 'select',
                'options' => [
                    'Patrocínio local',
                    'Lei Rouanet',
                    'Editais de Fomento Nacional',
                    'Editais de Fomento Estadual',
                    'Editais de Fomento Municipal',
                    'Outros'
                ]
            ],
            'fonte_captacao_recurso_outros' => [
                'label' => 'Qual?',
                'type' => 'text'
            ],
            'foi_contemplado_editais' => [
                'label' => 'O museu já foi contemplado em editais publicados pelo município',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'foi_contemplado_editais_quais' => [
                'label' => 'Qual/quais?',
                'type' => 'text'
            ],
            'foi_contemplado_editais_secult' => [
                'label' => 'O museu já foi contemplado em editais publicados pelo Estado ou Secult/PE? ',
                'type' => 'radio',
                'options' => [
                    'Sim',
                    'Não',
                ]
            ],
            'foi_contemplado_editais_secult_quais' => [
                'label' => 'Qual/quais?',
                'type' => 'text'
            ]
        ];
    }

    function register() {
        parent::register();
        $app = App::i();

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
                    'type' => 'text',
                'validations' => array(
                    'unique' => 'Este CNPJ já está cadastrado em nosso sistema.',
                    'v::cnpj()' => 'O CNPJ é inválido.'
                )
                    
                ],
                
                'esfera' => [
                    'label' => 'Identifique dentre as opções abaixo aquela que caracteriza o museu:',
                    'type' => 'radio',
                    'options' => [
                        'Pública',
                        'Privada'
                    ]
                ],
                
                'esfera_tipo' => [
                    'label' => 'Em caso de público, especifique:',
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

                'possui_certificado' => [
                    'label' => 'O museu possui Títulos, Certificados, prêmios',
                    'type' => 'radio',
                    'options' => [
                        'Sim',
                        'Não',
                    ]
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

                'razao_social' => [
                    'label' => 'Razão social',
                    'type' => 'text'
                ]
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

    public function spaceRequiredProperties(array $required_metadata) {
        $app = App::i();

        $metadata = $app->getRegisteredMetadata('MapasCulturais\Entities\Space');

        foreach($metadata as $meta) {
            if(in_array($meta->key, $required_metadata)) {
                $meta->is_required = true;
            }
        }
    }
}
