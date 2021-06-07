var $inputForm;
var $inputValidForm;
function mapear(maproute) {
    $('input[id="txtOrigem[' + maproute + ']"]').on("change", function () {
        var txtOrigem = document.getElementById("txtOrigem[" + maproute + "]");
        var txtDestino = document.getElementById("txtDestino[" + maproute + "]");
        var map = document.getElementById("map[" + maproute + "]");
        var valid = regex.test(this.value);
        if (valid == false) {
            // locastyle.modal.open("#registerNewAddress");
            $('#registerNewAddress').addClass('ls-modal ls-opened')
                .attr('data-backdrop', 'static')
                .attr('data-keyboard', 'false')
                .attr('data-modal-blocked', '')
                .attr('aria-hidden', 'false')
                .attr('role', 'dialog')
                .attr('tabindex', '-1');
            resetInput()
            $inputForm = "txtOrigem[" + maproute + "]";
            $inputValidForm = "origemValid[" + maproute + "]";
        } else {
            map.setAttribute('src', 'https://maps.google.com/maps?saddr=' + txtOrigem.value + '&daddr=' + txtDestino.value + '&output=embed');
        }
    });

    $('input[id="txtDestino[' + maproute + ']"]').on("change", function () {
        var txtOrigem = document.getElementById("txtOrigem[" + maproute + "]");
        var txtDestino = document.getElementById("txtDestino[" + maproute + "]");
        var map = document.getElementById("map[" + maproute + "]");
        var valid = regex.test(this.value);
        if (valid == false) {
            // locastyle.modal.open("#registerNewAddress");
            $('#registerNewAddress').addClass('ls-modal ls-opened')
                .attr('data-backdrop', 'static')
                .attr('data-keyboard', 'false')
                .attr('data-modal-blocked', '')
                .attr('aria-hidden', 'false')
                .attr('role', 'dialog')
                .attr('tabindex', '-1');
            resetInput()
            $inputForm = "txtDestino[" + maproute + "]";
            $inputValidForm = "destinoValid[" + maproute + "]";

        } else {
            map.setAttribute('src', 'https://maps.google.com/maps?saddr=' + txtOrigem.value + '&daddr=' + txtDestino.value + '&output=embed');
        }
    });
}

function resetInput() {
    var publicPlace = document.getElementById("publicPlace");
    var numberPoint = document.getElementById("numberPoint");
    var neighborhood = document.getElementById("neighborhood");
    var city = document.getElementById("city");
    publicPlace.value = '';
    numberPoint.value = '';
    neighborhood.value = '';
    city.value = '';
}

function setInputValueForm($inputForm, $inputValidForm) {
    var publicPlace = document.getElementById("publicPlace");
    var numberPoint = document.getElementById("numberPoint");
    var neighborhood = document.getElementById("neighborhood");
    var lat;
    var lng;
    var city = document.getElementById("city");
    var inputForm = document.getElementById($inputForm);
    var inputValidForm = document.getElementById($inputValidForm);

    var dataForm = publicPlace.value + ", " + numberPoint.value + " " + neighborhood.value + ", " + city.value;
    const settings = {
        "async": true,
        "crossDomain": true,
        "url": "https://trueway-geocoding.p.rapidapi.com/Geocode?address=" + dataForm + "&language=pt-br",
        "method": "GET",
        "headers": {
            "x-rapidapi-key": "93aee0b233msh27655e4afe508bap1e1f3cjsn5d2ff066ef84",
            "x-rapidapi-host": "trueway-geocoding.p.rapidapi.com"
        }
    };

    $.ajax(settings).done(function (response) {
        if (response) {
            lat = response.results[0].location.lat;
            lng = response.results[0].location.lng;
            inputValidForm.value = publicPlace.value + " " + numberPoint.value + " " + neighborhood.value + ", " + city.value + "/" + lat + "/" + lng;
            inputForm.value = dataForm;
        } else {
            alert("Endereço informado não existe");
        }
    });

    formValid();
}

function dismissModal($inputForm) {
    $('#registerNewAddress').removeClass('ls-opened');
    var inputForm = document.getElementById($inputForm);
    // inputForm.value = '';
}

////////////////////////////////////// DataList
var adress = [];
var addr = [];

var txtOrigem0 = document.getElementById("txtOrigem[0]");
var wizards_origem0 = document.getElementById("wizards-origem[0]");
var wizards_destino0 = document.getElementById("wizards-destino[0]");

function adressCount(item) {
    adress.push(item.acronym + " " + item.slug_adress.replace(/-/g, ' '));
}
adressServ.forEach(adressCount);

function optionDynamic(item) {
    wizards_origem0.innerHTML += `<option>` + item + `</option>`;
    wizards_destino0.innerHTML += `<option>` + item + `</option>`;
}
adress.forEach(optionDynamic);

function loadOptionsAutoCompleteSelect() {
    var wizards_origem1 = document.getElementById("wizards-origem[1]");
    var wizards_destino1 = document.getElementById("wizards-destino[1]");
    var wizards_origem2 = document.getElementById("wizards-origem[2]");
    var wizards_destino2 = document.getElementById("wizards-destino[2]");
    var wizards_origem3 = document.getElementById("wizards-origem[3]");
    var wizards_destino3 = document.getElementById("wizards-destino[3]");

    function optionDynamic(item) {
        wizards_origem1 === null ? wizards_origem1 = '' : wizards_origem1.innerHTML += `<option>` + item + `</option>`;
        wizards_destino1 === null ? wizards_destino1 = '' : wizards_destino1.innerHTML += `<option>` + item + `</option>`;
        wizards_origem2 === null ? wizards_origem2 = '' : wizards_origem2.innerHTML += `<option>` + item + `</option>`;
        wizards_destino2 === null ? wizards_destino2 = '' : wizards_destino2.innerHTML += `<option>` + item + `</option>`;
        wizards_origem3 === null ? wizards_origem3 = '' : wizards_origem3.innerHTML += `<option>` + item + `</option>`;
        wizards_destino3 === null ? wizards_destino3 = '' : wizards_destino3.innerHTML += `<option>` + item + `</option>`;
    }
    adress.forEach(optionDynamic);
}
/////////////////////////////////////////////////////////////////////////

function formValid() {
    var publicPlace = document.getElementById("publicPlace");
    var numberPoint = document.getElementById("numberPoint");
    var neighborhood = document.getElementById("neighborhood");
    var resultAddress = document.getElementsByName("resultAddress")
    console.log(resultAddress)
    var city = document.getElementById("city");
    var addressString = publicPlace.value + ", " + numberPoint.value + " - " + neighborhood.value + ", " + city.value;

    if (!publicPlace.checkValidity()
        || !neighborhood.checkValidity()
        || !city.checkValidity()
        || !resultAddress.checked
    ) {
        document.getElementById("publicPlaceMessageError").innerHTML = publicPlace.validationMessage;
        document.getElementById("neighborhoodMessageError").innerHTML = neighborhood.validationMessage;
        document.getElementById("cityMessageError").innerHTML = city.validationMessage;
        document.getElementById("inputAddressMessageError").innerHTML = `Marque o edereço correto.`;
    } 
    // else {
    //     var messageConfirmeAddress = confirm(`Confirme se o endereço está correto.\n` + addressString + ``);
    //     if (messageConfirmeAddress) {
    //         dismissModal();
    //     }
    // }
}

function verifyAddress() {
    var publicPlace = document.getElementById("publicPlace");
    var neighborhood = document.getElementById("neighborhood");
    var city = document.getElementById("city");
    var list = document.getElementById("list-address")

    list.innerHTML = '';
    (async () => {
        const where = encodeURIComponent(JSON.stringify({
            "CEP": {
                "$exists": true
            },
            "logradouro": {
                "$regex": `${publicPlace.value}`
            },
            "bairro": {
                "$regex": `${neighborhood.value}`
            },
            "cidade": {
                "$regex": `${city.value}`
            },
            "estado": {
                "$regex": `CE`
            }
        }));

        const response = await fetch(
            `https://parseapi.back4app.com/classes/Cepcorreios_CEP?order=logradouro,numero&where=${where}`,
            {
                headers: {
                    'X-Parse-Application-Id': 'HOxsKJKX4pMCPj8mlONa3ZlEO3nascw1hpiev4Ob', // This is your app's application id
                    'X-Parse-REST-API-Key': '5EruqeHQgoUkhAMp4iSBD3Q6Z5h9lDo40L8Brb2H', // This is your app's REST API key
                }
            }
        );
        const data = await response.json(); // Here you have the data that you need
        console.log(JSON.stringify(data, null, 2));

        if(data.results.length > 0){
            list.setAttribute('class', 'ls-alert-info')
            data.results.forEach(address => {
                var stringAddress = `${address.logradouro} - ${address.bairro}, ${address.cidade} - ${address.estado}, ${address.CEP}`
                list.innerHTML += '<input type="radio" name="resultAddress" id="' + stringAddress + '" name="addr" value="' + stringAddress + '"><label for="' + stringAddress + '">' + stringAddress + '</label><br>'
            })
        } else {
            list.setAttribute('class', 'ls-alert-danger')
            list.innerHTML = `<label>Endereço NÃO encontrado! Digite um endereço válido.</label>`
        }



    })();
}