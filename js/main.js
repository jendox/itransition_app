function selectCheckboxes() {
    var mainCheckbox = document.getElementById("mainCheckbox");
    var checkBoxes = document.getElementsByClassName("userCheckbox");
    if (checkBoxes.length != 0) {
        for (var i=0; i < checkBoxes.length; i++) {
            checkBoxes[i].checked = mainCheckbox.checked;
        }
    }
}
