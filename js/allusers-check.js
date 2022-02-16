$(document).ready(function () {

    $('#mainCheckbox').click((e) => {
        for(let user of $('.userCheckbox')) {
            user.checked = e.currentTarget.checked;
        }
    });

});