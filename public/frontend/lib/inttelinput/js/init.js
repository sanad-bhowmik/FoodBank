var input = document.querySelector("#number");
var iti = window.intlTelInput(input, {
    separateDialCode: true,
    initialCountry: "",
    customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
        return selectedCountryPlaceholder;
    }
});

$(input).on('countrychange', function(e, countryData) {
    $("#code").val(iti.getSelectedCountryData().dialCode);
});

