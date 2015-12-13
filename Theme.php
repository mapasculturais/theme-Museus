<?php

namespace MapasMuseus;

use BaseMinc;
use MapasCulturais\App;

class Theme extends BaseMinc\Theme {

    protected static function _getTexts() {
        return array(
            'site: name' => 'Museus',
            'site: in the region' => 'SNB',
            'site: of the region' => 'SNB',
            'site: owner' => 'SNB',
            'site: by the site owner' => 'pelo Ministério da Cultura',
            'home: abbreviation' => "SNB",
            'home: title' => "Bem-vind@!",
//            'home: colabore' => "Colabore com o Mapas Culturais",
            'home: welcome' => "Bem-vindo ao <strong>Museus BR</strong> - a maior plataforma de informações sobre os museus existentes no Brasil.<br><br>

Você vai descobrir que nosso país é muito rico e que tem museus para todos os gostos e interesses. Em Museus BR você encontrará Museus de Arte, de História, de Ciências, de Antropologia, Museus Comunitários, Museus de Território, Museus das mais variadas temáticas e muitos outros que você sequer imagina.<br><br>

Aqui você verificará onde estão localizados os museus do seu estado, do seu município ou de qualquer outro lugar de seu interesse, encontrando os dados de contato e serviços oferecidos como: visitas guiadas, acessibilidade, bibliotecas, arquivos, atendimento a visitantes estrangeiros e muito mais.<br><br>

Seja qual for a pesquisa, a Plataforma Museus BR permitirá extrair os dados dos museus em formato de planilha, por meio de filtros e cruzamentos. <br><br>

Como a Plataforma é colaborativa, você também pode participar, indicando um museu que você conheça e que ainda não faça parte da Museus BR, ou atualizando alguma informação. Basta seguir os passos na seção Como Participar. <br><br>

Aventure-se!<br>
Participe!<br>
Descubra o Brasil por meio dos seus museus!<br>

<p style='text-align:right'>Rede Nacional de Identificação de Museus</p>",
//            'home: events' => "Você pode pesquisar eventos culturais nos campos de busca combinada. Como usuário cadastrado, você pode incluir seus eventos na plataforma e divulgá-los gratuitamente.",
//            'home: agents' => "Você pode colaborar na gestão da cultura com suas próprias informações, preenchendo seu perfil de agente cultural. Neste espaço, estão registrados artistas, gestores e produtores; uma rede de atores envolvidos na cena cultural paulistana. Você pode cadastrar um ou mais agentes (grupos, coletivos, bandas instituições, empresas, etc.), além de associar ao seu perfil eventos e espaços culturais com divulgação gratuita.",
            'home: spaces' => "Procure os museus incluídos na plataforma, acessando os campos de busca combinado que ajudam na precisão de sua pesqusia.",
//            'home: projects' => "Reúne projetos culturais ou agrupa eventos de todos os tipos. Neste espaço, você encontra leis de fomento, mostras, convocatórias e editais criados, além de diversas iniciativas cadastradas pelos usuários da plataforma. Cadastre-se e divulgue seus projetos.",
//            'home: home_devs' => 'Existem algumas maneiras de desenvolvedores interagirem com o Mapas Culturais. A primeira é através da nossa <a href="https://github.com/hacklabr/mapasculturais/blob/master/doc/api.md" target="_blank">API</a>. Com ela você pode acessar os dados públicos no nosso banco de dados e utilizá-los para desenvolver aplicações externas. Além disso, o Mapas Culturais é construído a partir do sofware livre <a href="http://institutotim.org.br/project/mapas-culturais/" target="_blank">Mapas Culturais</a>, criado em parceria com o <a href="http://institutotim.org.br" target="_blank">Instituto TIM</a>, e você pode contribuir para o seu desenvolvimento através do <a href="https://github.com/hacklabr/mapasculturais/" target="_blank">GitHub</a>.',
//
//            'search: verified results' => 'Resultados Verificados',
//            'search: verified' => "Verificados"
            
                        
            'entities: Spaces of the agent'=> 'Museus do agente',
            'entities: Space Description'=> 'Descrição do Museu',
            'entities: My Spaces'=> 'Meus Museus',
            'entities: My spaces'=> 'Meus museus',
            
            'entities: no registered spaces'=> 'nenhum museu cadastrado',
            'entities: no spaces'=> 'nenhum museu',
            
            'entities: Space' => 'Museu',
            'entities: Spaces' => 'Museus',
            'entities: space' => 'museu',
            'entities: spaces' => 'museus',
            'entities: parent space' => 'museu mãe',
            'entities: a space' => 'um museu',
            'entities: the space' => 'o museu',
            'entities: of the space' => 'do museu',
            'entities: In this space' => 'Neste museu',
            'entities: in this space' => 'neste museu',
            'entities: registered spaces' => 'museus cadastrados',
            'entities: new space' => 'novo museu',
        );
    }

    protected function _init() {
        $app = App::i();

        /*
         *  Modifica a consulta da API de espaços para só retornar Museus
         * 
         * @see protectec/application/conf/space-types.php
         */
        $app->hook('API.<<*>>(space).query', function(&$data, &$select_properties, &$dql_joins, &$dql_where) {
            $dql_where .= ' AND e._type >= 60 AND e._type <= 69';
        });

        parent::_init();

        $app->hook('template(space.<<create|edit|single>>.tabs):end', function(){
            $this->part('tabs-museu', ['entity' => $this->data->entity]);
        });

        $app->hook('template(space.<<create|edit|single>>.tabs-content):end', function(){
            $this->part('tab-publico', ['entity' => $this->data->entity]);
            $this->part('tab-mais', ['entity' => $this->data->entity]);
        });
        
        $app->hook('template(space.edit.tab-about-service):begin', function(){
            $this->part('about-servive-begin', ['entity' => $this->data->entity]);
        });

        /*
        $app->hook('template(space.<<create|edit|single>>.acessibilidade):after', function(){
            $this->part('acessibilidade', ['entity' => $this->data->entity]);
        });
        */
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
            
            'status' => [
                'label' => 'Status do Museu',
                'type' => 'select',
                'options' => [
                    'aberto' => 'Aberto',
                    'fechado' => 'Fechado',
                    'implantacao' => 'Em implantação'
                ]
            ],
            
            'horario_segunda_das' => [
                'label' => 'Aberto nas segundas-feiras das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_segunda_ate' => [
                'label' => 'Aberto nas segundas-feiras até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_terca_das' => [
                'label' => 'Aberto nas terças-feiras das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_terca_ate' => [
                'label' => 'Aberto nas terças-feiras até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_quarta_das' => [
                'label' => 'Aberto nas quartas-feiras das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_quarta_ate' => [
                'label' => 'Aberto nas quartas-feiras até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_quinta_das' => [
                'label' => 'Aberto nas quintas-feiras das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_quinta_ate' => [
                'label' => 'Aberto nas quintas-feiras até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_sexta_das' => [
                'label' => 'Aberto nas sextas-feiras das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_sexta_ate' => [
                'label' => 'Aberto nas sextas-feiras até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_sabado_das' => [
                'label' => 'Aberto nos sábados das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_sabado_ate' => [
                'label' => 'Aberto nos sábados até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_domingo_das' => [
                'label' => 'Aberto nos domingos das (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'horario_domingo_ate' => [
                'label' => 'Aberto nos domingos até as (00:00)',
                'validations' => [
                    'v::date("H:i:s")'
                ]
            ],
            'servicos_instalacoes' => [
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
            'servicos_instalacoes_capacidadeAuditorio' => [
                'label' => 'Capacidade do teatro/auditório (assentos)',
                'type' => 'int',
                'validations' => [
                    'v::numeric()' => 'a capacidade do teatro/auditório deve ser um número inteiro'
                ]
            ],
            'servicos_visitaGuiada' => [
                'label' => 'O museu promove visitas guiadas?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_atendimentoEstrangeiros' => [
                'label' => 'Atendimento em outros idiomas',
                'multiselect',
                'options' => [
                    'Sinalização visual',
                    'Material de divulgação impresso',
                    'Audioguia',
                    'Guia, monitor e/ou mediador'
                ]
            ],
            'acessibilidade_fisica' => [
                'label' => 'O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?',
                'multiselect',
                'options' => [
                    'Bebedouro adaptado',
                    'Cadeira de rodas para uso do visitante',
                    'Circuito de visitação adaptado',
                    'Corrimão nas escadas e rampas',
                    'Elevador adaptado',
                    'Rampa de acesso',
                    'Sanitário adaptado',
                    'Telefone público adaptado',
                    'Vaga de estacionamento exclusiva para deficientes',
                    'Vaga de estacionamento exclusiva para idosos'
                ]
            ],
            'acessibilidade_visual' => [
                'label' => 'O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?',
                'multiselect',
                'options' => [
                    'Guia multimídia (com monitor)',
                    'Maquetes táteis ou mapas em relevo',
                    'Obras e reproduções táteis',
                    'Tradutor de Linguagem Brasileira de Sinais (LIBRAS)',
                    'Texto/Etiquetas em braile com informações sobre os objetos expostos',
                    'Outros'
                ]
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
                'options' => [ 'sim', 'não']
            ],
            
            //cnpj do baseminc
            
            'atividadePrincipal' => [
                'label' => 'Em relação à sua atividade principal, indique a opção que melhor caracterize a instituição',
                'type' => 'singleselect',
                'options' => [
                    'Arquivo',
                    'Biblioteca',
                    'Centro cultural',
                    'Museu',
                    'Galeria'
                ]
            ],
            
            
            
            // FALTA DEFINIR SE VAI PARA O CORE
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
        ];

        /*
            'leiCriacao' => [
                'label' => 'Lei de criação',
            ],
            'condicaoFuncionamento' => [
                'label' => 'Condição de funcionamnto',
                'type' => 'select',
                'options' => [
                    'aberta' => 'Aberta/Em funcionamento',
                    'fechada' => 'Fechada',
                    'restrito' => 'Acesso restrito'
                ]
            ],
            // PÚBLICO
            'faixaEtariaPredominante' => [
                'label' => 'Faixa etária predominante dos usuários da museu',
                'type' => 'select',
                'options' => [
                    '0' => 'Até 14 anos',
                    '15' => 'De 15 até 25 anos',
                    '26' => 'De 26 até 40 anos',
                    '41' => 'De 41 até 60 anos',
                    '61' => 'Acima de 60 anos',
                ]
            ],
            'comunidades' => [
                'label' => 'Comunidades ou grupos específicos',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Quilombolas',
                    'Indígenas',
                    'Imigrantes',
                ]
            ],
            'publico_frequenciaMedia' => [
                'label' => 'Freqüência média mensal dos usuários na museu',
                'type' => 'select',
                'options' => [
                    '0' => 'Até 300 usuários por mês',
                    '301' => 'De 301 até 500 usuários por mês',
                    '501' => 'De 501 até 1.000 usuários por mês',
                    '1000' => 'De 1.000 até 10.000 usuários por mês',
                    '10000' => 'Acima de 10.000 usuários por mês',
                ]
            ],
            // DADOS SOBRE ACERVO
            'acervo_possuiPolitica' => [
                'label' => 'Possui política de formação, desenvolvimento e tratamento de coleções',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'acervo_numItens' => [
                'label' => 'Total de itens do acervo',
                'type' => 'select',
                'options' => [
                    '0' => 'até 2.000 itens',
                    '2001' => 'De 2.001 até 5.000 itens',
                    '5001' => 'De 5.001 até 10.000 itens',
                    '10001' => 'De 10.000 até 50.000 itens',
                    '50001' => 'De 50.000 até 100.000 itens',
                    '100001' => 'Mais de 100.000 itens',
                ]
            ],
            'acervo_formaAquisicao' => [
                'label' => 'Forma de aquisição do acervo',
                'type' => 'multiselect',
                'options' => [
                    'compra',
                    'doação',
                    'permuta'
                ]
            ],
            'acervo_colecoes' => [
                'label' => 'A museu possui em seu acervo coleção de escritores ou de temas regionais',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'acervo_tipos' => [
                'label' => 'Forma de aquisição do acervo',
                'type' => 'multiselect',
                'options' => [
                    'materiais bibliográficos' => 'Materiais bibliográficos (livros, teses, dissertações e etc.)',
                    'periódicos' => 'Periódicos (Jornais, revistas e etc.)',
                    'multimídia' => 'Multimídia (CD, DVD e etc.)',
                    'iconográficos' => 'Iconográficos (fotografias, gravuras, etc.)',
                    'cartográficos' => 'Cartográficos (mapas, etc.)',
                    'partituras' => 'Partituras',
                    'manuscritos' => 'Obras raras e manuscritos'
                ]
            ],
            'acervo_sistemaClassificacao' => [
                'label' => 'Qual sistemas de classificação é utilizado?',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Caso utilize outro, especifique',
                'options' => [
                    'nenhum' => 'Nenhum',
                    'cdu' => 'Classificação Decimal Universal (CDU)',
                    'cdd' => 'Classificação Decimal de Dewey (CDD)'
                ]
            ],
            'acervo_cadastro' => [
                'label' => 'Cadastro Bibliográfico',
                'type' => 'select',
                'options' => [
                    'nenhum' => 'Não possui',
                    'manual' => 'Manual - em ficha papel',
                    'eletronico' => 'Eletrônico'
                ]
            ],
            'acervo_url' => [
                'label' => 'Endereço de catálogo bibliográfico para acesso online',
                'validations' => [
                    'v::url()' => 'Url inválida'
                ]
            ],
            'acervo_sistemaGerenciamento' => [
                'label' => 'Sistema de gerenciamento eletrônico utilizado no acervo',
                'type' => 'select',
                'options' => [
                    'Museu Pessoal',
                    'BookDB',
                    'BiblioteQ',
                    'MiniBiblio',
                    'Tellico',
                    'BibLivre',
                    'Emilda',
                    'Evergreen',
                    'GNUTeca',
                    'Koha',
                    'Library a la carte',
                    'NewGenLib',
                    'OpenBiblio',
                    'PHL',
                    'PMB',
                    'Scriblio',
                    'Museu Fácil',
                    'Biblio Express',
                    'Museu Stylo',
                    'Book In Plus',
                    'Book Label 2012',
                    'Books Program',
                    'Aleph',
                    'Alexandria ',
                    'Arches Lib',
                    'BiblioBase',
                    'Biblioshop',
                    'Biblium',
                    'Caribe',
                    'Dixi',
                    'GIZ Museu',
                    'Informa',
                    'Pergamum',
                    'Sábio',
                    'Siabi',
                    'Sophia',
                    'Sysbibli',
                    'Thesaurus',
                ]
            ],
            'acervo_acessoEstantes' => [
                'label' => 'Acesso às estantes',
                'type' => 'select',
                'options' => [
                    'aberto',
                    'restrito'
                ]
            ],
            // DADOS SOBRE A INFRAESTRUTURA FÍSICA E ACESSO À INTERNET
            'infra_predio_propriedade' => [
                'label' => 'Propriedade do local onde a museu encontra-se instalada',
                'type' => 'select',
                'options' => [
                    'próprio',
                    'alugado',
                    'cedido',
                ]
            ],
            'infra_predio_divideEspaco' => [
                'label' => 'Divide o espaço com outro equipamento público?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'infra_predio_espacosDiferenciados' => [
                'label' => 'Espaços diferenciados para públicos, acervos e atividades',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Se houver outros, especifique',
                'options' => [
                    'Atendimento',
                    'Leitura',
                    'Salas individuais de leitura',
                    'Multimídia',
                    'Acesso à internet',
                    'Infantil',
                    'Públicos com necessidades especiais',
                    'Auditório',
                    'Sala para cursos e oficinas',
                    'Espaços de sociabilidade',
                    'Serviços técnicos administrativos',
                ]
            ],
            'infra_predio_areaConstruida' => [
                'label' => 'Área aproximada da museu (área construída aproximada)',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'a área aproximada deve ser um número inteiro'
                ]
            ],
            'infra_computadores_numero' => [
                'label' => 'Número de computadores que a museu possui',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'o número de computadores deve ser um número inteiro'
                ]
            ],
            'infra_computadores_internet' => [
                'label' => 'Os computadores possuem acesso à internet?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'infra_computadores_acesso' => [
                'label' => 'Acesso aos computadores',
                'type' => 'select',
                'options' => [
                    'restrito' => 'Restrito – para uso interno dos funcionários',
                    'aberto' => 'Aberto – disponibiliza computadores para os usuários'
                ]
            ],
            'infra_computadores_disponiveis' => [
                'label' => 'Número de computadores com acesso a internet que estão disponíveis para o público',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'o número de computadores deve ser um número inteiro'
                ]
            ],
            'infra_wifi' => [
                'label' => 'Oferece serviço de acesso à internet Wi-Fi?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'infra_telecentro_possui' => [
                'label' => 'A museu possui telecentro?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'infra_telecentro_integrado' => [
                'label' => 'O Telecentro funciona integrado à Museu?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            // DAD0S SOBRE ACESSIBILIDADE
            'acessibilidade_material' => [
                'label' => 'Acessibilidade material',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Se houver outros, especifique',
                'options' => [
                    'Livro em Braille',
                    'Audio Livro',
                    'Impressão em Braille',
                    'Mobiliário adaptado',
                    'Tecnologia assistida',
                    'Software para acessibilidade – qual?'
                ]
            ],
            'acessibilidade_servico' => [
                'label' => 'Serviço a pessoas com deficiência?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            // DADOS SOBRE GESTÃO
            'gestao_regulamento' => [
                'label' => 'Regulamento',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'gestao_dirigente_nome' => [
                'label' => 'Nome do dirigente da museu'
            ],
            'gestao_dirigente_sexo' => [
                'label' => 'Sexo do dirigente da museu',
                'type' => 'select',
                'options' => [ 'Feminino', 'Masculino']
            ],
            'gestao_dirigente_faixaEtaria' => [
                'label' => 'Faixa etária do dirigente da museu',
                'type' => 'select',
                'options' => [
                    '0' => 'Até 30 anos',
                    '30' => 'De 30 a 40 anos',
                    '41' => 'De 41 a 50 anos',
                    '51' => 'De 51 a 60 anos',
                    '61' => 'Acima de 60 anos',
                ]
            ],
            'gestao_dirigente_email' => [
                'label' => 'E-mail do dirigente da museu',
                'validation' => [
                    'v::email()' => 'O email informado é inválido.'
                ]
            ],
            'gestao_dirigente_formacao' => [
                'label' => 'Formação do dirigente da museu',
                'type' => 'select',
                'allowOther' => true,
                'allowOtherText' => 'Em caso de graduação em outro curso, especifique',
                'options' => [
                    'Pós-graduação',
                    'Graduação em Biblioteconomia',
                    'Ensino Médio',
                    'Ensino Médio Incompleto',
                    'Ensino Fundamental II - 5° até 9° ano',
                    'Ensino Fundamental I - 1° até  4° ano',
                ]
            ],
            'funcionarios_contratados_num' => [
                'label' => 'Número total de funcionários contratados da museu',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'O número total de funcionários deve ser um número inteiro'
                ]
            ],
            'funcionarios_museurios_num' => [
                'label' => 'Número total de Bibliotecários graduados',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'O número total de museurios deve ser um número inteiro'
                ]
            ],
            'voluntarios_num' => [
                'label' => 'Número de voluntários',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'O número de voluntários deve ser um número inteiro'
                ]
            ],
            'programasGovernamentais' => [
                'label' => 'Programas Governamentais que a museu participou ou foi contemplada',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Especifique outros programas que a museu participou ou foi contemplada',
                'options' => [
                    'Agentes de Leitura - MinC',
                    'Implantação - MinC',
                    'Modernização - MinC',
                    'Proler – MinC',
                    'Sala Verde - MMA',
                    'Telecentro – MC',
                    'Ponto de Leitura - MinC',
                ]
            ],
            'comissao_possui' => [
                'label' => 'Possui comissão ou conselho de museu?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'associacao_possui' => [
                'label' => 'Possui associação de amigos da museu?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'associacao_nome' => [
                'label' => 'Nome da associação'
            ],
            'associacao_cnpj' => [
                'label' => 'CNPJ da associação',
            ],
            'associacao_email' => [
                'label' => 'E-mail da associação',
                'validation' => [
                    'v::email()' => 'O email informado é inválido.'
                ]
            ],
            'parcerias_descricao' => [
                'label' => 'Descrição das parcerias',
                'type' => 'text'
            ],
            'estagio_programa' => [
                'label' => 'Participa de programas de estágio supervisionado junto as Escolas de Biblioteconomia da região?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'participaPMLL' => [
                'label' => 'Participa ou participou do processo de implantação do Plano Municipal do Livro e da Leitura (PMLL) no seu município?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            // DADOS SOBRE SERVIÇOS E ATIVIDADES
            'servicos_emprestimos_realiza' => [
                'label' => 'Realiza empréstimos?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_emprestimos_mediaMensal' => [
                'label' => 'Média mensal de empréstimos',
                'type' => 'int',
                'validation' => [
                    'v::intVal()' => 'O valor deve ser um número inteiro'
                ]
            ],
            'assuntosMaisProcurados' => [
                'label' => 'Assuntos mais procurados',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Artes',
                    'Biografias',
                    'Ciências Exatas',
                    'Ciências Sociais',
                    'Filosofia e Psicologia',
                    'História e Geografia',
                    'Literatura em geral',
                    'Literatura infantil e juvenil',
                    'Religião'
                ]
            ],
            'servicos_atendimento' => [
                'label' => 'Serviço de informação e atendimento',
                'type' => 'select',
                'options' => [
                    'Presencial',
                    'A distância'
                ]
            ],
            'servicos_orientacao_acessoInformacaoPublica' => [
                'label' => 'Serviço de orientação e acesso à informação pública?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_orientacao_consultaLocal' => [
                'label' => 'Serviço de orientação à consulta local?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_orientacao_pesquisaEscolar' => [
                'label' => 'Serviço de orientação e apoio a pesquisa escolar?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_orientacao_usoPedagogicoInternet' => [
                'label' => 'Serviço de orientação ao uso pedagógico da internet?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_orientacao_pesquisaAcademica' => [
                'label' => 'Serviço de orientação e apoio a pesquisa acadêmica?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_orientacao_acessoInternet' => [
                'label' => 'Serviço de orientação e acesso à internet?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_disseminacaoSeletivaInformacao' => [
                'label' => 'Serviço de disseminação seletiva da informação?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_acessoBaseDados' => [
                'label' => 'Acesso à base de dados?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_impressao' => [
                'label' => 'Serviço de impressão',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_digitalizacao' => [
                'label' => 'Serviço de digitalização',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_acaoCultural' => [
                'label' => 'Ações culturais',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outras',
                'options' => [
                    'Mediação de leitura',
                    'Grupos de leitura',
                    'Palestras',
                    'Exposições',
                    'Oficinas e cursos',
                    'Eventos (encontros, saraus, feiras, etc.)'
                ]
            ],
            'servicos_atividadesMunicipais_participa' => [
                'label' => 'A Museu participa de atividades/eventos municipais na área de cultura, educação e/ou outras áreas?',
                'type' => 'select',
                'options' => [ 'sim', 'não']
            ],
            'servicos_extensao' => [
                'label' => 'Serviço de extensão',
                'type' => 'multiselect',
                'allowOther' => true,
                'allowOtherText' => 'Outros',
                'options' => [
                    'Caixa-estante',
                    'Ônibus museu',
                    'Atividades de leitura fora da museu'
                ]
            ]
        ];
        */
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
    }

}
