function canvasToImage(canvasId) {
    var canvas = document.getElementById(canvasId);
    var imgData = canvas.toDataURL("image/png");
    return imgData;
}

var tamanioImage = canvasToImage('tamanioChart');
var pesoImage = canvasToImage('pesoChart');

$.ajax({
    url: '/app/Http/Controllers/PdfController',
    type: 'POST',
    data: {
        tamanioImage: tamanioImage,
        pesoImage: pesoImage
    },
    success: function(response) {
        console.log(response);
    }
});