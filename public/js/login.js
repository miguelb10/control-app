function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
}

var input = document.getElementById('ruc');
input.addEventListener('input', function() {
    if (this.value.length > 11)
        this.value = this.value.slice(0, 11);
})

var input = document.getElementById('ccod_traba');
input.addEventListener('input', function() {
    if (this.value.length > 8)
        this.value = this.value.slice(0, 8);
})