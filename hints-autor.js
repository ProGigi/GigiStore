let configAutor = {
    inputs: [
        'input[name=bookAutor]',
        'input[name=bookAutor0]',
        'input[name=bookAutor1]',
        'input[name=bookAutor2]',
        'input[name=bookAutor3]',
        'input[name=bookAutor4]',
        'input[name=bookAutor5]',
        'input[name=bookAutor6]',
        'input[name=bookAutor7]',
        'input[name=bookAutor8]',
        'input[name=bookAutor9]',
        'input[name=bookAutor10]',
        'input[name=bookAutor11]',
        'input[name=bookAutor12]'
    ], // Pola wpisywania
    maxLimit:           0,                      // 0 = nolimit
    reactToFocus:       true,                   // Czy ma reagować na kliknięcie w pole
    reactToTyping:      true,                   // Czy ma reagować na wpisywanie
    hintsUrl:           "get-autor.php",          // Link do pliku z podpowiedziami
    autoFocus:          false,                   // Auto focus na pole
    searchDelay:        10,                    // Opóźnienie wyszukiwania po kliknięciu klawisza
};
// Pobieranie hintsAutor i pracowników
$(document).ready(function(){
    hintsAutor();
    configAutor.inputs.forEach((e,i) => {
        $(e).on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
    })
    if (configAutor.autoFocus) {
        $(configAutor.inputs[0]).focus();
    }
});
function performFillAutor(value) {
    getUserAutor(value);
}
function getUserAutor(id) {
    $.ajax({
        url: configAutor.hintsUrl,
        type: 'POST',
        data: {
            action: 'getData',
            idAutor: id
        },
        success: function(response) {
            //console.log('success ');
            var array = $.parseJSON(response);
            //console.log(array);
            $('#Firma').val(array.ImieNazwisko);
            $('#bookAutorID').val(array.Id_Autor);
            //console.log('end success');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('error: '+textStatus);
        }
    });
}
function hintsAutor() {
    var hintsAutor = [];
    $.ajax({
        url: configAutor.hintsUrl, // <- link z konfiguracji
        type: 'POST',
        data: {
            idAutor: 0,
            action: 'getHints'
        },
        success: function(response) {
            console.log(response);
            var array = $.parseJSON(response);
            $.each(array, function(i, e){
                var obj = {
                    label: e.Id_Autor + ' ' + e.Name_Autor+' '+e.SName_Autor,
                    value: e.Id
                };
                hintsAutor.push(obj);
            });
        },
        error: function() {
            console.log('error: Cant get hints!');
        }
    });
    if (configAutor.reactToFocus) {
        configAutor.inputs.forEach((e,i) => {
            $(e).autocomplete({
                source: hintsAutor,
                minLength: 0,
                delay: configAutor.searchDelay,
                select: function (event, ui) {
                    setTimeout(function() {
                        $(e).val(ui.item.label);
                        performFillAutor(ui.item.value);
                    }, 200);
                }
            }).on('focus', function() {            
                $(e).autocomplete("search", "");
            });
        })
    }
    if (configAutor.reactToTyping) {
        configAutor.inputs.forEach((e,i) => {
            $(e).autocomplete({
                source: hintsAutor,
                minLength: (configAutor.reactToFocus) ? 0 : 1,
                autoFocus: configAutor.autoFocus,
                delay: configAutor.searchDelay,
                select: function (event, ui) {
                    setTimeout(function() {
                        $(e).val(ui.item.label);
                        performFillAutor(ui.item.value);
                    }, 200);
                }
            })
        })
    }
    // Nadpisanie funkcji filtrowania
    // dodany znak ^ oznaczający początek wyrazu
    $.ui.autocomplete.filter = function (array, term) {
        // console.log('term: '+term);
        var str = $.ui.autocomplete.escapeRegex(term).replace(/[\(].*[\)]/gi, "");
        var matcher = new RegExp("(^|\\s)" + str, "i");
        // console.log('matcher: ' + matcher);
        if (configAutor.maxLimit == 0) {
            return $.grep(array, function (value) {
                return matcher.test(value.label || value.value || value);
            });
        } else {
            return $.grep(array, function (value) {
                return matcher.test(value.label || value.value || value);
            }).slice(0,configAutor.maxLimit);
        }
    };
}