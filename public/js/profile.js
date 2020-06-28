function soloNumeros(e) {
    var key = window.Event ? e.which : e.keyCode
    return (key >= 48 && key <= 57)
}

var input = document.getElementById('cndni_traba');
input.addEventListener('input', function() {
    if (this.value.length > 8)
        this.value = this.value.slice(0, 8);
})

var input = document.getElementById('cnruc_traba');
input.addEventListener('input', function() {
    if (this.value.length > 11)
        this.value = this.value.slice(0, 11);
})