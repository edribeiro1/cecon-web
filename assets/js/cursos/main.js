$(function () {
    $(document).ready(function () {

        if ($('#grid-lista').length > 0) {
            TABLE.init({
                uniqueId: 'id',
                columns: [
                    {
                        checkbox: true
                    },
                    {
                        title: 'ID',
                        field: 'id',
                        sortable: true,
                    },
                    {
                        title: 'Descrição',
                        field: 'descricao',
                        sortable: true,
                    },
                    {
                        title: 'Data de cadastro',
                        field: 'data_cadastro',
                        sortable: true,
                    },
                    {
                        title: 'Data de alteração',
                        field: 'data_alteracao',
                        sortable: true,
                    }
                ]
            });
        } else {
            let id = parseInt($('#config-form').attr('data-id'));
            if(id > 0) {
                loadingInputs();
                REQUESTER.enviar(REQUESTER.gerarUrl('cursos/get/'+id),"", {
                    type: 'GET',
                    success: function(data) {
                        preencheDadosFormulario(data);
                        loadingInputs(false);
                    },
                });
            }
        }
    });
});