app.component('museum-filters', {
    template: $TEMPLATES['museum-filters'],

    props: {
        pseudoQuery: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            municipios: $MAPAS.config.filter.municipios,
            status: $DESCRIPTIONS.space.mus_status.options,
            tematica: $DESCRIPTIONS.space.mus_tipo_tematica.options,
            tipologia: $DESCRIPTIONS.space.mus_tipo.options,
            esferaTipo: $DESCRIPTIONS.space.esfera_tipo.options,
        }
    },
});
