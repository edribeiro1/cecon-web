var baseUrl = $('body').attr('data-baseurl');
$(document).ready(function () {
   
    $('#logout').click(function (e) {
        e.stopPropagation()
    });
});

function dataHoraBR(dataEN) {
    return dataEN.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1");
}
