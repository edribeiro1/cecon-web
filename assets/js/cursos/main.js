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
                    }
                ]
            });
        }
    });
});