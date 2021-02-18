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
                        title: 'Nome',
                        field: 'nome',
                        sortable: true,
                    },
                    {
                        title: 'Login',
                        field: 'usuario',
                        sortable: true,
                    },
                    {
                        title: 'Inscrição',
                        field: 'inscricao',
                        sortable: true,
                    },
                    {
                        title: 'E-mail',
                        field: 'email',
                        sortable: true,
                    },
                    {
                        title: 'Sexo',
                        field: 'sexo',
                        sortable: true,
                    },
                    {
                        title: 'RG',
                        field: 'rg',
                        sortable: true,
                    },
                    {
                        title: 'CPF',
                        field: 'cpf',
                        sortable: true,
                    },
                    {
                        title: 'Data de nascimento',
                        field: 'data_nascimento',
                        sortable: true,
                    },
                    {
                        title: 'Data de cadastro',
                        field: 'data_registro',
                        sortable: true,
                    }
                ]
            });
        }
        else {
            
            $('#data_nascimento').bootstrapMaterialDatePicker({
                format: 'DD/MM/YYYY',
                lang: 'pt-br',
                cancelText: 'Cancelar',
                clearButton: true,
                clearText: 'Limpar',
                time: false
            });

            // var promises = [];
            // promises.push(
            //     new Promise(function (resolve, reject) {
            //         REQUESTER.enviar(REQUESTER.gerarUrl('filial/lista'), "", {
            //             type: 'GET',
            //             success: function (data) {
            //                 for (i in data.rows) {
            //                     $('#usu_id_filial').append("<option value='" + data.rows[i].fil_id + "'>" + data.rows[i].fil_nome_fantasia + "</option>");
            //                 }
            //                 resolve();
            //             },
            //             error: function () {
            //                 reject();
            //             }
            //         });
            //     })
            // );

            // Promise.all(promises).then(function (cb) {
            //     let id = parseInt($('#config-form').attr('data-id'));
            //     if (id > 0) {
            //         REQUESTER.enviar(REQUESTER.gerarUrl('usuario/' + id), "", {
            //             type: 'GET',
            //             success: function (data) {
            //                 preencheDadosFormulario(data.data);
            //             }
            //         });
            //     }

            // });

        }
    });
});